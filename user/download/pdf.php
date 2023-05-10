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
$uid = $_SESSION['userid'];
require_once("fpdf/fpdf.php");
// Create a new PDF document
$pdf = new \FPDF();
$x = 10;
$y = 10;
// Add a new page
$pdf->AddPage();
$pdf->SetTitle('Score sheet');
// Set font and font size
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetMargins(10,10,10,10);
// Add some text
$pdf-> SetXY($x, $y);

$x+=6;
$pdf-> SetXY($x, $y);
$pdf->Cell(10,9,' T4 Quiz App'); 
$x+=130;
$y+=1;
$pdf->SetFont('Arial', '', 14);
$pdf-> SetXY($x, $y);
$pdf->MultiCell(0,5,$uid,'align=L'); 
$pdf->ln();
$pdf->ln();


$pdf->ln(10);
// Create a table header
$pdf->Cell(15, 10, 'S/N', 1);
$pdf->Cell(50, 10, 'Quiz Name', 1);
$pdf->Cell(30, 10, 'Score', 1);
$pdf->Cell(30, 10, 'Correct', 1);
$pdf->Cell(30, 10, 'Wrong', 1);
$pdf->Cell(30, 10, 'Points Taken', 1);
$pdf->Ln();

$sn = 0;
foreach(fetchWhere('history','userid',$uid) as $row){
    extract($row);
    $sn++;
    $pdf->Cell(15, 10, $sn, 1);
    foreach(fetchWhere('quiz','id',$quizid) as $quiz);
    $pdf->Cell(50, 10, $quiz['quizname'], 1);
    $pdf->Cell(30,10,$score , 1);
    $pdf->Cell(30, 10, $correct, 1);
    $pdf->Cell(30, 10, $wrong, 1);
    $pdf->Cell(30, 10, $point, 1);
    $pdf->Ln();
}
// Output the PDF document
$pdf->Output("$uid.pdf",'D');
echo '<script>window.location.href = "index.php";</script>'

?>

</script>
