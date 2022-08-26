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
$fileName = "CVSU-IMUS_Alumni-Graduates_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('BATCHYEAR','COURSE','LASTNAME','FIRSTNAME','MIDDLENAME','SEX','EMAIL','PHONENUM'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $con->query("SELECT `Batchyear`,`Course`,`Lastname`,`Firstname`,`Middlename`,`Sex`,`Email`,`Phonenum` FROM alumniinfo  ORDER BY Batchyear, Course"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['Batchyear'], $row['Course'], $row['Lastname'], $row['Firstname'] ,$row['Middlename'] ,$row['Sex'] ,$row['Email'] ,$row['Phonenum']  ); 
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