<?php
    class Student {
        private $id;
        private $fname;
        private $lname;
        private $gender;
        private $email;
        private $DOB;
        private $img;
        private $Did;
        private $phNumber;
        private $password;

        public function __construct ($id,$fname,$lname,$gender,$email,$DOB,$img,$Did,$phNumber,$password){
            $this->id = $id;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->gender = $gender;
            $this->email = $email;
            $this->DOB = $DOB;
            $this->img = $img;
            $this->Did = $Did;
            $this->phNumber = $phNumber;
            $this->password = $password;
        }

        public function getId (){
            return $this->id;
        }

        public function setId ($id){
            $this->id = $id;
        }

        public function getFname (){
            return $this->fname;
        }

        public function setFname ($fname){
            $this->fname = $fname;
        }

        public function getLname (){
            return $this->lname;
        }

        public function setLname ($lname){
            $this->lname = $lname;
        }

        public function getGender (){
            return $this->gender;
        }

        public function setGender ($gender){
            $this->gender = $gender;
        }

        public function getEmail (){
            return $this->email;
        }

        public function setEmail ($email){
            $this->email = $email;
        }

        public function getDOB (){
            return $this->DOB;
        }

        public function setDOB ($DOB){
            $this->DOB = $DOB;
        }

        public function getImg (){
            return $this->img;
        }

        public function setImg ($img){
            $this->img = $img;
        }

        public function getDid (){
            return $this->Did;
        }

        public function setDid ($Did){
            $this->Did = $Did;
        }

        public function getPhNumber (){
            return $this->phNumber;
        }

        public function setPhNumber ($phNumber){
            $this->phNumber = $phNumber;
        }

        public function getPassword (){
            return $this->password;
        }

        public function setPassword ($password){
            $this->password = $password;
        }
    }
?>

<?php
    class Teacher {
        private $id;
        private $fname;
        private $lname;
        private $gender;
        private $email;
        private $img;
        private $Sid;
        private $phNumber;
        private $password;

        public function __construct ($id,$fname,$lname,$gender,$email,$img,$Sid,$phNumber,$password){
            $this->id = $id;
            $this->fname = $fname;
            $this->lname = $lname;
            $this->gender = $gender;
            $this->email = $email;
            $this->img = $img;
            $this->Sid = $Sid;
            $this->phNumber = $phNumber;
            $this->password = $password;
        }

        public function getId (){
            return $this->id;
        }

        public function setId ($id){
            $this->id = $id;
        }

        public function getFname (){
            return $this->fname;
        }

        public function setFname ($fname){
            $this->fname = $fname;
        }

        public function getLname (){
            return $this->lname;
        }

        public function setLname ($lname){
            $this->lname = $lname;
        }

        public function getGender (){
            return $this->gender;
        }

        public function setGender ($gender){
            $this->gender = $gender;
        }

        public function getEmail (){
            return $this->email;
        }

        public function setEmail ($email){
            $this->email = $email;
        }

        public function getImg (){
            return $this->img;
        }

        public function setImg ($img){
            $this->img = $img;
        }

        public function getSid (){
            return $this->Sid;
        }

        public function setSid ($Sid){
            $this->Sid = $Sid;
        }

        public function getPhNumber (){
            return $this->phNumber;
        }

        public function setPhNumber ($phNumber){
            $this->phNumber = $phNumber;
        }

        public function getPassword (){
            return $this->password;
        }

        public function setPassword ($password){
            $this->password = $password;
        }
    }
?>