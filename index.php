<?php 
session_start();
ob_start();
   include_once 'script/user.script.php';

   if (isset($_POST['register'])) {
      $name = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['pwd'];
      register($name,$email,$pwd);
  }

   if (isset($_POST['login'])) {
      $userid = $_POST['userid'];
      $pwd = $_POST['pswd'];
      login($userid,$pwd);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/syle.land.css">
    <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/mdi/css/materialdesignicons.min.css.map">
</head> 
<body style="background-color: gray;">
  
    <div class="container  p-5">
        <div class="row p-5 text-center">
            <div class="col-lg-6 text-left">
                <img src="assets/images/icon.png" alt="" class="img-fluid d-md-block d-none">
                <img src="assets/images/icon-mobile.png" alt="" class="img-fluid d-block d-md-none" width="50">
            </div>
            <div class="col-lg-6">
                <div class="image">
                    <img src="assets/images/experimental-girl-sitting-in-class-and-looking-up-at-big-question-mark.png" alt="" class="img-fluid">
                </div>
                <h2><q>Ready for an adventure? We make it happen</q></h2>
                    <button class="button btn-primary" onclick="modal()"><h3>Play Now</h3></button>
            </div>
        </div>
    </div>

    <!-- modal -->
    
    <div class="modal"  id="logReg"  style="background-color: rgba(93, 92, 92, 0.69);">
        <div class="container mt-1 p-2 mb-2 ">
           <p class="text-danger modal-close" style="font-weight: bolder;" onclick="closeModal()"> &times;</p>
           <button class="tablink" onclick="openCity('London', this)" id="defaultOpen">Register</button>
           <button class="tablink" onclick="openCity('Paris', this)">Login</button>      
           <!-- Register -->
           <div id="London" class="tabcontent">
              <div class="row mt-3 p-5">
                 <div class="col-lg-5  ">
                     <img src="assets/images/r.jpg" alt="" class="img-fluid d-md-block d-none" width="100%">
                    <div class="col-lg-6 text-left">
                        <img src="assets/images/icon-mobile.png" alt="" class="img-fluid d-block d-md-none" width="50">
                    </div>
                 </div>
                 <div class="col-lg-7 ">
                    <h2>Create Account</h2>
                    <form action="" class="was-validated" method="post">
                       <div class="form-group">
                          <label for="username">Username:</label>
                          <input type="text" class="form-control" id="username"  name="username" required>
                          <div class="invalid-feedback">Please fill out this field.</div>
                       </div>
                       <div class="form-group">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control" id="email"  name="email" required>
                          <div class="invalid-feedback">Please fill out this field.</div>
                       </div>
                       <div class="form-group">
                          <label for="pwd">Password:</label>
                          <input type="password" class="form-control" id="pwd"  name="pwd" required>
                          <div class="invalid-feedback">Please fill out this field.</div>
                       </div>
                       <button type="submit" class="btn btn-primary col-lg-5 mt-2" name="register">Signup</button>
                    </form>
                 </div>                        
              </div>              
             
           </div>
           <!-- Login -->
           <div id="Paris" class="tabcontent">
            <div class="row mt-3 p-5">
                <div class="col-lg-5  ">
                    <img src="assets/images/log.jpg" alt="" class="img-fluid d-md-block d-none" width="100%">
                   <div class="col-lg-6 text-left">
                       <img src="assets/images/icon-mobile.png" alt="" class="img-fluid d-block d-md-none" width="50">
                   </div>
                </div>
                <div class="col-lg-7 ">
                   <h2>Welcome Back</h2>
                   <form action="" class="was-validated" method="post">
                      <div class="form-group">
                         <label for="fullname">Userid:</label>
                         <input type="text" class="form-control" id="userid"  name="userid" required>
                         <div class="invalid-feedback">Please fill out this field.</div>
                      </div>
                      <div class="form-group">
                         <label for="pwd">Password:</label>
                         <input type="password" class="form-control" id="pwd2"  name="pswd" required>
                         <div class="invalid-feedback">Please fill out this field.</div>
                      </div>
                      <button type="submit" class="btn btn-primary col-lg-5 mt-2" name="login">Login</button>
                   </form>
                </div>                        
             </div>             
           </div>
        </div>
     </div>
     
     <!-- features tab -->
     <div class="main continer  p-5 m-3 ">
         <h2 class="mb-3">Features</h2>
           <div class="row p-5" data-aos="zoom-in" data-aos-delay="1000" >
               <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon">&#128218;</h1>
                 <h5 class="feature-title">Thousands of Questions</h5>
                 <p class="feature-description">Our quiz webapp has thousands of questions covering a wide range of topics, so you can test your knowledge on everything from history to pop culture.</p>
               </div>
               <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon">&#128269;</h1>
                 <h5 class="feature-title">Multiple Choice Answers</h5>
                 <div class="feature-description">Our quiz webapp features multiple choice answers, making it easy for you to select the right answer and test your knowledge.</div>
               </div>
                <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon">&#128161;</h1>
                 <h5 class="feature-title">Helpful Hints</h5>
                 <div class="feature-description">Need a little help? Our quiz webapp offers helpful hints to guide you in the right direction and help you answer those tough questions.</div>
               </div>
           
            
                <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon lg">&#127919;</h1>
                 <h5 class="feature-title">Leaderboard</h5>
                 <div class="feature-description">Compete against other players and see how you stack up with our leaderboard feature, available on our quiz webapp.</div>
               </div>
                <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon">&#128203;</h1>
                 <h5 class="feature-title">User Accounts</h5>
                 <div class="feature-description">Create your own user account on our quiz webapp and keep track of your progress, earn badges, and unlock new features as you play.</div>
               </div>
                <div class="feature col-lg-4 card  text-center p-2 mb-2">
                 <h1 class="feature-icon">&#128170;</h1>
                 <h5 class="feature-title">Custom Quizzes</h5>
                 <div class="feature-description">Create your own custom quizzes on our quiz webapp and test your knowledge on the topics that interest you most.</div>
               </div>
            </div>
          
         </div>
     </div>
       
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <script src="assets/main.land.js"></script>
    
</body>
</html>