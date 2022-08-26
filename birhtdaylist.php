<?php
ob_start();

   $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
    require($serverdpphp);
    session_start(); 


    $sqlcomand = "SELECT * FROM birthday_counter WHERE Datetoday = CURRENT_DATE()";
    $result = mysqli_query($con,$sqlcomand);
    $numrow = mysqli_num_rows($result);
    if ($numrow == 0) {
        $sqlcode = "UPDATE birthday_counter SET Datetoday = CURRENT_DATE(), counter = 0;";
        $result = mysqli_query($con,$sqlcode);
    }
    
    $sqlcomand = "SELECT * FROM birthday_counter WHERE counter = 0;";
    $result = mysqli_query($con,$sqlcomand);
    $numrow = mysqli_num_rows($result);
    if($numrow > 0){
        $greet = true;
    }else{
        $greet = false;
    }



    







    //page setup
    if (isset($_GET['PageNo']) && $_GET['PageNo']!="") {
        $PageNo = $_GET['PageNo'];
    } else {
        $PageNo = 1;
    }

    $recordsPerPage = 30;

    $Offset = ($PageNo-1) * $recordsPerPage;
    $PrevPage = $PageNo - 1;
    $NextPage = $PageNo + 1;
    $Adjacents = "2";

    //Search Alumni
    if(isset($_POST['searchAlumni'])){
        $SearchInAlumni = $_POST['SearchInAlumni'];
        $searchInSorted = $_GET['sort'];
        if($searchInSorted != NULL){
            header("Location: ../ADMIN_2.0/alumni_list.php?PageNo=1&searchInSort={$SearchInAlumni}&sorted={$searchInSorted}");
        }
        else{
            header("Location: ../ADMIN_2.0/alumni_list.php?PageNo=1&search={$SearchInAlumni}");
        }
    }


        $_SESSION['indicator'] = false;

        $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo  WHERE MONTH(Birthdate) = MONTH(CURRENT_DATE()) and DAY(Birthdate) = DAY(CURRENT_DATE());";
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

        $sql_alumniList = "SELECT *,FLOOR(DATEDIFF(CURRENT_DATE(),Birthdate)/ 365) as Age FROM alumniinfo WHERE MONTH(Birthdate) = MONTH(CURRENT_DATE()) and DAY(Birthdate) = DAY(CURRENT_DATE())
        ORDER BY Lastname ASC LIMIT $Offset, $recordsPerPage;";

        //Alumni List
        //$sql_alumniList = "SELECT * FROM alumniinfo";
        $showAlumniList_query = mysqli_query($con, $sql_alumniList);
    
    
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday List</title>
    <link rel="stylesheet" href="css/announcement.css">
    <link rel="stylesheet" href="css/alumni.css">
    <link rel="icon" href="img/logo.png">
     <!-- Boostrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
     <!--font awesome-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container-2">
        <div class="header">
            <div class="toggle"><i class="fa fa-bars" id="btn"></i></div>
            <div class="logo">
                <img src="img/logo.png">
            </div>
            <div class="name">
                CvSU
            </div>
        </div>
         <div class="side-bar">
            <div class="side-bar-list">
                <div class="list">
                    <a href="dashboard.php"><i class="fa fa-home" id="icon"></i>Dashboard</a>
                    <a href="profile.php"><i class="fa fa-user" id="icon"></i>Profile</a>
                    <a onclick="myFunction()"><i class="fa fa-bullhorn" id="icon"></i>Annoucement <i class="fa fa-caret-right" aria-hidden="true" id="arrow"></i></a>
                    <div class="list-drpdown">
                       <a href="announcementList_all.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Annoucement List</div></a>
                       <a href="announcement_create.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #FC3134;"></i> Create Annoucement</div></a>
                       <a href="announcement_news.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #00c04b;"></i> News and Events</div></a>
                    </div>
                    <a onclick="myFunction_1()"><i class="fa fa-graduation-cap" id="icon" style="color:rgb(230, 172, 62);"></i>Alumni <i class="fa fa-caret-right" aria-hidden="true" id="arrow-1"></i></a>
                    <div class="list-drpdown-1">
                    
                        <a href="alumni_list.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Alumni List</div></a>
                        <a href="alumni_roles.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #FC3134;"></i> Access Role</div></a>
                        <a href="birhtdaylist.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Birthday List</div></a>
                     </div>
                    <a href="email.php"><i class="fa fa-envelope" id="icon"></i>Email</a>
                    <a href="report.php"><i class="fa fa-exclamation-circle" id="icon"></i>Report</a>
                    <a href="account.php"><i class="fa fa-gear"id="icon"></i>Account Settings</a>
                    <a href="../LOGOUTMODULE/logout.php"><i class="fa fa-sign-out" id="icon"></i>Logout</a>
                </div>
            </div>
        </div>
        <div class="content-box">
            <div class="content"> 
                <div class="page">
                    <div class="head-page">
                        <h1>It's their birthday!</h1>
                    </div>
 
                    <div class="table-container">
                        <form action="">
                           
                            <a href="../ADMIN_2.0/BIRTHDAY/Send.php" class="btn btn-success mx-2 my-3 <?php
                                if(!$greet){
                                    echo "disabled";
                                }
                            ?>">Send Greetings</a>
                        </form>
                        <table id="birthdaytable">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Age</th>
                            </tr>  
                            <?php
                                while($row = mysqli_fetch_assoc($showAlumniList_query)){ 
                            ?>
                            <tr>
                                <td> <?php echo $row['Id'] ?> </td>
                                <td> <?php echo $row['Firstname']." ".$row['Middlename']." ".$row['Lastname']  ?> </td>
                                <td> <?php echo $row['Age'] ?> </td>    
                                
                            </tr>   
                            <?php
                                }
                            ?>                                                                         
                        </table>    
                    </div>
                    <!-- Pages -->
                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                            <strong>Records Found: <?php echo $totalRecords ?></strong>
                        </div>
                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                            <strong>Page <?php 
                                if($totalRecords <= 0){
                                    echo "0 of ".$NoPages;
                                }else{
                                    echo $PageNo." of ".$NoPages;  }
                                ?></strong>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                
                            <li class="page-item" <?php if($PageNo <= 1){ 
                                echo "class='disabled'"; 
                            } ?> >
                                <a class="page-link" <?php if($PageNo > 1){
                                    if(isset($bool)){
                                        echo "href='alumni_list.php?PageNo={$PrevPage}&search={$SearchInAlumni}'";
                                    }
                                    else if(isset($bool2)){
                                        echo "href='alumni_list.php?PageNo={$PrevPage}&sort={$SortAlumniCategory}'";
                                    }
                                    else if(isset($bool3)){
                                        echo "href='alumni_list.php?PageNo={$PrevPage}&searchInSort={$SearchInAlumni}&sorted={$searchInSorted}'";
                                    }
                                    else{
                                        echo "href='alumni_list.php?PageNo=$PrevPage'";
                                    }
                                    
                                } ?>>Previous</a>
                            </li>
                                
                            <li class="page-item" <?php if($PageNo >= $NoPages){
                                    echo "class='disabled'";
                                } ?>>
                                <a class="page-link" <?php if($PageNo < $NoPages) {
                                    if(isset($bool) && $_GET['search'] != ''){
                                        echo "href='alumni_list.php?PageNo={$NextPage}&search={$SearchInAlumni}'";
                                    }
                                    else if(isset($bool2) && $_GET['sort'] != ''){
                                        echo "href='alumni_list.php?PageNo={$NextPage}&sort={$SortAlumniCategory}'";
                                    }
                                    else if(isset($bool3)){
                                        echo "href='alumni_list.php?PageNo={$NextPage}&searchInSort={$SearchInAlumni}&sorted={$searchInSorted}'";
                                    }
                                    else{
                                        echo "href='alumni_list.php?PageNo=$NextPage'";
                                    }
                                } ?>>Next</a>
                            </li>

                            <?php if($PageNo > 1){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=1&search={$SearchInAlumni}'>First Page</a> </li>";
                                    }
                                    else if(isset($bool2) && $_GET['sort'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=1&sort={$SortAlumniCategory}'>First Page</a> </li>";
                                    }
                                    else if(isset($bool3)){
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=1&searchInSort={$SearchInAlumni}&sorted={$searchInSorted}'>First Page</a> </li>'";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=1'>First Page</a> </li>";
                                    }
                            } ?>
                            <?php if($PageNo < $NoPages){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=$NoPages&search={$SearchInAlumni}'>Last Page</a> </li>";
                                    }
                                    else if(isset($bool2) && $_GET['sort'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=$NoPages&sort={$SortAlumniCategory}'>Last Page</a> </li>";
                                    }
                                    else if(isset($bool3)){
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=$NoPages&searchInSort={$SearchInAlumni}&sorted={$searchInSorted}'>Last Page</a> </li>'";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_list.php?PageNo=$NoPages'>Last Page</a> </li>";
                                    }
                            } ?>
                            </ul>
                        </nav> 
                </div>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>