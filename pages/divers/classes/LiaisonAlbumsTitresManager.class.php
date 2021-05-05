<?php
//
//michemuche62
//made in rock'n'roll
//
// ** AJOUT/MODIF/SUPP
//      - Ajouter une liaison entre un titre et un album
//      - Supprimer toutes les liaisons d'un album donné
//      
// ** RECHERCHES
//      - RECHERCHE DES NUM TITRES A PARTIR D'UN ALBUM
//      - RECHERCHE DES NUM ALBUMS A PARTIR D'UN TITRE
//      - RECHERCHE DU NOMBRE DE DISQUE DE L'ALBUM (retourne le nombre de disque)
//      - RECHERCHE D UN ALBUM ET DE SES TITRES DETAILLES
//      

    class LiaisonAlbumsTitresManager
    {
        private $_db;
    
        public function __construct(PDO $bdd)
        {
            $this->setDb($bdd);
        }
        
        //== BASE DE DONNEES
        //=====
        public function setDb(PDO $db)
        {
            $this->_db = $db;
        }
 
/*****              **/
 /** Ajout/modif   **/
 /*****           **/       
    //=====
    //== AJOUTER
    //=====
    public function add(LiaisonAlbumsTitres $liaisonalbumstitres)
    {
        $q = $this->_db->prepare('INSERT INTO liaisonalbumstitres(noAlbum, noTitre, dureeTitre, noPiste, noDisque)  VALUES(:noAlbum, :noTitre, :dureeTitre, :noPiste, :noDisque)');
                
        $q->bindValue(':noAlbum', $liaisonalbumstitres->getNoAlbum());
        $q->bindValue(':noTitre', $liaisonalbumstitres->getNoTitre());
        $q->bindValue(':dureeTitre', $liaisonalbumstitres->getDureeTitre());
        $q->bindValue(':noPiste', $liaisonalbumstitres->getNoPiste());
        $q->bindValue(':noDisque', $liaisonalbumstitres->getNoDisque());
                
        $q->execute();
    }

    //=====
    //== SUPPRIMER: suppression d'un album dans la table de liaison
    //=====
    public function delete(Album $album)
    {
        $q = $this->_db->prepare('DELETE FROM liaisonalbumstitres WHERE noAlbum=:noAlbum');

        $q->bindValue(':noAlbum', $album->getNoAlbum());

        $q->execute();
    }

/*****            **/
 /** LISTES   **/
 /*****          **/

    public function getListLiaisonTitresAlbums() //retourne la liste des albums classé par no d'album
            {
                $liaisonalbumstitres = [];

                $q = $this->_db->query('SELECT * FROM liaisonalbumstitres ORDER BY noAlbum ASC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $liaisonalbumstitres[] = new LiaisonAlbumsTitres($donnees);
                }

                return $liaisonalbumstitres;
            }
/*****            **/
 /** RECHERCHES   **/
 /*****          **/
        //=====
        //== RECHERCHE DES NUM TITRES A PARTIR D'UN ALBUM
        //=====
        public function getTitres(Album $album)
        {
            $titres = [];

            $q = $this->_db->prepare('SELECT * FROM liaisonalbumstitres WHERE noAlbum=:noAlbum  ORDER BY nodisque ASC, noPiste ASC');
            $q->bindValue(':noAlbum', $album->getNoAlbum());
            $q->execute();
            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              $titres[] = new LiaisonAlbumsTitres($donnees);
            }

            return $titres;
        }

        //=====
        //== RECHERCHE DES NUM TITRES A PARTIR D'UN ALBUM
        //=====
        public function getdetailsalbum($album)
        {
            $detailsalbum = [];

            $q = $this->_db->prepare('SELECT * FROM  titres AS t, liaisonalbumstitres AS l 
                                        WHERE l.noTitre = t.noTitre 
                                        AND noAlbum=:noAlbum 
                                        ORDER BY nodisque ASC, noPiste ASC');
            $q->bindValue(':noAlbum', $album->getNoAlbum());
            $q->execute();
            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              array_push($detailsalbum, $donnees);
            }

            return $detailsalbum;

        }

        //=====
        //== RECHERCHE DES NUM ALBUMS A PARTIR D'UN TITRE
        //=====
        public function getAlbums(Titre $titre)
        {
            $albums = [];

            $q = $this->_db->prepare('SELECT * FROM liaisonalbumstitres WHERE noTitre=:noTitre');
            $q->bindValue(':noTitre', $titre->getNoTitre());
            $q->execute();
            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              $albums[] = new LiaisonAlbumsTitres($donnees);
            }

            return $albums;
        }

        //=====
        //== RECHERCHE DU NOMBRE DE DISQUE DE L'ALBUM (retourne le nombre de disque)
        //=====

        public function getnombredisqueAlbums(Album $album)
        {
            $q = $this->_db->prepare('SELECT MAX(nodisque) AS nb FROM liaisonalbumstitres WHERE noAlbum=:noAlbum');

            $q->bindValue(':noAlbum', $album->getNoAlbum());

            $q->execute();
            
            $columns = $q->fetch();
            $nb = $columns['nb'];
            return $nb;
        }
    }
?>