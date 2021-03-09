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