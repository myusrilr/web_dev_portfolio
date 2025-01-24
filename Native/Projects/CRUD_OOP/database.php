<?php

class database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "santri_coding";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function show_data(){
        $getData = "SELECT * FROM santri";
        $data = $this->conn->query($getData);
        $arr = array();
        while($d = mysqli_fetch_assoc($data)){
            $arr[] = $d;
        }
        return $arr;
    }

    function input($nama, $alamat, $usia){
        $insertData = "INSERT INTO santri (nama, alamat, usia) VALUES ('$nama', '$alamat', '$usia')";
        $result = $this->conn->query($insertData);
        if($result){
            return true;
        } else {
            return false;
        }
    }

    function get_data($id){
        $getData = "SELECT * FROM santri WHERE id = '$id'";
        $data = $this->conn->query($getData);
        $arr = array();
        while($d = mysqli_fetch_assoc($data)){
            $arr[] = $d;
        }
        return $arr;
    }

    function update($id, $nama, $alamat, $usia){
        $updateData = "UPDATE santri SET nama = '$nama', alamat = '$alamat', usia = '$usia' WHERE id = '$id'";
        $result = $this->conn->query($updateData);
        if($result){
            return true;
        } else {
            return false;
        }
    }
    


    function hapus($id){
        $deleteData = "DELETE FROM santri WHERE id = '$id'";
        $result = $this->conn->query($deleteData);
        if($result){
            return true;
        } else {
            return false;
        }
    }

    function __destruct(){
        $this->conn->close();
    }

}

?>