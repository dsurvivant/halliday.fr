<?php
//
//michemuche62
//made in rock'n'roll
    class TypesAlbumManager
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
        
        //=====
        //== AJOUTER UN TYPE ALBUM
        //=====
        public function add(TypesAlbum $typeAlbum) //retourne l'id du type créé automatiquement par sql
        {
                $q = $this->_db->prepare('INSERT INTO typesalbum(notypeAlbum, typeAlbum) VALUES(:notypeAlbum, :typeAlbum)');
                
                $q->bindValue(':notypeAlbum', $typeAlbum->getNotypeAlbum());
                $q->bindValue(':typeAlbum', $typeAlbum->gettypeAlbum());
                $q->execute();  
            
                $bdd = $this->_db;
                $idAlbum = $bdd->lastInsertId();
                return $idtypeAlbum; //retourne l'id créé pour l'album
        }
        
        //=====
        //== METTRE A JOUR UN TYPE ALBUM
        //=====
        public function update(TypesAlbum $typeAlbum) 
        {
            $q = $this->_db->prepare('UPDATE typesalbum SET typeAlbum=:typeAlbum WHERE notypeAlbum=:notypeAlbum');
                
            $q->bindValue(':typeAlbum', $typeAlbum->getTypeAlbum());
            $q->bindValue(':notypeAlbum', $typeAlbum->getNotypeAlbum());
                
            $q->execute();
        }
        
        //=====
        //== SUPPRIMER UN TYPE ALBUM
        //=====
        public function delete(TypesAlbum $typeAlbum)
        {
            $q = $this->_db->prepare('DELETE FROM typesalbum WHERE notypeAlbum=:notypeAlbum');
                
            $q->bindValue(':notypeAlbum', $typeAlbum->getNotypeAlbum());
            
            $q->execute();       
        }
        
        //=====
        //== LISTE DES TYPES ALBUM
        //=====
        public function getList() //retourne la liste des albums
        {
            $typesAlbums = [];

            $q = $this->_db->query('SELECT * FROM typesalbum ORDER BY notypeAlbum');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              $typesAlbums[] = new TypesAlbum($donnees);
            }

            return $typesAlbums;
        }

        //=====
        //== RECHERCHE SI LE LIBELLE ALBUM EXISTE DEJA
        //=====
        public function existAlbum(TypesAlbum $typeAlbum)
        {   //retourne true si l'album existe, false s'il n'existe pas
            $q = $this->_db->prepare('SELECT COUNT(*) AS nb FROM typesalbum WHERE typeAlbum = :typeAlbum');
            $q->bindValue(':typeAlbum', $typeAlbum->getTypeAlbum());
            $q->execute();

            $columns = $q->fetch();
            $nb = $columns['nb'];

            if ($nb==0) //le libellé n'existe pas
            {return false;}
            else //le libellé existe
            {return true;}

        }
        
        //=====
        //== RECHERCHE libellé type album (dans la table typesalbum)
        //=====
        public function libelletypeAlbum(TypesAlbum $typeAlbum)
        {
            $q = $this->_db->prepare('SELECT * FROM typesalbum WHERE notypeAlbum=:notypeAlbum');
                
            $q->bindValue(':notypeAlbum', $typeAlbum->getNotypeAlbum());
            $q->execute();
            
            $resultat = $q->fetch();
            return $resultat['typeAlbum'];
        }

        //=====
        //== RECHERCHE DU NOMBRE D'ALBUM (retourne le nombre d'album)
        //=====
        public function getnombrelibelleAlbum()
        {
            $req = $this->_db->prepare('SELECT COUNT(*) AS nb FROM typesalbum');
            $req->execute();
            $columns = $req->fetch();
            $nb = $columns['nb'];
            return $nb;
        }

    }
?>