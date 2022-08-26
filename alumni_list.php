<?php
ob_start();

   $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
    session_start(); 
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

    if(isset($_GET['search'])){
        $bool = true;
        $SearchInAlumni = $_GET['search'];
        $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo WHERE Firstname LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Lastname LIKE '%".$SearchInAlumni."%' 
            OR Email LIKE '%".$SearchInAlumni."%' 
            OR Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Address LIKE '%".$SearchInAlumni."%' 
            OR CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Sex LIKE '%".$SearchInAlumni."%' 
            OR Course LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Batchyear LIKE '%".$SearchInAlumni."%' 
            ";
            
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

            $sql_alumniList = "SELECT * FROM alumniinfo WHERE Firstname LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Lastname LIKE '%".$SearchInAlumni."%' 
            OR Email LIKE '%".$SearchInAlumni."%' 
            OR Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Address LIKE '%".$SearchInAlumni."%' 
            OR CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Sex LIKE '%".$SearchInAlumni."%' 
            OR Course LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Batchyear LIKE '%".$SearchInAlumni."%' 
            LIMIT $Offset, $recordsPerPage";
            $showAlumniList_query = mysqli_query($con, $sql_alumniList);
    }
    else{
        $_SESSION['indicator'] = false;

        $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo ";
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

        $sql_alumniList = "SELECT * FROM `alumniinfo` LIMIT $Offset, $recordsPerPage";

        //Alumni List
        //$sql_alumniList = "SELECT * FROM alumniinfo";
        $showAlumniList_query = mysqli_query($con, $sql_alumniList);
    
    }
    if(isset($_GET['searchInSort']) && ($_GET['sorted'])){
        $bool3 = true;
        $SearchInAlumni = $_GET['searchInSort'];
        $searchInSorted = $_GET['sorted'];
        if($searchInSorted != "All"){
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo WHERE Course = '".$searchInSorted."' AND Firstname LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Middlename LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Lastname LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Email LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Address LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Sex LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Middlename LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Batchyear LIKE '%".$SearchInAlumni."%' 
            ";
            
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

            $sql_alumniList = "SELECT * FROM alumniinfo WHERE Course = '".$searchInSorted."' AND Firstname LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Middlename LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Lastname LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Email LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Address LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Sex LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Middlename LIKE '%".$SearchInAlumni."%' 
            OR Course = '".$searchInSorted."' AND Batchyear LIKE '%".$SearchInAlumni."%' 
            LIMIT $Offset, $recordsPerPage";
            $showAlumniList_query = mysqli_query($con, $sql_alumniList);
        }else{
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo WHERE Firstname LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Lastname LIKE '%".$SearchInAlumni."%' 
            OR Email LIKE '%".$SearchInAlumni."%' 
            OR Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Address LIKE '%".$SearchInAlumni."%' 
            OR CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Sex LIKE '%".$SearchInAlumni."%' 
            OR Course LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Batchyear LIKE '%".$SearchInAlumni."%' 
            ";
            
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

            $sql_alumniList = "SELECT * FROM alumniinfo WHERE Firstname LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Lastname LIKE '%".$SearchInAlumni."%' 
            OR Email LIKE '%".$SearchInAlumni."%' 
            OR Birthdate LIKE '%".$SearchInAlumni."%' 
            OR Phonenum LIKE '%".$SearchInAlumni."%' 
            OR Address LIKE '%".$SearchInAlumni."%' 
            OR CivilStat LIKE '%".$SearchInAlumni."%' 
            OR Sex LIKE '%".$SearchInAlumni."%' 
            OR Course LIKE '%".$SearchInAlumni."%' 
            OR Middlename LIKE '%".$SearchInAlumni."%' 
            OR Batchyear LIKE '%".$SearchInAlumni."%' 
            LIMIT $Offset, $recordsPerPage";
            $showAlumniList_query = mysqli_query($con, $sql_alumniList);
        }
    }
    //alumniSorter
    if(isset($_POST['sortAlumni'])){
        $SortAlumniCategory = $_POST['SortAlumniBy'];
        header("Location: ../ADMIN_2.0/alumni_list.php?PageNo=1&sort={$SortAlumniCategory}");
    }

    if(isset($_GET['sort'])){
        $bool2 = true;
        $SortAlumniCategory = $_GET['sort'];
        if($SortAlumniCategory != "All"){
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM alumniinfo WHERE Course = '".$SortAlumniCategory."'";
            $CountRecord_query = mysqli_query($con, $sql_CountRecord);

            $totalRecords = mysqli_fetch_array($CountRecord_query);
            $totalRecords = $totalRecords['totalRecords'];
            $NoPages = ceil($totalRecords / $recordsPerPage);
            $SecLast = $recordsPerPage - 1;

            $sql_alumniList = "SELECT * FROM alumniinfo WHERE Course = '" .$SortAlumniCategory. "' LIMIT $Offset, $recordsPerPage";
            $showAlumniList_query = mysqli_query($con, $sql_alumniList);
        }
        else{
            $sql_alumniList = "SELECT * FROM alumniinfo LIMIT $Offset, $recordsPerPage";
            $showAlumniList_query = mysqli_query($con, $sql_alumniList);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni List</title>
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
                        <h1>Alumni List</h1>
                    </div>
                    <div class="table-button">
                        <!-- Search bar -->
                        <div class="search-bar">
                            <form action="" method="POST">
                                <input name="SearchInAlumni" type="text" placeholder="Search ...">
                                <button name="searchAlumni"><i class="fa fa-search"></i></button>
                            </form>
                            <h5 style='padding: 10px 20px 0px;'><?php
                            if(isset($bool) && $_GET['search'] != ''){
                                    echo "Results For: '$SearchInAlumni'";
                                }
                                else if(isset($bool3) && $_GET['searchInSort'] != ''){
                                    echo "Results For: '$SearchInAlumni' in '$searchInSorted'";
                                }
                                else{
                                    echo "";
                                }
                            ?></h5>
                        </div>
                        <!-- Sort -->
                        <div class="sort">
                            <form action="" method="POST" class="d-flex dropdown ms-5">
                                <select name="SortAlumniBy" class="form-select me-2">
                                   <?php
                                        if(isset($_GET['sort'])){
                                            $sortShow = $_GET['sort'];
                                            echo"<option value='$sortShow' disabled selected hidden>$sortShow</option>";
                                            echo "<option value='All'>All</option>";
                                        }
                                        else if(isset($_GET['sorted'])){
                                            $sortShow = $_GET['sorted'];
                                            echo"<option value='$sortShow' disabled selected hidden>$sortShow</option>";
                                            echo "<option value='All'>NONE</option>";
                                        }
                                        else{
                                            echo "<option value='All'>Select Course</option>";
                                        }
                                    ?>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BSBM">BSBM</option>
                                    <option value="BSHRM">BSHRM</option>    
                                    <option value="BSOA">BSOA</option>
                                    <option value="BSE">BSE</option>
                                    <option value="AB Journalism">AB Journalism</option>
                                    <option value="BS Psychology">BS Psychology</option>    
                                    <option value="BS Entrepreneur">BS Entrepreneur</option>                                          
                                  </select>
                                <button name="sortAlumni" class="btn btn-outline-success" type="submit">Sort</button>
                            </form>
                            <a style="text-decoration:none; color: white;" href="alumni_roles.php"><button style="text-decoration:none; background-color: rgb(123,173,238); margin-left: 8px;" class="btn btn-outline-success">Access Roles</button> </a>
                        </div>

                    </div>
                    <div class="table-container">
                        <table>
                            <tr>
                                <th>Alumni id</th>
                                <th>First name</th>
                                <th>Middle name</th>
                                <th>Last name</th>
                                <th>Email</th>
                                <th>Birthdate</th>
                                <th>Phone no.</th>
                                <th>Address</th>
                                <th>Civil Status</th>
                                <th>Sex</th>
                                <th>Course</th>
                            </tr>  
                            <?php
                                while($row = mysqli_fetch_assoc($showAlumniList_query)){ 
                            ?>
                            <tr>
                                <td> <?php echo $row['Id'] ?> </td>
                                <td> <?php echo $row['Firstname'] ?> </td>
                                <td> <?php echo $row['Middlename'] ?> </td>
                                <td> <?php echo $row['Lastname'] ?> </td>
                                <td> <?php echo $row['Email'] ?> </td>
                                <td> <?php echo $row['Birthdate'] ?> </td>
                                <td> <?php echo $row['Phonenum'] ?> </td>
                                <td> <?php echo $row['Address'] ?> </td>
                                <td> <?php echo $row['CivilStat'] ?> </td>
                                <td> <?php echo $row['Sex'] ?> </td>
                                <td> <?php echo $row['Course'] ?> </td>
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