<?php

// fevrier 2021

class FormatsAlbumsManager
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
        * [Ajout de nouveaux formats dans la table des formats]
        * @param 
        */
        public function add(FormatAlbum $formatalbum)
        {
            $q = $this->_db->prepare('INSERT INTO formatalbum(noformatAlbum, formatAlbum) VALUES(:noformatAlbum, :formatAlbum)');
                    
            $q->bindValue(':noformatAlbum', $formatalbum->getNoformatalbum());
            $q->bindValue(':formatAlbum', $formatalbum->getFormatalbum());
                   
            $q->execute();  
        }
        
        /**
         * [Mis à jour des formats album]
         * 
         */
        public function update(FormatAlbum $formatalbum) 
        {
            $q = $this->_db->prepare('UPDATE formatalbum SET noformatAlbum=:noformatAlbum, formatAlbum=:formatAlbum WHERE 1');
                
            $q->bindValue(':noformatAlbum', $formatalbum->getNoformatalbum());
            $q->bindValue(':formatAlbum', $formatalbum->getFormatalbum());

            $q->execute();
        }

        /**
         * [recherche les droits liés à un utilisateur description]
         * @param  Droits $droits [description]
         * @return [type]         [description]
         */
        public function listFormatAlbum()
        {
            $formatsAlbums = [];

            $q = $this->_db->query('SELECT * FROM formatalbum ORDER BY noformatAlbum');

            while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
              $formatsAlbums[] = new FormatAlbum($donnees);
            }

            return $formatsAlbums;
        
        }
    }
?>