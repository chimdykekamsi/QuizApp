<?php
    $db_name = "quizapp";
    $user = "root";
    $pwd = "";
    $host = "localhost";

    $conn = new mysqli($host, $user, $pwd, $db_name);

    
function message($type,$mesage,$link){
    echo "<div class='alert alert-$type col-lg-5  col-12 bod  mt-5 row animate-right' style=\"z-index: 5;position:fixed;top:20;right:10\">
                <h5 class='col-9'>$mesage</h5>
                <button class='col-3 btn btn-primary' onclick='alerter(\"$link\")' > OK </button>
        </div>";
}


function enc_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCCrferefesc2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf54645dsfdfsfc5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function random_gen($length){
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $randomString = "user";
    for ($i = 0; $i < $length; $i++) {
    $randomString .= $chars[rand(0, strlen($chars) - 1)];

}
return $randomString;

}
    function fetchItems($table,$orderBy,$limit = NULL){
        global $conn;
        if ($limit !== NULL) {
            $sql = "SELECT * FROM `$table` ORDER BY `$table`.`$orderBy` DESC LIMIT $limit";
        }else{
            $sql = "SELECT * FROM `$table` ORDER BY `$table`.`$orderBy` DESC";
        }
        return $conn->query($sql);
    }

    function fetchWhere($table,$key,$value,$limit=NULL){
        global $conn;
        
       if ($limit !== NULL) {
        $sql = "SELECT * FROM `$table` WHERE $key = '$value' LIMIT $limit";
       }else {
        $sql = "SELECT * FROM `$table` WHERE $key = '$value' ";
       }
        return $conn->query($sql);
    }

    function clean_input($input){    
        return filter_var( $input, FILTER_SANITIZE_STRING);
    }
    ?>

<script>
    function alerter(name){
        let linked = name;
        document.querySelector('.alert').style.display="none";
        if (linked == 'dashboard') {
            window.location.href = 'http://localhost/QuizApp/user';
        }else if(linked == 'home'){
            window.location.href = 'http://localhost/QuizApp/';
        }else if (linked == ' '){
            window.location.href = '';
        }else{
            window.location.href = `http://localhost/QuizApp/${linked}`;
        }
        
    }
    </script>