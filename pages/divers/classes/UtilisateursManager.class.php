<?php
//
//michemuche62
//made in rock'n'roll
    class UtilisateursManager
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
        
        /**
         * Ajout d'un nouvel utilisateur.
         * @param Utilisateur $perso [Objet Utilisateur en parametre d'entree]
         * @return   retourne l'id de l'utilisateur ajouté
         */
        public function add(Utilisateur $perso)
        {
           
            $q = $this->_db->prepare('INSERT INTO utilisateurs(prenom, nom, pseudo, motdepasse, email, cle, actif) VALUES(:prenom, :nom, :pseudo, :motdepasse, :email, :cle, :actif)');
                
                $q->bindValue(':prenom', $perso->getPrenom());
                $q->bindValue(':nom', $perso->getNom());
                $q->bindValue(':pseudo', $perso->getPseudo());
                $q->bindValue(':motdepasse', $perso->getMotdepasse());
                $q->bindValue(':email', $perso->getEmail());
                $q->bindValue(':cle', $perso->getCle());
                $q->bindValue(':actif', $perso->getActif());
                //$q->bindValue(':dateinscription', $perso->getDateinscription());
                $q->execute();  

                $bdd = $this->_db;
                $idUtilisateur = $bdd->lastInsertId();
                return $idUtilisateur;     
        }
        
        //=====
        //== METTRE A JOUR UN UTILISATEUR
        //=====
        public function update(Utilisateur $perso)
        {
            $q = $this->_db->prepare('UPDATE utilisateurs SET prenom=:prenom, nom=:nom, pseudo=:pseudo, motdepasse=:motdepasse, email=:email, actif=:actif WHERE noutil=:noutilisateur');
                
                $q->bindValue(':prenom', $perso->getPrenom());
                $q->bindValue(':nom', $perso->getNom());
                $q->bindValue(':pseudo', $perso->getPseudo());
                $q->bindValue(':motdepasse', $perso->getMotdepasse());
                $q->bindValue(':email', $perso->getEmail());
                $q->bindValue(':actif', $perso->getActif());
                $q->bindValue(':noutilisateur', $perso->getNoutil());
            
                $q->execute();       
        }

        //=====
        //== METTRE A JOUR UN UTILISATEUR SANS L INFORMATION MOT DE PASSE
        //=====
        public function updatewithoutmdp(Utilisateur $perso)
        {
            $q = $this->_db->prepare('UPDATE utilisateurs SET prenom=:prenom, nom=:nom, pseudo=:pseudo, email=:email, actif=:actif WHERE noutil=:noutilisateur');
                
                $q->bindValue(':prenom', $perso->getPrenom());
                $q->bindValue(':nom', $perso->getNom());
                $q->bindValue(':pseudo', $perso->getPseudo());
                $q->bindValue(':email', $perso->getEmail());
                $q->bindValue(':actif', $perso->getActif());
                $q->bindValue(':noutilisateur', $perso->getNoutil());
            
                $q->execute();       
        }

        //=====
        //== METTRE A JOUR MOT DE PASSE UTILISATEUR
        //=====
        public function updatePassword(Utilisateur $perso)
        {
            $q = $this->_db->prepare('UPDATE utilisateurs SET motdepasse=:motdepasse, cle=:cle WHERE email=:email');
                
                $q->bindValue(':motdepasse', $perso->getMotdepasse());
                $q->bindValue(':cle', $perso->getCle());
                $q->bindValue(':email', $perso->getEmail());
            
                $q->execute();       
        }

        //=====
        //== METTRE A JOUR LA CLE UTILISATEUR
        //=====
        public function updateCleUtilsateur(Utilisateur $perso)
        {
           
            $q = $this->_db->prepare('UPDATE utilisateurs SET cle=:cle WHERE noutil=:noutilisateur');
                
                $q->bindValue(':cle', $perso->getCle());
                $q->bindValue(':noutilisateur', $perso->getNoutil());
            
                $q->execute();       
        }
        
        //=====
        //== SUPPRIMER UN UTILISATEUR
        //=====
        public function delete(Utilisateur $perso)
        {
            
            $q = $this->_db->prepare('DELETE FROM utilisateurs WHERE noutil=:noutilisateur');
                
            $q->bindValue(':noutilisateur', $perso->getNoutil());
            
            $q->execute();       
        }
        
        //=====
        //== LISTE DES UTILISATEURS
        //=====
        public function getList()
        {
            $utilisateurs = [];

            $q = $this->_db->query('SELECT * FROM utilisateurs ORDER BY nom');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              $utilisateurs[] = new Utilisateur($donnees);
            }

            return $utilisateurs;
        }
        
        //=====
        //== INSTANCIE UN UTILISATEUR A PARTIR DU NUMERO
        //=====
        
        public function findNoUtilisateur(Utilisateur $perso)
        {
            $q = $this->_db->prepare('SELECT * FROM utilisateurs WHERE noutil=:noutilisateur');
            $q->bindValue(':noutilisateur', $perso->getNoutil());
            $q->execute();
            
            $donnees = $q->fetch();
            $perso->hydrate($donnees);

            return $perso; 
        }
        
        //=====
        //== INSTANCIE UN UTILISATEUR A PARTIR DU PSEUDO
        //=====
        public function findPseudoUtilisateur(Utilisateur $perso)
        {
            $q = $this->_db->prepare('SELECT * FROM utilisateurs WHERE pseudo=:pseudo');
                
            $q->bindValue(':pseudo', $perso->getPseudo());
            $q->execute();
            if ($donnees = $q->fetch())
            {
                $perso->hydrate($donnees);
                return true;
            }
            else //le membre n'existe pas
            {
              return false;
              //$perso->setMotdepasse('###'); //mot de passe invalide qui empêcle la connection  
            }
                       
        }

        //=====
        //== Activation d'un utilisateur à partir du pseudo
        //== clé remise à null lors de l'activation afin de neutraliser le lien mail
        //=====
        function activer(Utilisateur $util)
        {
            $q =  $this->_db->prepare("UPDATE utilisateurs SET actif = 1, cle='***' WHERE pseudo like :pseudo ");
            $q->bindValue(':pseudo', $util->getPseudo());
            $q->execute();
        }

        //=====
        //== Modification Activation d'un utilisateur à partir du numéro d'utilisateur
        //== clé remise à null lors de l'activation afin de neutraliser le lien mail
        //=====
        function activerbynoutil(Utilisateur $util)
        {
            $q =  $this->_db->prepare("UPDATE utilisateurs SET actif=:actif, cle='***' WHERE noutil=:noutil ");
            $q->bindValue(':noutil', $util->getNoutil());
            $q->bindValue(':actif', $util->getActif());
            $q->execute();
        }

        //=====
        //== RECHERCHE SI LE MAIL EXISTE ET INSTANCIE L UTILISATEUR
        //=====
        public function findEmailUtilisateur(Utilisateur $perso)
        {
            $q = $this->_db->prepare('SELECT * FROM utilisateurs WHERE email=:email');
                
            $q->bindValue(':email', $perso->getEmail());
            $q->execute();
            if ($donnees = $q->fetch())
            {
                $perso->hydrate($donnees);
                return true; //l'utilisateur existe
            }
            else //le membre n'existe pas
            {
              return false; 
            }
                       
        }

        //=====
        //== RECHERCHE SI LE PSEUDO EXISTE
        //=====
        public function existPseudo(Utilisateur $perso)
        {
            $q = $this->_db->prepare('SELECT * FROM utilisateurs WHERE pseudo=:pseudo');
                
            $q->bindValue(':pseudo', $perso->getPseudo());
            $q->execute();
            if ($donnees = $q->fetch())
            {
                return true; //l'utilisateur existe
            }
            else //le membre n'existe pas
            {
              return false; 
            }
                       
        }

        //=====
        //== RECHERCHE libellé Droits d'un utilisateur (dans la table droits)
        //=====
        /*
        public function libelleDroit(Utilisateur $perso)
        {
            $q = $this->_db->prepare('SELECT * FROM droits WHERE nodroits=:nodroit');
                
            $q->bindValue(':nodroit', $perso->getDroits());
            $q->execute();
            
            $resultat = $q->fetch();
            return $resultat['droit'];
        }
        */
        
        
        
    }
?>