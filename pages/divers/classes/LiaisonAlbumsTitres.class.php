<?php
//
//michemuche62
//made in rock'n'roll
    class LiaisonAlbumsTitres
    {
        //variables de description de l'utilisateur
        private $_noAlbum;
        private $_noTitre;
        private $_dureeTitre;
        private $_noPiste;
        private $_noDisque;
        
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
        public function setNoAlbum($noAlbum)
        {
            $this->_noAlbum = $noAlbum;
        }
        
        public function setNoTitre($noTitre)
        {
            $this->_noTitre = $noTitre;
        }
        
        public function setDureeTitre($dureeTitre)
        {
            $this->_dureeTitre = $dureeTitre;
        }
        
        public function setNoPiste($noPiste)
        {
            $this->_noPiste = $noPiste;
        }
        
        public function setNoDisque($noDisque)
        {
            $this->_noDisque = $noDisque;
        }
        
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoAlbum()
        {
            return $this->_noAlbum;
        }
        
        public function getNoTitre()
        {
            return $this->_noTitre;
        }
        
        public function getDureeTitre()
        {
            return $this->_dureeTitre;
        }
        
        public function getNoPiste()
        {
            return $this->_noPiste;
        }
        
        public function getNoDisque()
        {
            return $this->_noDisque;
        }
        
    }