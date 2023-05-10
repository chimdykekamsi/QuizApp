<?php
include_once 'db.script.php';

 
function submitQuiz($quizid,$submitted){
    global $conn;
    $marks = 0;
    $correct = 0;
    $failed = 0;
    $i =1;
    $userid = $_SESSION['userid'];
    foreach(fetchWhere('quiz','id',$quizid) as $quiz){
        extract($quiz);
        $marker = round($quizmarks/$quizcount);
        foreach(fetchWhere('answers','quizid',$quizid) as $answers){
          extract($answers);
                if ($submitted[$i] == $optionid) {
                    $correct += 1;
                    $marks += $marker;
                }else{
                    $failed += 1;
                }
            $i ++;
        }
    }
    $points = round(($marks/$quizmarks) * 50);
    $sql = "SELECT * FROM `history` WHERE `userid` = '$userid'  AND `quizid` = '$quizid'";
    $query = $conn->query($sql);

    if(mysqli_num_rows($query) < 1 && $quizauthor !== $userid){
        $sql = "INSERT INTO `history`(`userid`, `quizid`, `score`, `correct`, `wrong`,`quizmarks`,`point`) VALUES ('$userid','$quizid','$marks','$correct','$failed','$quizmarks','$points')";
        $result = $conn->query($sql);
    
        $sql = "UPDATE `leaderboard` SET`points` = `points` + $points WHERE `userid` = '$userid' ";
        $result = $conn->query($sql);
       
        $sql = "UPDATE `quiz` SET`quizuser` = `quizuser` + 1 WHERE `id` = '$quizid' ";
        $result = $conn->query($sql);

        if($quizauthor !== "admin"){

            $sql = "UPDATE `leaderboard` SET `points`= `points` + 10 WHERE `userid` = '$quizauthor'";
            $result = $conn->query($sql);

            $sql = "INSERT INTO `customers`(`userid`, `quizauthor`, `mark`) VALUES ('$userid','$quizauthor',$marks)";
            $result = $conn->query($sql);
        }

        $message = "Congrats You have successfully completed this quiz";
    
        message('success',$message,'user/history');
    }else {
        $message = "Points gained from this quiz will not be added to your database";
        message('warning',$message,'user/quiz');
    }
}

function addQuiz($title,$type,$mark,$time,$count,$quizauthor = null)
{
    global $conn;
    $id = $_SESSION['userid'];

    if ($quizauthor !== null && $quizauthor == 'admin') {

        $title = filter_mail($title);
        $type = clean_input($type);
        $mark = clean_input($mark);
        $time = clean_input($time);
        $count = clean_input($count);
        $tag = $title . "," . $type;

        $sql = "INSERT INTO `quiz`(`quizname`, `quiztype`, `quizmarks`, `quiztime`, `quiztag`, `quizauthor`, `quizcount`) VALUES ('$title','$type',$mark,$time,'$tag','$quizauthor',$count)";
        $result = $conn->query($sql);

        $userid = 'all';
        $message = "A new Quiz has been added, Have fun 😉😂😂";
        if ($userid == 'all') {
            foreach(fetchItems('user','id') as $user)
            extract($user);
            addNotify($userid,$message);
        }else{
            addNotify($userid,$message);
        }

        $sql = "SELECT * FROM `quiz` WHERE `quizname` = '$title' AND `quizauthor` = 'admin'";
        $result = $conn->query($sql);
        foreach($result as $row){
            extract($row);
        }
         $where = $_SESSION['where'] = "questions";
    

        header("Location: add?$where=$id");
    }else{
        $row = mysqli_fetch_assoc(fetchWhere('leaderboard','userid',$id));
        if ($row['points'] >= 200) {   
        
        $sql = "UPDATE `leaderboard` SET `points`= `points` - 200,`spent`=`spent` + 200 WHERE `userid` = '$id'";
        $result = $conn->query($sql);

        $title = filter_mail($title);
        $type = clean_input($type);
        $mark = clean_input($mark);
        $time = clean_input($time);
        $count = clean_input($count);
        $tag = $title . "," . $type;

        $sql = "INSERT INTO `quiz`(`quizname`, `quiztype`, `quizmarks`, `quiztime`, `quiztag`, `quizauthor`, `quizcount`) VALUES ('$title','$type',$mark,$time,'$tag','$id',$count)";
        $result = $conn->query($sql);

        $sql = "SELECT * FROM `quiz` WHERE `quizname` = '$title' AND `quizauthor` = '$id'";
        $result = $conn->query($sql);
        foreach($result as $row){
            extract($row);
        }
        $where = $_SESSION['where'] = "questions";
        

        header("Location: custom?$where=$id");
        }else {
            message('warning','you must have atleast 200 points to ccustomize your quiz','user/quiz');
        }
    }
}

function addQuestion($question,$optioncount,$quizid){
    global $conn;
    $question = clean_input($question);
    $sql = "INSERT INTO `questions`(`question`, `optioncount`, `quizid`) VALUES ('$question',$optioncount,$quizid)";
    $result = $conn->query($sql);
  
}

function addOptions($option,$questionid,$quizid){
    global $conn;
    $option = filter_mail($option);
  $sql = "INSERT INTO `options` (`option`, `questionid`, `quizid`) VALUES('$option',$questionid,$quizid)";
  $result = $conn->query($sql);
}

function addAnswers($quid,$oid,$qid){
    global $conn;
    $sql = "INSERT INTO `answers`(`questionid`, `optionid`, `quizid`) VALUES ($quid,$oid,$qid)";
    $result = $conn->query($sql);
    
}

function deleteQuiz($id){
    global $conn;
    foreach (fetchWhere('quiz','id',$id) as $key )
    extract($key);
    if ($quizuser < 1 ) {
        $sql = "DELETE FROM answers WHERE quizid=$id";
        $result = $conn->query($sql);
    
        $sql = "DELETE FROM options WHERE quizid=$id";
        $result= $conn->query($sql);
    
        $sql = "DELETE FROM questions WHERE quizid=$id";
        $result = $conn->query($sql);
      
        $sql = "DELETE FROM quiz where id=$id";
        $result = $conn->query($sql);
    
        
        addNotify($quizauthor,"Your Quiz has been deleted");
        message('success','Succesful','admin/quiz');
        return;
    }else {
    message('warning','You cannot delete this Quiz, It has been taken by a user','admin/quiz');
    return;
    }
}