<?php
include_once 'db.script.php';

function addLeaderboard($id,$points= 0){
    global $conn;
    $sql = "INSERT INTO `leaderboard`(`userid`,`points`) 
    VALUES ('$id','$points')";
    $execute = $conn->query($sql); 
    
}