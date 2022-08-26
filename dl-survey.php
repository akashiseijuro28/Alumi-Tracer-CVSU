<?php 
  $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
  session_start();

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "CVSU-IMUS_Alumni-Survey-" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('LASTNAME','FIRSTNAME','MIDDLENAME','BATCHYEAR','COURSE','Q1','Q2','Q3','Comment'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $con->query("SELECT a.`Lastname`, a.`Firstname`,a.`Middlename`, a.`Batchyear`,a.`Course`, b.`Q1`, b.`Q2`, b.`Q3`, b.`Comment` FROM alumniinfo a, survey b WHERE a.`Email`= b.`Email` ORDER BY a.`Lastname`"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array( $row['Lastname'], $row['Firstname'], $row['Middlename'], $row['Batchyear'], $row['Course'], $row['Q1'], $row['Q2'], $row['Q3'], $row['Comment']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;