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
$fileName = "CVSU-IMUS_EMPLOYED-ALUMNI-" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('LASTNAME','FIRSTNAME','BATCH YEAR','COURSE', 'EMPLOYMENT STATUS', 'EMPLOYMENT START', 'COMPANY NAME', 'POSITION', 'DATE HIRED', 'PLACE OF WORK', 'TYPE OF EMPLOYMENT', 'EMPLOYMENT SECTOR', 'MONTHLY INCOME'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $con->query("SELECT a.`Lastname`, a.`Firstname`, a.`Batchyear`,b.`Course`, b.`EmpStat`, b.`EmpStart`, b.`CompanyName`, b.`Position`, b.`DateHired`, b.`PlaceofWork`, b.`TypeofEmp`, b.`EmpSect`, b.`MonthlyIncome` FROM `jobinfo` b, `alumniinfo` a  where a.`Email`= b.`Email` and b.`EmpStat`='Employed' ORDER BY `Batchyear`, `Lastname` "); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['Lastname'], $row['Firstname'], $row['Batchyear'], $row['Course'], $row['EmpStat'], $row['EmpStart'], $row['CompanyName'], $row['Position'], $row['DateHired'], $row['PlaceofWork'], $row['TypeofEmp'], $row['EmpSect'],  $row['MonthlyIncome']); 
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