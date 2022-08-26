<?php
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

    $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM userauth ";
    $CountRecord_query = mysqli_query($con, $sql_CountRecord);

    $totalRecords = mysqli_fetch_array($CountRecord_query);
    $totalRecords = $totalRecords['totalRecords'];
    $NoPages = ceil($totalRecords / $recordsPerPage);
    $SecLast = $recordsPerPage - 1;

    //$sql_roleList = "SELECT * FROM userauth";
    $sql_roleList = "SELECT * FROM userauth LIMIT $Offset, $recordsPerPage";
    $showRoleList_query = mysqli_query($con, $sql_roleList);

    //changeRole functions
    if (isset($_GET['AdminRole_ID'])){
        $AdminRole_ID = $_GET['AdminRole_ID'];

        $sql_AdminRole = "UPDATE userauth SET AccessToken = 'ADMIN' WHERE id = '".$AdminRole_ID."' ";
        $AdminRole_Query = mysqli_query($con, $sql_AdminRole);

        if($AdminRole_Query){
            header("Location: alumni_roles.php");
        }
    }
    if (isset($_GET['StaffRole_ID'])){
        $StaffRole_ID = $_GET['StaffRole_ID'];

        $sql_StaffRole = "UPDATE userauth SET AccessToken = 'STAFF' WHERE id = '".$StaffRole_ID."' ";
        $StaffRole_Query = mysqli_query($con, $sql_StaffRole);

        if($StaffRole_Query){
            header("Location: alumni_roles.php");
        }
    }
    if (isset($_GET['AlumniRole_ID'])){
        $AlumniRole_ID = $_GET['AlumniRole_ID'];

        $sql_AlumniRole = "UPDATE userauth SET AccessToken = 'ALUMNI' WHERE id = '".$AlumniRole_ID."' ";
        $AlumniRole_Query = mysqli_query($con, $sql_AlumniRole);

        if($AlumniRole_Query){
            header("Location: alumni_roles.php");
        }
    }
    //searchButtton 
    if(isset($_POST['searchRole'])){
        $SearchInRoles = $_POST['SearchInRoles'];
        $searchInSorted = $_GET['sort'];
        if($searchInSorted != NULL){
            header("Location: ../ADMIN_2.0/alumni_roles.php?PageNo=1&searchInSort={$SearchInRoles}&sorted={$searchInSorted}");
        }
        else{
            header("Location: ../ADMIN_2.0/alumni_roles.php?PageNo=1&search={$SearchInRoles}");
        }
        
        }

    if(isset($_GET['search'])){
        $bool = true;
        $SearchInRoles = $_GET['search'];
        $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM userauth WHERE Email LIKE '%".$SearchInRoles."%'
        OR AccessToken LIKE '%".$SearchInRoles."%'  
        ";

        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

        $sql_roleList = "SELECT * FROM userauth WHERE Email LIKE '%".$SearchInRoles."%' 
        OR AccessToken LIKE '%".$SearchInRoles."%'  
        LIMIT $Offset, $recordsPerPage";
        $showRoleList_query = mysqli_query($con, $sql_roleList);
    }

    if(isset($_GET['searchInSort']) && ($_GET['sorted'])){
        $bool3 = true;
        $SearchInRoles = $_GET['searchInSort'];
        $searchInSorted = $_GET['sorted'];
        if($searchInSorted != "All"){
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM userauth WHERE AccessToken = '".$searchInSorted."' AND Email LIKE '%".$SearchInRoles."%'  
            ";

            $CountRecord_query = mysqli_query($con, $sql_CountRecord);

            $totalRecords = mysqli_fetch_array($CountRecord_query);
            $totalRecords = $totalRecords['totalRecords'];
            $NoPages = ceil($totalRecords / $recordsPerPage);
            $SecLast = $recordsPerPage - 1;

            $sql_roleList = "SELECT * FROM userauth WHERE AccessToken = '".$searchInSorted."' AND Email LIKE '%".$SearchInRoles."%' 
            LIMIT $Offset, $recordsPerPage";
            $showRoleList_query = mysqli_query($con, $sql_roleList);
        }else{
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM userauth WHERE Email LIKE '%".$SearchInRoles."%'
        OR AccessToken LIKE '%".$SearchInRoles."%'  
        ";

        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1;

        $sql_roleList = "SELECT * FROM userauth WHERE Email LIKE '%".$SearchInRoles."%' 
        OR AccessToken LIKE '%".$SearchInRoles."%'  
        LIMIT $Offset, $recordsPerPage";
        $showRoleList_query = mysqli_query($con, $sql_roleList);
        }
    }
    //roleSorter
    if(isset($_POST['sortRole'])){
        $SortRoleCategory = $_POST['SortRoleBy'];
        header("Location: ../ADMIN_2.0/alumni_roles.php?PageNo=1&sort={$SortRoleCategory}");
    }

    if(isset($_GET['sort'])){
        $bool2 = true;
        $SortRoleCategory = $_GET['sort'];
        if($SortRoleCategory != "All"){ 
            $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM userauth WHERE AccessToken = '".$SortRoleCategory."'
            ";
            $CountRecord_query = mysqli_query($con, $sql_CountRecord);

            $totalRecords = mysqli_fetch_array($CountRecord_query);
            $totalRecords = $totalRecords['totalRecords'];
            $NoPages = ceil($totalRecords / $recordsPerPage);
            $SecLast = $recordsPerPage - 1;

            $sql_roleList = "SELECT * FROM userauth WHERE AccessToken = '".$SortRoleCategory."' LIMIT $Offset, $recordsPerPage";
            $showRoleList_query = mysqli_query($con, $sql_roleList);
        }
        else{
            $sql_roleList = "SELECT * FROM userauth LIMIT $Offset, $recordsPerPage";
            $showRoleList_query = mysqli_query($con, $sql_roleList);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni List | Roles</title>
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
                        <h1>Alumni List - Roles</h1>
                    </div>
                    <div class="table-button">
                        <!-- Search bar -->
                        <div class="search-bar">
                            <form action="" method="POST">
                                <input name="SearchInRoles" type="text" placeholder="Search ..."><button name="searchRole"><i class="fa fa-search"></i></button>
                            </form>
                            <h5 style='padding: 10px 20px 0px;'><?php
                            if(isset($bool) && $_GET['search'] != ''){
                                    echo "Results For: '$SearchInRoles'";
                                }
                                else if(isset($bool3) && $_GET['searchInSort'] != ''){
                                    echo "Results For: '$SearchInRoles' in '$searchInSorted'";
                                }
                                else{
                                    echo "";
                                }
                            ?></h5>
                        </div>
                        <!-- Sort -->
                        <div class="sort">
                            <form action="" method="POST" class="d-flex dropdown ms-5">
                                <select name="SortRoleBy" class="form-select me-2">
                                    <?php
                                        if(isset($_GET['sort'])){
                                            $sortShow = $_GET['sort'];
                                            echo"<option value='' disabled selected hidden>$sortShow</option>";
                                            echo "<option value='All'>NONE</option>";
                                        }
                                        else if(isset($_GET['sorted'])){
                                            $sortShow = $_GET['sorted'];
                                            echo"<option value='' disabled selected hidden>$sortShow</option>";
                                            echo "<option value='All'>NONE</option>";
                                        }else{
                                            echo "<option value='All'>SELECT ROLE</option>";
                                        }
                                    ?>
                                    <option value="ALUMNI">ALUMNI</option>
                                    <option value="STAFF">STAFF</option>
                                    <option value="ADMIN">ADMIN</option>                         
                                  </select>
                                <button name="sortRole" class="btn btn-outline-success" type="submit">Sort</button>
                            </form>
                        </div> 
                    </div>
                    <form action="" method="GET">
                    <div class="table-container">
                        <table>
                            <tr>
                                <th>Alumni id</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>  
                            <?php
                                while($row = mysqli_fetch_assoc($showRoleList_query)){ 
                            ?>
                            <tr>
                                <td> <?php echo $row['id'] ?> </td>
                                <td> <?php echo $row['Email'] ?> </td>
                                <td> <?php echo $row['AccessToken'] ?> </td>
                                <td> <?php echo "
                                <div class='dropdown'>
                                        <a style='background-color: rgb(123,173,238); border: none;' class='btn btn-secondary dropdown-toggle' href='#'' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                          Role
                                        </a>
                                        <ul class='dropdown-menu'>
                                          <li><a class='dropdown-item' href='alumni_roles.php?AdminRole_ID=".$row['id']."' class='btn' onclick='AdminNotif()'> Admin </a> </li>
                                          <li><a class='dropdown-item' href='alumni_roles.php?StaffRole_ID=".$row['id']."' class='btn' onclick='StaffNotif()'> Staff </a></li>
                                          <li><a class='dropdown-item' href='alumni_roles.php?AlumniRole_ID=".$row['id']."' class='btn' onclick='AlumniNotif()'> Alumni </a></li>
                                        </ul>
                                </div>
                                "?>
                                    
                                </td>
                            </tr>   
                            <?php
                                }
                            ?>                                                                         
                        </table>    
                    </div>
                    </form>
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
                                        echo "href='alumni_roles.php?PageNo={$PrevPage}&search={$SearchInRoles}'";
                                    }
                                    else if(isset($bool2)){
                                        echo "href='alumni_roles.php?PageNo={$PrevPage}&sort={$SortRoleCategory}'";
                                    }
                                    else if(isset($bool3)){
                                        echo "href='alumni_roles.php?PageNo={$PrevPage}&searchInSort={$SearchInRoles}&sorted={$searchInSorted}'";
                                    }
                                    else{
                                        echo "href='alumni_roles.php?PageNo=$PrevPage'";
                                    }
                                    
                                } ?>>Previous</a>
                            </li>
                                
                            <li class="page-item" <?php if($PageNo >= $NoPages){
                                    echo "class='disabled'";
                                } ?>>
                                <a class="page-link" <?php if($PageNo < $NoPages) {
                                    if(isset($bool)){
                                        echo "href='alumni_roles.php?PageNo={$NextPage}&search={$SearchInRoles}'";
                                    }
                                    else if(isset($bool2)){
                                        echo "href='alumni_roles.php?PageNo={$NextPage}&sort={$SortRoleCategory}'";
                                    }
                                    else if(isset($bool3)){
                                        echo "href='alumni_roles.php?PageNo={$NextPage}&searchInSort={$SearchInRoles}&sorted={$searchInSorted}'";
                                    }
                                    else{
                                        echo "href='alumni_roles.php?PageNo=$NextPage'";
                                    }
                                } ?>>Next</a>
                            </li>

                            <?php if($PageNo > 1){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=1&search={$SearchInRoles}'>First Page</a> </li>";
                                    }
                                    else if(isset($bool2) && $_GET['sort'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=1&sort={$SortRoleCategory}'>First Page</a> </li>";
                                    }
                                    else if(isset($bool3) && $_GET['searchInSort'] != ''){
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=1&searchInSort={$SearchInRoles}&sorted={$searchInSorted}'>First Page</a> </li>'";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=1'>First Page</a> </li>";
                                    }
                            } ?>
                            <?php if($PageNo < $NoPages){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=$NoPages&search={$SearchInRoles}'>Last Page</a> </li>";
                                    }
                                    else if(isset($bool2) && $_GET['sort'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=$NoPages&sort={$SortRoleCategory}'>Last Page</a> </li>";
                                    }
                                    else if(isset($bool3) && $_GET['searchInSort'] != ''){
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=$NoPages&searchInSort={$SearchInRoles}&sorted={$searchInSorted}'>Last Page</a> </li>'";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='alumni_roles.php?PageNo=$NoPages'>Last Page</a> </li>";
                                    }
                            } ?>
                            </ul>
                        </nav> 
                </div>
            </div>
        </div>
    </div>
    <script>
        function AdminNotif(){
            alert("Role has been changed to Admin");
        }

        function StaffNotif(){
           alert("Role has been changed to Staff");
        }

        function AlumniNotif(){
           alert("Role has been changed to Alumni");
        }
    </script> 
    <script src="admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>