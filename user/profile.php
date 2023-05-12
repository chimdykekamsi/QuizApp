<?php

    session_start();
    ob_start();
    include_once "../script/user.script.php";
    if (!isset($_SESSION['name'])) {
       header('Location: ../');
    }
    
    if (isset($_POST['logout'])){
        logout();
    }
    
    if (isset($_POST['update_profile'])){
        $username = $_POST['username'];
        $image = $_FILES['image'];
        $pwd = $_POST['pwd'];
        updateProfile($username,$image,$pwd);
    }

    if (isset($_GET['deleteNote'])) {
        delete($_GET['deleteNote']);
        header('Location: ../user/profile ');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="style.ad.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/ti-icons/css/themify-icons.css">
</head>
<body>
    <div class="row " >


        <!-- leftbar -->
        <div class="col-lg-3 col-12  p-2  " >

            <div class="col-lg-12 col-4 mb-3 border-bottom">
                <a href="../user/" class="btn img-fluid">
                   <h5 class="d-md-block d-none"><img src="../assets/images/icon.png" alt="" class="img-fluid " width="75">QuizApp</h5>
                    <img src="../assets/images/icon-mobile.png" alt="" class="img-fluid d-block d-md-none" >    
                </a>
            </div>
          
            

           <div class="bod p-4">

                <div class="col-12 text-center">
                    <div class="bg-light rounded-circle" style="overflow: hidden;width: 100px;">
                        <?php
                             $table = fetchWhere('user','userid',$_SESSION['userid']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                        <img src="./img/<?=$userimage?>" alt="not found" class="img-fluid " width="100">
                        
                    </div>
                    <h5 class="col-10"><?= $username ?? 'Not found' ?></h5 class="col-10">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control col-10" disabled value="<?=$userid?>" id="userid">
                        <button class="btn btn-secondary col-2" id="copy" onclick="copier('userid')"><i class="ti ti-clipboard"></i></button>
                    </div>
                    <?php } ?>
                </div>
                <div class="row g-3">
                    <div class="col-lg-12 col-2  bod  container  tab ">
                        <a href="index" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-dashboard m-2 "></i> Dashboard</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-dashboard m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab active">
                        <a href="profile" style="text-decoration: none;" class="active">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-user m-2 "></i> Profile</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-user m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab ">
                        <a href="quiz" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-write m-2 "></i> Quiz</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-write m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab ">
                        <a href="leaderboard" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-cup m-2 "></i>  Leaderboard</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-cup m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab ">
                        <a href="history" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-time m-2 "></i> History</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-time m-2 "></i> </h5>
                        </a>
                      </div>
                </div>           
           </div>

        </div>

        <!-- main -->
        <main class="col-lg-9 col-12 p-3">
            <nav class="row p-2 border-bottom mt-2">
                <h3 class="col-7 mb-4">Profile</h3>
                <div class="col-5 row"> 
                    <?php if(mysqli_num_rows(fetchWhere('notifications','user',$_SESSION['userid'])) > 0){?>                   
                    <button class="col-3 btn" style="position:relative" onclick="createT('notify')"><h3 class="ti ti-bell  text-primary"  title="Notifications" ><sup ><span class="bg-primary rounded-circle" style="font-size:10px">0</span></sup></h3> </button>
                    <?php } else {                        
                    ?>    
                    <button class="col-3 btn" style="position:relative" onclick="createT('notify')"><h3 class="ti ti-bell  text-primary"  title="Notifications" > </button>
                    <?php }?>
                        <form action="" method="post" class="col-3 row">
                            <button class=" col-10 btn" type="submit" name="logout" onclick="javascript: return confirm('Confirm Logout?')"><h3 class="ti ti-power-off text-secondary "  title="Log out"></h3> </button>
                        </form>
                </div>

                <div id="notify" class="bg-light col-lg-5 col-10 bod p-3 m-3" style="z-index: 5;position:fixed;top:17%;right:10" hidden>
                        <div class="row">
                            <h3 class="col-7">Notifications</h3>
                            <a href="?deleteNote=all" class="col-4">clear all</a>
                        </div>
                        <div class="col-12 row">                            
                            <?php 
                                $table = fetchWhere('notifications','user',$_SESSION['userid']);
                                if (mysqli_num_rows($table) > 0) {
                                   foreach ($table as $key) {
                                    extract($key);
                                    echo "<h6   class='col-7'><li style='list-style:none' class='text-secondary'>$message</li></h6>
                                        <a href='?deleteNote=$id' class='col-4 text-center text-danger' style='text-decoration:none' ><i class='ti ti-trash'></i></a>
                                    ";
                                   }
                                }else{
                                    echo "<h3 class='text-secondary'>Nothing to see here</h3>";
                                }
                            ?>
                            
                        </div>
                </div>
                
            </nav>
          
            <div class="col-12 mt-3">
                <div class="row mt-3">
                    <div class="col-lg-7 col-10 card p-3 bg-light">
                        <h5>Edit Profile</h5>
                        <form method="post" action="" enctype="multipart/form-data" class="was-validated">
                        <?php
                             $table = fetchWhere('user','userid',$_SESSION['userid']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                       
                            <div class="form-group col-12 card p-2">
                              <label for="">Profile image </label>
                              <input type="file" class="form-control-file" name="image" id="" placeholder="Change profile image" value="<?=$userimage?>">
                            </div>                            
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username"  name="username" required value="<?=$username?>">
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd"  name="pwd" required value="<?=enc_decrypt($userpassword,'decrypt')?>">
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <?php }?>
                            <button class="btn btn-primary col-12 mt-2" name="update_profile" onclick="javascript: return confirm('Confirm Update?')">Update</button>
                        </form>
                    </div>
                    <div class="col-lg-4 col-10 p-3 ">
                       <h3 class="text-center">Customise Quiz</h3>
                        <ul>
                            <li>
                                <h5>Create a custom Quiz</h5>
                            </li>
                            <li>
                                <h5>Share your Quiz Id to other users</h5>
                            </li>
                            <li>
                                <h5>View scores of your students</h5>
                            </li>
                            <li>
                                <h5>Earn points per user</h5>
                            </li>
                        </ul>
                        <button class="btn btn-secondary col-12 "><a class="text-light" href="custom?user=<?=$_SESSION['userid']?>" style="text-decoration:none">Customise Quiz</a></button>
                    </div>
                </div>   
                <div class="row m-3 col-12">
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i> Total Points</h5>
                        <?php
                             $table = fetchWhere('leaderboard','userid',$_SESSION['userid']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                            <h3><?= $points + $spent?></h3>
                            <?php } ?>
                    </div>
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i> Avail Points</h5>
                        <?php
                             $table = fetchWhere('leaderboard','userid',$_SESSION['userid']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                            <h3><?= $points ?></h3>
                            <?php } ?>
                    </div>
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i> Spent Points</h5>
                        <?php
                             $table = fetchWhere('leaderboard','userid',$_SESSION['userid']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                            <h3><?=  $spent?></h3>
                            <?php } ?>
                    </div>
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i> Quiz Taken</h5>
                        <h3><?= mysqli_num_rows(fetchWhere('history','userid',$userid))?></h3>
                    </div>
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i> Quiz Available</h5>
                        <h3><?=mysqli_num_rows(fetchItems('quiz','quizauthor'))?></h3>
                    </div>
                    <div class="bod col-12 col-lg-3 text-center p-3 m-3">
                        <h5><i class="ti ti-game"></i>Quiz Maxed</h5>
                        <h3><?php
                        $id = $_SESSION['userid'];
                                $sql = "SELECT * FROM `history` WHERE `score` >= `quizmarks` AND `userid` = '$id'";
                                $result = $conn->query($sql);
                                echo mysqli_num_rows($result);
                        ?></h3>
                    </div>
                </div>
                
            </div>
        </main>

    </div>
    <script src="main.ad.js"></script>
   
    <script>
        function copier(item) {
            const items = document.getElementById(item);
            const range = document.createRange();
            range.selectNode(items);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand('copy');
            alert('copied to clipboard!');
            selection.removeAllRanges();
        }
    </script>
</body>
</html>