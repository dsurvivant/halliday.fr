<?php
//
//michemuche62
//made in rock'n'roll 
//fevrier 2021
// 
    class Droits
    {
        //variables de description de l'utilisateur
        private $_noutil;
        private $_ajoutalbum;
        private $_modifieralbum;
        private $_supprimeralbum;
        private $_modifierinfostitre;
        private $_modifierparolestitre;
        private $_administrateur;
        
        public function __construct($donnees)
        {
            $this->hydrate($donnees);
        }
        
        public function hydrate(array $donnees)
        {
            foreach ($donnees as $key => $value)
            {
                //on récupère le nom du setter correspondant à l'attribut
                $method = 'set'.ucfirst($key);
                
                //si le setter correspondant existe
                if (method_exists($this, $method))
                {
                    //on appelle le setter
                    $this->$method($value);
                }
                
            }
        }
        
        //========================
        //== SETTERS (MUTATEURS)
        //========================
        
        public function setNoutil($noutil) { $this->_noutil = $noutil; }
        public function setAjoutalbum($ajoutalbum) { $this->_ajoutalbum = $ajoutalbum; }
        public function setModifieralbum($modifieralbum) { $this->_modifieralbum = $modifieralbum; }
        public function setSupprimeralbum($supprimeralbum) { $this->_supprimeralbum = $supprimeralbum; }
        public function setModifierinfostitre($modifierinfostitre) { $this->_modifierinfostitre = $modifierinfostitre; }
        public function setModifierparolestitre($modifierparolestitre) { $this->_modifierparolestitre = $modifierparolestitre; }
        public function setAdministrateur($administrateur) { $this->_administrateur = $administrateur; }
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoutil(){ return $this->_noutil; }
        public function getAjoutalbum(){ return $this->_ajoutalbum; }
        public function getModifieralbum(){ return $this->_modifieralbum; }
        public function getSupprimeralbum(){ return $this->_supprimeralbum; }
        public function getModifierinfostitre(){ return $this->_modifierinfostitre; }
        public function getModifierparolestitre(){ return $this->_modifierparolestitre; }
        public function getAdministrateur(){ return $this->_administrateur; }
       
    }