<?php

class database {

    public $mysqli;
    public $query;


    function __construct(){
        $this -> mysqli = new mysqli("localhost","root","","test2");
        mysqli_query($this -> mysqli,"SET NAMES utf8");
        date_default_timezone_set("Asia/Bangkok");
    }


    function select($table,$row = "*",$where = null){
        $sql = $where != null ? "SELECT $row FROM $table WHERE $where" : "SELECT $row FROM $table";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }


    function selectgb($table,$row = "*",$gb = null){
        $sql = $gb != null ? "SELECT $row FROM $table  $gb" : "SELECT $row FROM $table";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }

    function selectjoin($table,$row="*",$join,$where,$on,$gb){
        $sql = "SELECT $row FROM $table  $join ON $on WHERE $where GROUP BY $gb";
        $this -> query = $this -> mysqli -> query($sql);
        return;
    }

    function update($table,$par = array(),$id){
        $args = [];

        foreach($par as $key => $value){
            $args[] = "$key = '$value'";
        }

        $sql = "UPDATE $table SET ".implode(",",$args);
        $sql .= " WHERE $id";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }


    function insert ($table,$para = []){
        $key = implode(",",array_keys($para));
        $value = implode("','",$para); 


        $sql = "INSERT INTO $table ($key) VALUES ('$value')";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }

    function insertWhere($table,$para = [],$where){
        $key = implode(",",array_keys($para));
        $value = implode("','",$para);
        $sql = "INSERT INTO $table ($key) SELECT '$value' WHERE NOT EXISTS $where";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }

    function delete($table,$id){
        $sql = "DELETE FROM $table WHERE $id";

        $this -> query = $this -> mysqli -> query($sql);
        return;
    }

    function uploadFile($file){
        $ext = explode(".",$file['name']);
        $fileExt = strtolower(end($ext));
        $fileNew = rand().".".$fileExt;

        $filePath = './image/'.$fileNew;

        move_uploaded_file($file['tmp_name'],$filePath);
        return $fileNew;
    }

    function secureCheck(){
        if(!isset($_SESSION['id'])){
            $_SESSION['alert'] = "Please Login";
            header('location:./login.php');
            return;
        }else{
            return;
        }
    }

    function checkAdmin(){
        if($_SESSION['type'] != 'admin'){
            header('location:./index.php');
            return;
        }else{
            return;
        }
    }

}