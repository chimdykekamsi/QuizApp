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
    <div class=" m-3" >

    <?php 
      
        if (mysqli_num_rows(fetchWhere('quiz','id',$_GET['id'])) < 1 || !isset($_GET['type'])) {
            header('Location: quiz');
        }

        foreach(fetchWhere('quiz','id',$_GET['id']) as $key){
            extract($key);
            
       
    ?>

       
        <!-- main -->
        <main class="col-lg-9 col-12 p-3">      
        <form  method="post" action="" id="form">      
          <div class="row">
            <h5 class='col-lg-3'>Quiz Name :<?= $quizname;?></h5>
            <h5 class='col-lg-3'>Quiz Type : <?= $quiztype;?></h5>
            <h5 class='col-lg-5' id="time">Quiz Time </h5>
            
          </div>
            <div class="container">
                <?php
                    $num = 1;
                    foreach(fetchWhere('questions','quizid',$id) as $questions){
                        extract($questions);
                        
                ?>
                <div class="container bod p-3 m-3" id="question<?=$id?>">
                        <h6>Question<?=$num?></h6>
                    <h3><?=$question?></h3>
                    <div class="row col-12 p-3">
                       
                    <?php
                    foreach(fetchWhere('options','questionid',$id) as $options){
                        extract($options);
                        
                    ?>
                           <div class="cont col-5 m-3  ">
                           <input type="radio" name="<?='q'.$questions['id'] ?>" id="" value="<?=$id?>"class="qs" >
                           <label for="" class='select text-center col-12'>
                           <?=$option?></label>
                           </div>
                           
                            <?php }?>
                           
                        </div>
                </div>
                <?php $num++;}?>
            </div>
            <div class=" col-12 text-left p-3">
                <button class="btn btn-success col-4" type="submit" name="submit">Submit</button>                
            </div>
        </form>
        </main>
                    <?php }?>
    </div>
    <script src="main.ad.js"></script>
   
</body>
</html>

<?php 

if (isset($_POST['submit'])) {
    $submitted =  array();
    $i = 1;
    foreach (fetchWhere('questions','quizid',$quizid) as $questions) { 
        if (isset($_POST['q'.$questions['id']]) ) {
            $submitted[$i] =  $_POST['q'.$questions['id'] ];
        }else {
            $submitted[$i] =  0;
        }
       $i++;
    }
    submitQuiz($quizid,$submitted);
}?>

<script>
                let mins = <?= $quiztime?> - 1;
                let sec = 60;
                let checks = document.querySelectorAll('.qs');
               
                setInterval(() => {
                    document.getElementById('time').innerHTML = 'Quiz Time : ' + mins + 'mins   ' + sec + 'seconds';
                    sec--;
                    if (sec == 0) {
                        mins-=1;
                        sec = 60;                       
                    }
                    if (mins < 0) {
                            document.getElementById('time').innerHTML = 'Quiz Over'
                            checks.forEach(check => {
                                   check.setAttribute ("hidden",true);
                            });
                        }
                }, 1000);
              
</script>