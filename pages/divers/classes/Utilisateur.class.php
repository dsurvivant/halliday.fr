<?php
//
//michemuche62
//made in rock'n'roll 
    class Utilisateur
    {
        //variables de description de l'utilisateur
        private $_noutil;
        private $_nom;
        private $_prenom;
        private $_pseudo;
        private $_motdepasse;
        //private $_droits;
        private $_email;
        private $_dateinscription;
        private $_cle;
        private $_actif;
        
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
        public function setNoutil($noutil)
        {
            $this->_noutil = $noutil;
        }
        
        public function setNom($nom)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($nom))
            {
                $this->_nom = $nom;
            }
        }
        
        public function setPrenom($prenom)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($prenom))
            {
                $this->_prenom = $prenom;
            }
        }
        
        public function setPseudo($pseudo)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($pseudo))
            {
                $this->_pseudo = $pseudo;
            }
        }
        
        public function setMotdepasse($motdepasse)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($motdepasse))
            {
                $this->_motdepasse = $motdepasse;
            }
        }
        
        public function setEmail($email)
        {
            // On vérifie qu'il s'agit bien d'une chaîne de caractères.
            if (is_string($email))
            {
                $this->_email = $email;
            }
        }

        public function setDateinscription($dateinscription)
        {
            $this->_dateinscription = $dateinscription;
        }

        public function setCle($cle)
        {
            if(is_string($cle)) { $this->_cle = $cle;}
        }

        public function setActif($actif) { $this->_actif = $actif; }
        
        //========================
        //== GETTERS (ACCESSEURS)
        //========================
        public function getNoutil()
        {
            return $this->_noutil;
        }
        public function getNom()
        {
            return $this->_nom;
        }
        
        public function getPrenom()
        {
            return $this->_prenom;
        }
        
        public function getPseudo()
        {
            return $this->_pseudo;
        }
        
        public function getMotdepasse()
        {
            return $this->_motdepasse;
        }
        
        public function getEmail()
        {
            return $this->_email;
        }

        public function getDateinscription()
        {
            return $this->_dateinscription;
        }

        public function getCle() { return $this->_cle; }

        public function getActif() { return $this->_actif; }

    }
