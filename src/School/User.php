<?php

    namespace App\School;

     abstract class User{
        const MYSCHOOL="CEFPNutria";
        protected string $email="test@test.com";
        protected string $name;
        protected string $password;
        protected ?\DateTime $createdAt=null;
        protected ?\DateTime $updatedAt=null;


        function __construct($email,$name){
            $this->email=$email;
            $this->name=$name;
        }

        function setEmail(string $email){
            $this->email=$email;
            return $this;
        }

        function getEmail(){
            return $this->email;
        }

        
    }