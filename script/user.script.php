<?php
include_once 'db.script.php';
include_once 'notifications.script.php';
include_once 'leaderboard.script.php';
include_once 'quiz.script.php';


function filter_mail($input){
    return filter_var( $input, FILTER_SANITIZE_EMAIL );
}



function register($name,$email,$pwd){

    global $conn;
    $name = clean_input($name);
    $pwd = clean_input($pwd);
    $email = filter_mail($email);
    $userid = random_gen(10);
    $pswd = enc_decrypt($pwd);

    $sql = "INSERT INTO `user`(`userid`, `username`, `useremail`, `userpassword`) 
    VALUES ('$userid','$name','$email','$pswd')";
    $execute = $conn->query($sql);
    if ($execute) {
        $_SESSION['userid'] = $userid;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['pwd'] = $pwd;

        addLeaderboard($userid);

        message('success',"Registration Successfull '$userid' is your user id ",'');
        addNotify($userid,'Welcome to Quiza App explore topics Available to you and rise in the leaderboard to collect badges');
       
    }else{
        $mesage ="Registeration failed";
    }
    
}

function login($userid,$pwd){
    global $conn;
    $pwd = clean_input($pwd);
    $userid = clean_input($userid);

    $sql = "SELECT * FROM `user` WHERE `userid` = '$userid'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0){
        foreach ($result as $key) {   
            $pswd = enc_decrypt($key['userpassword'],'decrypt');
            if ($pswd == $pwd) {
                $_SESSION['userid'] = $userid;
                $_SESSION['name'] = $key['username'];
                $_SESSION['email'] = $key['useremail'];
                $_SESSION['pwd'] = $pwd;
        
                message('success',"Welcome " . $key['username'],'dashboard');
            }else {
                message('warning','Invalid password','');
            }
        }
    }else {
        message("warning","user not found Please confirm your password and userid","");
    }
   
  }
  function updateProfile($username,$image,$pwd){
    global $conn;
    $id = $_SESSION['userid'];
    $username = clean_input($username);
    $pwd =  clean_input($pwd);
    $pswd = enc_decrypt($pwd);

    // Get the current user information from the database
    $sql = "SELECT `userimage` FROM `user` WHERE `userid`='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $old_userimage = $row['userimage'];

    if (empty($image['name'])) {
        $sql = "UPDATE `user` SET `username`='$username',`userpassword`='$pswd' WHERE `userid` = '$id'";
        $result = $conn->query($sql);
    } else {
        $image_type = array('image/jpg', 'image/jpeg','image/png');
        $ext = explode("/",$image['type']);
        $userimage =  $id . "_" . time() . "." . $ext[1];

        if (in_array($image['type'],$image_type)) {
            $user_image_temp = $image['tmp_name'];

            // Delete the old image if it exists
            if (!empty($old_userimage)) {
                $old_image_path = "./img/$old_userimage";
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            move_uploaded_file($user_image_temp, "./img/$userimage");
            $sql = "UPDATE `user` SET `username`='$username',`userpassword`='$pswd',`userimage`='$userimage' WHERE `userid` = '$id'";
            $result = $conn->query($sql);
        } else {
            message('warning','file must be of type (jpg/jpeg/png)','');
            return NULL;
        }
    }

    if ($result) {
        message('success','Profile updated Successfully','user/profile');
        return $result;
    } else {
        return NULL;
    }
}

function adlogin($adminid,$pwd){
    global $conn;
    $pwd = clean_input($pwd);
    $adminid = clean_input($adminid);

    $sql = "SELECT * FROM `admin` WHERE `adminid` = '$adminid'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) > 0){
        foreach ($result as $key) {   
            $pswd = $key['password'];
            if ($pswd == $pwd) {
                $_SESSION['adminid'] = $adminid;
                $_SESSION['admin'] = $key['name'];
        
                message('success',"Welcome Admin",'admin/');
            }else {
                message('warning','Invalid password','');
            }
        }
    }else {
        message("warning","Admin not found Please confirm your password and userid","");
    }
   
  }
  


function logout(){
  

    $_SESSION['userid'] = NULL;
    $_SESSION['name'] = NULL;
    $_SESSION['email'] = NULL;
    $_SESSION['pwd'] = NULL;
    session_destroy();
    message('success','Logging out!!','home');
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

