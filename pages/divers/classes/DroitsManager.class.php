<?php

// fevrier 2021

class DroitsManager
    {
        private $_db;
    
        /**
         * Constructeur
         * @param PDO $bdd [base de donnees en parametre]
         */
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
        * [Ajout de nouveaux droits dans la table des droits]
        * @param Droits $droits [objet Droits]
        */
        public function add(Droits $droits)
        {
            $q = $this->_db->prepare('INSERT INTO droits(noutil, ajoutalbum, modifieralbum, supprimeralbum, modifierinfostitre, modifierparolestitre, administrateur) 
                    VALUES(:noutil, :ajoutalbum, :modifieralbum, :supprimeralbum, :modifierinfostitre, :modifierparolestitre, :administrateur)');
                    
            $q->bindValue(':noutil', $droits->getNoutil());
            $q->bindValue(':ajoutalbum', $droits->getAjoutalbum());
            $q->bindValue(':modifieralbum', $droits->getModifieralbum());
            $q->bindValue(':supprimeralbum', $droits->getSupprimeralbum());
            $q->bindValue(':modifierinfostitre', $droits->getModifierinfostitre());
            $q->bindValue(':modifierparolestitre', $droits->getModifierparolestitre());
            $q->bindValue(':administrateur', $droits->getAdministrateur());
                   
            $q->execute();  
        }
        
        /**
         * [Mis à jour des droits pour un utilisateur donné]
         * @param  Droits  $droits [objet Droits]
         */
        public function update(Droits $droits) 
        {
            $q = $this->_db->prepare('UPDATE droits SET ajoutalbum=:ajoutalbum, modifieralbum=:modifieralbum, supprimeralbum=:supprimeralbum, modifierinfostitre=:modifierinfostitre, modifierparolestitre=:modifierparolestitre, administrateur=:administrateur WHERE noutil=:noutil');
                
            $q->bindValue(':ajoutalbum', $droits->getAjoutalbum());
            $q->bindValue(':modifieralbum', $droits->getModifieralbum());
            $q->bindValue(':supprimeralbum', $droits->getSupprimeralbum());
            $q->bindValue(':modifierinfostitre', $droits->getModifierinfostitre());
            $q->bindValue(':modifierparolestitre', $droits->getModifierparolestitre());
            $q->bindValue(':administrateur', $droits->getAdministrateur());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

        /**
         * Mis à jour des droits sur l'ajout d'un album
         * @param  [type] $droits [objet Droits]
         */
        public function updateajouteralbum($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET ajoutalbum=:ajoutalbum WHERE noutil=:noutil');
                
            $q->bindValue(':ajoutalbum', $droits->getAjoutalbum());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

         /**
         * Mis à jour des droits sur la modification d'un album
         * @param  [type] $droits [objet Droits]
         */
        public function updatemodifalbum($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET modifieralbum=:modifieralbum WHERE noutil=:noutil');
                
            $q->bindValue(':modifieralbum', $droits->getModifieralbum());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

         /**
         * Mis à jour des droits sur la suppression d'un album
         * @param  [type] $droits [objet Droits]
         */
        public function updatesupprimeralbum($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET supprimeralbum=:supprimeralbum WHERE noutil=:noutil');
                
            $q->bindValue(':supprimeralbum', $droits->getSupprimeralbum());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

         /**
         * Mis à jour des droits sur la modification des infos des titres
         * @param  [type] $droits [objet Droits]
         */
        public function updatemodifierinfostitre($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET modifierinfostitre=:modifierinfostitre WHERE noutil=:noutil');
                
            $q->bindValue(':modifierinfostitre', $droits->getModifierinfostitre());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

        /**
         * Mis à jour des droits sur la modification des paroles titres
         * @param  [type] $droits [objet Droits]
         */
        public function updatemodifierparolestitre($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET modifierparolestitre=:modifierparolestitre WHERE noutil=:noutil');
                
            $q->bindValue(':modifierparolestitre', $droits->getModifierparolestitre());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }

        /**
         * Mis à jour des droits sur la fonction d'administrateur
         * @param  [type] $droits [objet Droits]
         */
        public function updateadministrateur($droits)
        {
            $q = $this->_db->prepare('UPDATE droits SET administrateur=:administrateur WHERE noutil=:noutil');
                
            $q->bindValue(':administrateur', $droits->getAdministrateur());
            $q->bindValue(':noutil', $droits->getNoutil());

            $q->execute();
        }
        /**
         * [recherche les droits liés à un utilisateur description]
         * @param  Droits $droits [description]
         * @return [type]         [description]
         */
        public function findDroits(Droits $droits)
        {
            $q = $this->_db->prepare('SELECT * FROM droits WHERE noutil=:noutil');
            $q->bindValue(':noutil', $droits->getNoutil());
            $q->execute();
                
            $donnees = $q->fetch();
            $droits->hydrate($donnees);
        }
    }
?>