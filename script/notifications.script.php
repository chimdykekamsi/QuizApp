<?php
include_once 'db.script.php';

    function addNotify($user,$message){

        global $conn;

        $sql  = "INSERT INTO `notifications`( `user`, `message`)
         VALUES ('$user','$message')";

         return $conn->query($sql);
    }
    
    function delete($id){
        global $conn;
        $user = $_SESSION['userid'];
      
        if ($id == 'all') {
            $sql = "DELETE FROM `notifications` WHERE user = '$user' ";
        }else{
         $sql = "DELETE FROM `notifications` WHERE id = '$id'";
        }
        return $conn->query($sql);
    }