<?php

    namespace App\School\Entities;

     class User{
     

        private string $email;
        private string $username;
        private string $password;
        private string $dni;
        private ?\DateTime $createdAt=null;
        private ?\DateTime $updatedAt=null;


        function __construct($username,$email,$password,$dni){
            $this->email=$email;
            $this->username=$username;
            $this->password=$password;
            $this->dni=$dni;


        }

        function setEmail(string $email){
            $this->email=$email;
            return $this;
        }

        function getEmail(){
            return $this->email;
        }

        

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Get the value of dni
         */ 
        public function getDni()
        {
                return $this->dni;
        }
    }