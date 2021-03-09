<?php
//
//michemuche62
//made in rock'n'roll
    class TitresManager
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
        //== AJOUTER UN TITRE
        //=====
        public function add(Titre $titre) //ajoute à la bdd et retourne l'id du titre créé automatiquement par sql
        {
            
            $q = $this->_db->prepare('INSERT INTO titres(nomTitre) 
                VALUES(:nomTitre)');
                
                $q->bindValue(':nomTitre', $titre->getNomTitre());
                
                $q->execute();
            
                $bdd = $this->_db;
                $idTitre = $bdd->lastInsertId();
                return $idTitre; //retourne l'id créé pour le titre
        }
        
        //=====
        //== METTRE A JOUR UN TITRE
        //=====
        
        public function update(Titre $titre) 
        {
            $q = $this->_db->prepare('UPDATE titres SET nomTitre=:nomTitre, parolesTitre=:parolesTitre, musiqueTitre=:musiqueTitre, texteTitre=:texteTitre WHERE noTitre=:noTitre');
                
            $q->bindValue(':noTitre', $titre->getNoTitre());
            $q->bindValue(':nomTitre', $titre->getNomTitre());
            $q->bindValue(':parolesTitre', $titre->getParolesTitre());
            $q->bindValue(':musiqueTitre', $titre->getMusiqueTitre());
            $q->bindValue(':texteTitre', $titre->getTexteTitre());

            $q->execute();
        }
        
        //=====
        //== SUPPRIMER UN TITRE
        //=====
        public function delete(Titre $titre)
        {
            
            $q = $this->_db->prepare('DELETE FROM titres WHERE noTitre=:noTitre');
                
            $q->bindValue(':noTitre', $perso->getNoTitre());
            
            $q->execute();       
        }

        //=====
        //== HYDRATATION DE LA CLASSE TITRE à partir du no de titre
        //=====
        public function hydrateTitre(Titre $titre)
        {
            $q = $this->_db->prepare('SELECT * FROM titres WHERE noTitre=:noTitre');
            $q->bindValue(':noTitre', $titre->getNoTitre());
            $q->execute();
            
            $donnees = $q->fetch();

            $titre->hydrate($donnees);
        }
        
        //=====
        //== RECHERCHE DU NOM DE TITRE A PARTIR DU NUMERO
        //=====
        
        public function findNomTitre(Titre $titre)
        {
            $q = $this->_db->prepare('SELECT * FROM titres WHERE noTitre=:noTitre');
            $q->bindValue(':noTitre', $titre->getNoTitre());
            $q->execute();
            
            $resultat = $q->fetch();
            return $resultat['nomTitre'];
        }
        
        //=====
        //== RECHERCHE SI LE TITRE EXISTE DEJA
        //=====
        public function existTitre(Titre $titre)
        {   //retourne true si le titre existe, false s'il n'existe pas
            $q = $this->_db->prepare('SELECT COUNT(*) AS nb FROM titres WHERE nomTitre = :nomTitre');
            $q->bindValue(':nomTitre', $titre->getNomTitre());
            $q->execute();

            $columns = $q->fetch();
            $nb = $columns['nb'];

            if ($nb==0) //l'album n'existe pas
            {return false;}
            else //l'album existe
            {return true;}

        }

        //=====
        //== RECHERCHE DU NUMERO DE TITRE A PARTIR DU TITRE
        //=====
        public function findNotitre(Titre $titre)
        {
            $q = $this->_db->prepare('SELECT * FROM titres WHERE nomTitre=:nomTitre');
            $q->bindValue(':nomTitre', $titre->getNomTitre());
            $q->execute();
            
            $resultat = $q->fetch();
            return $resultat['noTitre'];
        }

        //=====
        //== RECHERCHE DU NOMBRE DE TITRES (retourne le nombre de titres)
        //=====
        public function getnombreTitres()
        {
            $req = $this->_db->prepare('SELECT COUNT(*) AS nb FROM titres');
            $req->execute();
            $columns = $req->fetch();
            $nb = $columns['nb'];
            return $nb;
        }


        /*********************/
        /** TRI DES TITRES **/
        /*******************/

            //=====
            //== LISTE DES TITRES CLASSEMENT PAR NOM ASC
            //=====
            public function getList()
            {
                $titres = [];

                $q = $this->_db->query('SELECT * FROM titres ORDER BY nomTitre');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $titres[] = new Titre($donnees);
                }

                return $titres;
            }

            //=====
            //== LISTE DES TITRES CLASSEMENT PAR NOM DESC
            //=====
            public function getListDesc()
            {
                $titres = [];

                $q = $this->_db->query('SELECT * FROM titres ORDER BY nomTitre DESC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $titres[] = new Titre($donnees);
                }

                return $titres;
            }

            //=====
            //== LISTE DES TITRES CLASSEMENT PAR NO ASC
            //=====
            public function getListNoAsc()
            {
                $titres = [];

                $q = $this->_db->query('SELECT * FROM titres ORDER BY noTitre');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $titres[] = new Titre($donnees);
                }

                return $titres;
            }

            //=====
            //== LISTE DES TITRES CLASSEMENT PAR NO ASC
            //=====
            public function getListNoDesc()
            {
                $titres = [];

                $q = $this->_db->query('SELECT * FROM titres ORDER BY noTitre DESC');

                while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                  $titres[] = new Titre($donnees);
                }

                return $titres;
            }
    
    }
?>