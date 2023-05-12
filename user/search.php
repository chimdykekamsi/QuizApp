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
    
  

    if (isset($_GET['deleteNote'])) {
        delete($_GET['deleteNote']);
        header('Location: ../user/quiz ');
    }

    if (!isset($_POST['search'])) {
        header('Location: quiz');
    }else{
        $search = clean_input($_POST['searchtag']);
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
          
                      <div class="col-lg-12 col-2  bod container  tab ">
                        <a href="profile" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-user m-2 "></i> Profile</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-user m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab active">
                        <a href="" style="text-decoration: none;" class="active">
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
                <h3 class="col-7 mb-4">Search Result</h3>
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
                            <h3 class="col-7">Notifiations</h3>
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
                <div class="col-10 m-3  ">                    
                </div>
                <div class="row">
                    <?php 
                        $sql = "SELECT * FROM `quiz` WHERE quiztag LIKE '%$search%' OR quizauthor LIKE '%$search%' ";
                        $result = $conn->query($sql);
                        foreach($result as $key){
                        extract($key);
                      
                            
                    ?>
                    <div class="col-10 col-lg-3 bod p-3 m-4  ">
                        <h5 class="text-center">  <?=$quizname?> </h5>
                            
                        <div class="col-11 m-3 row">
                            <ul>
                                <li>
                                    <h5><?=$quiztype?> Type Questions</h5>
                                </li>
                                <li>
                                    <h5><?=$quizmarks?> marks [<?=$quiztime?>mins]</h5>
                                </li>
                                <li>
                                    <h5>Completed by 20% of users</h5>
                                </li>
                            </ul>
                            <button class="btn btn-outline-primary" ><a href="takeQuiz?id=<?=$id?>&type=<?=$quiztype?>" style="text-decoration:none;color:unset"><h6><i class="ti ti-pencil"></i>  Take Quiz </h6></a></button>
                           
                        </div>
                    </div>
                    <?php }
                        if (mysqli_num_rows($result) == 0) {
                        ?>
                        <div class="col-10 col-lg-7 bod p-3 m-4  ">
                         <h5 class="text-center"> No quiz Matched what you searched </h5>                          
                        </div>
                        <?php   }?>
                        
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

        function takequiz(id){
            alert(id)
        }
    </script>
</body>
</html>