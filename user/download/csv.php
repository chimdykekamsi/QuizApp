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

if (!isset($_SESSION['name'])) {
   header('Location: ../');
}

function message($type,$mesage,$link){
    echo "<div class='alert alert-$type col-lg-5  col-12 bod  mt-5 row animate-right' style=\"z-index: 5;position:fixed;top:20;right:10\">
                <h5 class='col-9'>$mesage</h5>
                <button class='col-3 btn btn-primary' onclick='alerter(\"$link\")' > OK </button>
        </div>";
}



$id = $_SESSION['userid'];
// Create a file handle to write to the CSV file
$filename = $id.'scoresheet.csv';
$handle = fopen($filename, 'w');

$sql = "SELECT `quizid`, `score`, `correct`, `wrong`, `quizmarks`,`point` FROM `history` WHERE `userid` = '$id'";
$table = $conn->query($sql);
foreach ($table as $row) {
    $data[] = $row;
}
// Write the headers to the CSV file
$headers = array_keys($data[0]);
fputcsv($handle, $headers);

// Loop through the data and write each row to the CSV file
foreach ($table as $row) {
    fputcsv($handle, $row);
}

// Close the file handle
fclose($handle);

// Check if the file exists and is readable
if (is_readable($filename)) {
    // Set the headers to force a file download
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=$id.csv");
    // Output the contents of the file
    readfile($filename);
    
    // Clean up
    unlink($filename);
} else {
    echo "Error: Failed to download file!";
}

exit();
// Clean up
unset($data);
$conn->close();

// Redirect to the index page using JavaScript and show a success message
echo "<script>console.log('Redirecting...');window.location.href = 'index.php';</script>";

