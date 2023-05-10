<?php

    session_start();
    ob_start();
    include_once "../script/user.script.php";
    if (!isset($_SESSION['admin'])) {
       header('Location: ./login');
    }
    
    if (isset($_POST['logout'])){
        logout();
    }

    if (isset($_GET['deleteNote'])) {
        if ($_GET['deleteNote'] == 'all') {
            $sql = "DELETE FROM `notifications` WHERE user = 'admin' ";
            $result = $conn->query($sql);
        }else{
            delete($_GET['deleteNote']);
        }       
        header('Location: ../admin/ ');
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
                             $table = fetchWhere('admin','adminid',$_SESSION['admin']);
                             foreach($table as $key){
                                extract($key);
                        ?>
                        <img src="./img/icons8-circled-user-male-skin-type-1-and-2.gif" alt="not found" class="img-fluid " width="100">
                        
                    </div>
                    <h5 class="col-10"><?= $name ?? 'Not found' ?></h5 class="col-10">                    
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
                        <a href="quiz" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-write m-2 "></i> Quiz</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-write m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab active">
                        <a href="leaderboard" style="text-decoration: none;" class="active">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-cup m-2 "></i>  Leaderboard</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-cup m-2 "></i> </h5>
                        </a>
                      </div>
          
                      <div class="col-lg-12 col-2  bod container  tab ">
                        <a href="history" style="text-decoration: none;" class="">
                          <h5 class="d-md-block d-none m-3"><i class="ti ti-time m-2 "></i>  History</h5>
                          <h5 class="d-block d-md-none text-center mt-3"><i class="ti ti-time m-2 "></i> </h5>
                        </a>
                      </div>
                </div>           
           </div>

        </div>

        <!-- main -->
        <main class="col-lg-9 col-12 p-3">
            <nav class="row p-2 border-bottom mt-2">
                <h3 class="col-7 mb-4">Leaderboard</h3>
                <div class="col-5 row">                       
                   <?php if(mysqli_num_rows(fetchWhere('notifications','user','admin')) > 0){?>                   
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
                                $table = fetchWhere('notifications','user','admin');
                                if (mysqli_num_rows($table) > 0) {
                                   foreach ($table as $key) {
                                    extract($key);
                                    echo "<h6   class='col-7'><li style='list-style:none;' class='text-secondary'>$message</li></h6>
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
              
                <div class=" p-3 bod">
                 <table class="table table-striped " style="max-height:90vh;overflow-y:scroll;">
                        <thead>
                            <tr>
                                <th>Pos</th>
                                <th>Name</th>
                                <th>Points</th>
                                <th>Quiz Taken</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $pos = 1;
                                foreach(fetchItems('leaderboard','points') as $key){
                                    extract($key);
                                  
                            ?>
                            <tr>
                                <td><?=$pos?></td>
                                <?php foreach(fetchWhere('user','userid',$userid) as $key2){extract($key2);}?>
                                <td><?=$username?></td>
                                <td><?=$points?></td>
                                <td><?= mysqli_num_rows(fetchWhere('history','userid',$userid))?></td>
                            </tr>

                            <?php   $pos++;  }?>
                        </tbody>
                 </table>
                        
                </div>          
            </div>
        </main>

    </div>
    <script src="main.ad.js"></script>
   
</body>
</html>