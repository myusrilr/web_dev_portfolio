<?php
    include "../database/database.php";
    
    class Read extends Database{
        
        public function username($text){
            $sql="SELECT * FROM `mahasiswa` WHERE username='$text'";
            $runSql=$this->conn->query($sql);
            $row=mysqli_num_rows($runSql);

            if($row>0){
                return true;
            }else{
                return false;
            }
        
        
        } 
        public function password($text){
            $sql="SELECT * FROM `mahasiswa` WHERE pass='$text'";
            $runSql=$this->conn->query($sql);
            $row=mysqli_num_rows($runSql);

            if($row>0){
                return true;
            }else{
                return false;
            }

        }
        public function userPassword($usr,$pswd){
            $sql="SELECT * FROM `mahasiswa` WHERE username='$usr' and pass='$pswd'";
            $runSql=$this->conn->query($sql);
            $row=mysqli_num_rows($runSql);

            if($row>0){
                return true;
            }else{
                return false;
            }
        }
    }

    

?>