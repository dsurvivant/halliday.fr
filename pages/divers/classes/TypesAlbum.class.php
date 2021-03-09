<?php
//
//michemuche62
//made in rock'n'roll    
    class TypesAlbum
    {
        //variables de description de l'utilisateur
        private $_notypeAlbum;
        private $_typeAlbum;
        
        
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
        
        public function setNotypeAlbum($notypeAlbum)
        {
            $this->_notypeAlbum = $notypeAlbum;
        }

        public function setTypeAlbum($typeAlbum)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($typeAlbum))
            {
                $this->_typeAlbum = $typeAlbum;
            }
        }
        
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNotypeAlbum()
        {
            return $this->_notypeAlbum;
        }
        public function getTypeAlbum()
        {
            return $this->_typeAlbum;
        }
        
    }
