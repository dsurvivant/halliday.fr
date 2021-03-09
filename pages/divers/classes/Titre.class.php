<?php
//
//michemuche62
//made in rock'n'roll   
    class Titre
    {
        //variables de description de l'utilisateur
        private $_noTitre;
        private $_nomTitre;
        private $_parolesTitre; //personne(s) qui a(on) écrit la chanson
        private $_musiqueTitre; //personne qui a fait la musique
        private $_texteTitre; //texte de la chanson
        
        
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
        
        public function setNoTitre($noTitre)
        {
            $this->_noTitre = $noTitre;
        }

        public function setNomTitre($nomTitre)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($nomTitre))
            {
                $this->_nomTitre = $nomTitre;
            }
        }

        public function setParolesTitre($parolesTitre)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($parolesTitre))
            {
                $this->_parolesTitre = $parolesTitre;
            }
        }

        public function setMusiqueTitre($musiqueTitre)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($musiqueTitre))
            {
                $this->_musiqueTitre = $musiqueTitre;
            }
        }
        
        public function setTexteTitre($texteTitre)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($texteTitre))
            {
                $this->_texteTitre = $texteTitre;
            }
        }
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoTitre()
        {
            return $this->_noTitre;
        }
        public function getNomTitre()
        {
            return $this->_nomTitre;
        }
        
        public function getParolesTitre()
        {
            return $this->_parolesTitre;
        }

        public function getMusiqueTitre()
        {
            return $this->_musiqueTitre;
        }

        public function getTexteTitre()
        {
            return $this->_texteTitre;
        }
    }