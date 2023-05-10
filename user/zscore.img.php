<?php
session_start();
ob_start();
$db_name = "quizapp";
$user = "root";
$pwd = "";
$host = "localhost";

$conn = new mysqli($host, $user, $pwd, $db_name);
function fetchWhere($table,$key,$value,$limit=NULL){
    global $conn;
    
   if ($limit !== NULL) {
    $sql = "SELECT * FROM `$table` WHERE $key = '$value' LIMIT $limit";
   }else {
    $sql = "SELECT * FROM `$table` WHERE $key = '$value' ";
   }
    return $conn->query($sql);
}


if (!isset($_GET['name']) || !isset($_GET['quiz'])) {
    header('Location: history');
 }
 
 $name = $_GET['name'];
$quiz = $_GET['quiz'];


$sql = "SELECT * FROM `history` WHERE `userid` = '$name' AND `quizid` = $quiz";
$query = $conn->query($sql);


if (mysqli_num_rows($query) < 1) {
    header("Location: history");
}

$row = mysqli_fetch_assoc($query);
extract($row);                   

$quiz =  mysqli_fetch_assoc(fetchWhere('quiz','id',$quizid)); 
extract($quiz);

// Create image
$width = 400;
$height = 500;
$image = imagecreatetruecolor($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);
$black = imagecolorallocate($image, 0, 20,30);

// Fill background with white
imagefill($image, 0, 0, $white);

// Add text
$text = ' T4 Quiz App';
$font = 'fonts/arial.ttf'; // Change this to your desired font file path
$font_size = 25;
$text_color = $black;
$text_box = imagettfbbox($font_size, 0, $font, $text);
$text_width = $text_box[2] - $text_box[0];
$text_height = $text_box[1] - $text_box[7];
$text_x = ($width - $text_width) / 2;
$text_y = ($height - $text_height) / 5.5 - $font_size;
imagettftext($image, $font_size, 0, $text_x+2, $text_y, $blue, $font, $text);
imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font, $text);

// Add catch phrase
$catch_phrase = $quizname;
$catch_font_size = 24;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = ($width - $catch_text_width) / 2;
$catch_text_y = $text_y + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'Number of questions asked: ' . $quizcount;
$catch_font_size = 20;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = ($width - $catch_text_width) / 2;
$catch_text_y = $text_y*2 + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'Right: ' . $correct;
$catch_font_size = 20;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = 20;
$catch_text_y = $text_y*2.8 + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'Wrong: ' . $wrong;
$catch_font_size = 20;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = 20;
$catch_text_y = $text_y*3.6 + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'Score: ' . $score . '/' . $quizmarks;
$catch_font_size = 20;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = 20;
$catch_text_y = $text_y*4.4 + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'Points Gained: ' . $point . '/' . 50;
$catch_font_size = 20;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = 20;
$catch_text_y = $text_y*5.2 + $text_height + $font_size;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);


// Add catch phrase
$catch_phrase = 'I took a quiz from T4 QuizApp ';
$catch_font_size = 12;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = ($width - $catch_text_width) / 2;
$catch_text_y = $height - 80;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'visit  http://localhost/QuizApp/user/index ';
$catch_font_size = 12;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = ($width - $catch_text_width) / 2;
$catch_text_y = $height - 50;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);

// Add catch phrase
$catch_phrase = 'to get started ';
$catch_font_size = 12;
$catch_text_color = $black;
$catch_text_box = imagettfbbox($catch_font_size, 0, $font, $catch_phrase);
$catch_text_width = $catch_text_box[2] - $catch_text_box[0];
$catch_text_height = $catch_text_box[1] - $catch_text_box[7];
$catch_text_x = ($width - $catch_text_width) / 2;
$catch_text_y = $height - 20;
imagettftext($image, $catch_font_size, 0, $catch_text_x, $catch_text_y, $catch_text_color, $font, $catch_phrase);


// Output image
imagepng($image,    $quizname . 'score.png');
// Download the file
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=$quizname score.png");
header('Content-Length: ' . filesize($quizname . 'score.png'));
readfile($quizname . 'score.png');
// Clean up memory
imagedestroy($image);

?>
