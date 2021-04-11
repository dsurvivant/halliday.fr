<?php

/**
 * MICHEMUCHE AVRIL 2021
 */

 class FormatAlbum
    {
        //variables de description de l'utilisateur
        private $_noformatalbum;
        private $_formatalbum;
        
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
        
        public function setNoformatalbum($noformatalbum) { $this->_noformatalbum = $noformatalbum; }
        public function setFormatalbum($formatalbum) { $this->_formatalbum = $formatalbum; }

        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoformatalbum(){ return $this->_noformatalbum; }
        public function getFormatalbum(){ return $this->_formatalbum; }
    }
