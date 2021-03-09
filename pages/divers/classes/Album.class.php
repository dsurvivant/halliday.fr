<?php
//
//michemuche62
//made in rock'n'roll  
    class Album
    {
        //variables de description de l'utilisateur
        private $_noAlbum;
        private $_nomAlbum;
        private $_datesortieAlbum;
        private $_typeAlbum;
        private $_noutil;
        private $_datesaisieAlbum;
        private $_formatAlbum;
        private $_labelAlbum;
        
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

        public function setNomAlbum($nomAlbum)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($nomAlbum))
            {
                $this->_nomAlbum = $nomAlbum;
            }
        }

        public function setdatesortieAlbum($datesortieAlbum)
        {
            $this->_datesortieAlbum = $datesortieAlbum;
        }
        
        public function setTypeAlbum($typeAlbum)
        {
            $this->_typeAlbum = $typeAlbum;
        }
        
        public function setNoutil($noutil)
        {
            $this->_noutil = $noutil;
        }
        
        public function setDatesaisieAlbum($datesaisieAlbum)
        {
            $this->_datesaisieAlbum = $datesaisieAlbum;
        }
        
        public function setFormatAlbum($formatAlbum)
        {
            $this->_formatAlbum = $formatAlbum;
        }

        public function setProducteurAlbum($producteurAlbum)
        {
            $this->_producteurAlbum = $producteurAlbum;
        }

        public function setReferenceAlbum($referenceAlbum)
        {
            $this->_referenceAlbum = $referenceAlbum;
        }

        public function setlabelAlbum($labelAlbum)
        {
            $this->_labelAlbum = $labelAlbum;
        }
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoAlbum()
        {
            return $this->_noAlbum;
        }
        public function getNomAlbum()
        {
            return $this->_nomAlbum;
        }

        public function getdatesortieAlbum()
        {
            return $this->_datesortieAlbum;
        }
        
        public function getTypeAlbum()
        {
            return $this->_typeAlbum;
        }
        
        public function getNoutil()
        {
            return $this->_noutil;
        }
        
        public function getDatesaisieAlbum()
        {
            return $this->_datesaisieAlbum;
        }
        
        public function getFormatAlbum()
        {
            return $this->_formatAlbum;
        }
        
        public function getProducteurAlbum()
        {
            return $this->_producteurAlbum;
        }

        public function getReferenceAlbum()
        {
            return $this->_referenceAlbum;
        }

        public function getlabelAlbum()
        {
            return $this->_labelAlbum;
        }
    }