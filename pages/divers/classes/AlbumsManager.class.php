<?php
//
//michemuche62
//  Contenu:
// ** AJOUT/MODIF/SUPP
//      - Ajouter un album: add(Album $album) ==>return $idAlbum;
//      - Mettre à jour un album: update(Album $album)
//      - Supprimer un album: delete(Album $album)
// 
// ** TRI     
//      - LISTE DES ALBUMS CLASSES PAR NO ALBUM ASCENDANT : getListNoAsc() ==> return $albums;
//      - LISTE DES ALBUMS CLASSES PAR NO ALBUM DESC : getListNoDesc()  ==> return $albums;
//      - LISTE DES ALBUMS CLASSE PAR ANNEE ASCENDANT: getListAnneeAsc() ==> return $albums;
//      - LISTE DES ALBUMS CLASSE PAR ANNEE DESCENDANT: getListAnneeDesc() ==> return $albums;
//      - LISTE DES ALBUMS CLASSE PAR NOM ASCENDANT: getListNomAlbumAsc() ==> return $albums;
//      - LISTE DES ALBUMS CLASSE PAR NOM DESCENDANT: getListNomAlbumDesc() ==> return $albums;
//
// ** RECHERCHES
//      - RECHERCHE D'UN ALBUM A PARTIR DE SON NUMERO: findNoAlbum(Album $album)
//      - RECHERCHE SI L'ALBUM EXISTE DEJA: existAlbum(Album $album) ==> return false (n'existe pas) / (existe déjà)
//      - RECHERCHE libellé type album (ds table typesalbum): libelletypeAlbum(Album $album) ==> return $resultat['typeAlbum'];
//      - RECHERCHE libellé format album (ds la table typesalbum): libelleformatAlbum(Album $album) 
//                                                                                      ==> return  $resultat['formatAlbum'];
//      - RECHERCHE DU NOMBRE D'ALBUM (retourne le nombre d'album): getnombreAlbums() ==> return $nb;


    class AlbumsManager
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
 
 /*****                 **/
 /** Ajout/modif/supp   **/
 /*****                 **/

        //=====
        //== AJOUTER UN ALBUM
        //=====
            public function add(Album $album) //retourne l'id de l'album créé automatiquement par sql
            {
                $q = $this->_db->prepare('INSERT INTO albums(nomAlbum, datesortieAlbum, typeAlbum, datesaisieAlbum, noutil, formatAlbum, producteurAlbum, referenceAlbum, labelAlbum, descriptionAlbum, pochetteAlbum, certificationsAlbum,musiciensAlbum, enregistrementAlbum) 
                    VALUES(:nomAlbum, :datesortieAlbum, :typeAlbum, :datesaisieAlbum, :noutil, :formatAlbum, :producteurAlbum, :referenceAlbum, :labelAlbum, :descriptionAlbum, :pochetteAlbum, :certificationsAlbum,:musiciensAlbum, :enregistrementAlbum)');
                    
                $q->bindValue(':nomAlbum', $album->getnomAlbum());
                $q->bindValue(':datesortieAlbum', $album->getdatesortieAlbum());
                $q->bindValue(':typeAlbum', $album->gettypeAlbum());
                $q->bindValue(':noutil', $album->getnoutil());
                $q->bindValue(':datesaisieAlbum', $album->getdatesaisieAlbum());
                $q->bindValue(':formatAlbum', $album->getformatAlbum());
                $q->bindValue(':producteurAlbum', $album->getproducteurAlbum());
                $q->bindValue(':referenceAlbum', $album->getReferenceAlbum());
                $q->bindValue(':labelAlbum', $album->getlabelAlbum());
                $q->bindValue(':descriptionAlbum', $album->getDescriptionAlbum());
                $q->bindValue(':pochetteAlbum', $album->getPochetteAlbum());
                $q->bindValue(':certificationsAlbum', $album->getCertificationsAlbum());
                $q->bindValue(':musiciensAlbum', $album->getMusiciensAlbum());
                $q->bindValue(':enregistrementAlbum', $album->getEnregistrementAlbum());

                $q->execute();  
                
                $bdd = $this->_db;
                $idAlbum = $bdd->lastInsertId();
                return $idAlbum; //retourne l'id créé pour l'album
            }
        
        //=====
        //== METTRE A JOUR UN ALBUM
        //=====
            public function update(Album $album) 
            {
                $q = $this->_db->prepare('UPDATE albums SET nomAlbum=:nomAlbum, datesortieAlbum=:datesortieAlbum, typeAlbum=:typeAlbum, datesaisieAlbum=:datesaisieAlbum, noutil=:noutil, formatAlbum=:formatAlbum, producteurAlbum=:producteurAlbum, referenceAlbum=:referenceAlbum, labelAlbum=:labelAlbum, descriptionAlbum=:descriptionAlbum, pochetteAlbum=:pochetteAlbum, certificationsAlbum=:certificationsAlbum, musiciensAlbum=:musiciensAlbum, enregistrementAlbum=:enregistrementAlbum WHERE noAlbum=:noAlbum');
                    
                $q->bindValue(':nomAlbum', $album->getnomAlbum());
                $q->bindValue(':datesortieAlbum', $album->getdatesortieAlbum());
                $q->bindValue(':typeAlbum', $album->gettypeAlbum());
                $q->bindValue(':datesaisieAlbum', $album->getDatesaisieAlbum());
                $q->bindValue(':noutil', $album->getNoutil());
                $q->bindValue(':formatAlbum', $album->getformatAlbum());
                $q->bindValue(':noAlbum', $album->getnoAlbum());
                $q->bindValue(':producteurAlbum', $album->getproducteurAlbum());
                $q->bindValue(':referenceAlbum', $album->getReferenceAlbum());
                $q->bindValue(':labelAlbum', $album->getlabelAlbum());
                $q->bindValue(':descriptionAlbum', $album->getDescriptionAlbum());
                $q->bindValue(':pochetteAlbum', $album->getPochetteAlbum());
                $q->bindValue(':certificationsAlbum', $album->getCertificationsAlbum());
                $q->bindValue(':musiciensAlbum', $album->getMusiciensAlbum());
                $q->bindValue(':enregistrementAlbum', $album->getEnregistrementAlbum());

                $q->execute();
            }
        
        //=====
        //== SUPPRIMER UN ALBUM
        //=====
            public function delete(Album $album)
            {
                $q = $this->_db->prepare('DELETE FROM albums WHERE noAlbum=:noAlbum');
                    
                $q->bindValue(':noAlbum', $album->getnoAlbum());
                
                $q->execute();       
            }
        
/*****                             **/
 /** LISTES ALBUMS PAR CRITERES   **/
 /*****                          **/ 
        //=====
        //== LISTE DES ALBUMS CLASSES PAR NO ALBUM ASCENDANT
        //=====
            public function getListNoAsc() //retourne la liste des albums classé par no d'album
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY noAlbum ASC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSES PAR NO ALBUM DESC
        //=====
            public function getListNoDesc() //retourne la liste des albums classé par no d'album
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY noAlbum DESC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSE PAR ANNEE ASCENDANT
        //=====
            public function getListAnneeAsc() //retourne la liste des albums 
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY datesortieAlbum ASC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSE PAR ANNEE DESCENDANT
        //=====
            public function getListAnneeDesc() //retourne la liste des albums 
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY datesortieAlbum DESC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSE PAR ANNEE ASCENDANT ET PAR TYPE (studio, live, compil...)
        //=====
            public function getListAnneeTypeAsc() //retourne la liste des albums 
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY typeAlbum ASC , datesortieAlbum ASC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSE PAR NOM ASCENDANT
        //=====
            public function getListNomAlbumAsc() //retourne la liste des albums 
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY nomAlbum ASC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }

        //=====
        //== LISTE DES ALBUMS CLASSE PAR NOM DESCENDANT
        //=====
            public function getListNomAlbumDesc() //retourne la liste des albums 
            {
                $albums = [];

                $q = $this->_db->query('SELECT * FROM albums ORDER BY nomAlbum DESC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $albums[] = new Album($donnees);
                }

                return $albums;
            }        
  
 /*****            **/
 /** RECHERCHES   **/
 /*****          **/      
        //=====
        //== RECHERCHE D'UN ALBUM A PARTIR DE SON NUMERO
        //=====
            public function findNoAlbum(Album $album)
            {
                $q = $this->_db->prepare('SELECT * FROM albums WHERE noAlbum=:noAlbum');
                $q->bindValue(':noAlbum', $album->getNoAlbum());
                $q->execute();
                
                $donnees = $q->fetch();
                $album->hydrate($donnees);
            }

        //=====
        //== RECHERCHE SI L'ALBUM EXISTE DEJA
        //=====
            public function existAlbum(Album $album)
            {   //retourne true si l'album existe, false s'il n'existe pas
                $q = $this->_db->prepare('SELECT COUNT(*) AS nb FROM albums WHERE nomAlbum = :nomAlbum');
                $q->bindValue(':nomAlbum', $album->getNomAlbum());
                $q->execute();

                $columns = $q->fetch();
                $nb = $columns['nb'];

                if ($nb==0) //l'album n'existe pas
                {return false;}
                else //l'album existe
                {return true;}

            }
        
        //=====
        //== RECHERCHE libellé type album (dans la table typesalbum)
        //=====
            public function libelletypeAlbum(Album $album)
            {
                $q = $this->_db->prepare('SELECT * FROM typesalbum WHERE notypeAlbum=:typeAlbum');
                    
                $q->bindValue(':typeAlbum', $album->gettypeAlbum());
                $q->execute();
                
                $resultat = $q->fetch();
                return $resultat['typeAlbum'];
            }
        
        //=====
        //== RECHERCHE libellé format album (dans la table typesalbum)
        //=====
            public function libelleformatAlbum(Album $album)
            {
                $q = $this->_db->prepare('SELECT * FROM formatalbum WHERE noformatAlbum=:formatAlbum');
                    
                $q->bindValue(':formatAlbum', $album->getformatAlbum());
                $q->execute();
                
                $resultat = $q->fetch();
                return $resultat['formatAlbum'];
            }

        //=====
        //== RECHERCHE DU NOMBRE D'ALBUM (retourne le nombre d'album)
        //=====
            public function getnombreAlbums()
            {
                $req = $this->_db->prepare('SELECT COUNT(*) AS nb FROM albums');
                $req->execute();
                $columns = $req->fetch();
                $nb = $columns['nb'];
                return $nb;
            }

    }
?>