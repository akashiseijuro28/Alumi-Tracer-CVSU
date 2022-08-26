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

    $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM announcement WHERE Status='Removed'";
    $CountRecord_query = mysqli_query($con, $sql_CountRecord);

    $totalRecords = mysqli_fetch_array($CountRecord_query);
    $totalRecords = $totalRecords['totalRecords'];
    $NoPages = ceil($totalRecords / $recordsPerPage);
    $SecLast = $recordsPerPage - 1; 

    //$sql_ARemovedList = "SELECT * FROM announcement WHERE Status='Removed' ";
    $sql_ARemovedList = "SELECT * FROM announcement WHERE Status='Removed' LIMIT $Offset, $recordsPerPage";
    $showARemovedList_query = mysqli_query($con, $sql_ARemovedList);

    //search in Announcement
    if(isset($_POST['searchAnnouncement'])){
        $SearchInAnnouncement = $_POST['SearchInAnnouncement'];
        header("Location: ../ADMIN_2.0/announcementList_remove.php?PageNo=1&search={$SearchInAnnouncement}");  
    }
    if(isset($_GET['search'])){
        $bool = true;
        $SearchInAnnouncement = $_GET['search'];

        $sql_CountRecord = "SELECT COUNT(*) As totalRecords FROM announcement WHERE Status = 'Removed' AND Subject LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND EventDetails LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND Author LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND DateStart LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND DatePosted LIKE '%".$SearchInAnnouncement."%' ";
        $CountRecord_query = mysqli_query($con, $sql_CountRecord);

        $totalRecords = mysqli_fetch_array($CountRecord_query);
        $totalRecords = $totalRecords['totalRecords'];
        $NoPages = ceil($totalRecords / $recordsPerPage);
        $SecLast = $recordsPerPage - 1; 

        $sql_ARemovedList = "SELECT * FROM announcement WHERE Status = 'Removed' AND Subject LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND EventDetails LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND Author LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND DateStart LIKE '%".$SearchInAnnouncement."%' 
            OR Status = 'Removed' AND DatePosted LIKE '%".$SearchInAnnouncement."%' 
            LIMIT $Offset, $recordsPerPage";

            $showARemovedList_query = mysqli_query($con, $sql_ARemovedList);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annoucement | Removed</title>
    <link rel="stylesheet" href="css/announcement.css">
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
                    <a onclick="myFunction()"><i class="fa fa-bullhorn" id="icon"  style="color:rgb(230, 172, 62);"></i>Annoucement <i class="fa fa-caret-right" aria-hidden="true" id="arrow"></i></a>
                    <div class="list-drpdown">
                       <a href="announcementList_all.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Annoucement List</div></a>
                       <a href="announcement_create.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #FC3134;"></i> Create Annoucement</div></a>
                       <a href="announcement_news.php"><div class="items"><i class="fa fa-circle-o" aria-hidden="true" style="color: #00c04b;"></i> News and Events</div></a>
                    </div>
                    <a onclick="myFunction_1()"><i class="fa fa-graduation-cap" id="icon"></i>Alumni <i class="fa fa-caret-right" aria-hidden="true" id="arrow-1"></i></a>
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
                <div class="page" id="announcement-page">
                    <div class="head-page">
                        <h1>Announcement</h1>
                    </div>
                    <div class="table-button">
                        <div class="drop-down">
                            <div class="select-dropdown">
                                <input type="text" placeholder="Removed" class="text-box" readonly>
                                <div class="option">
                                    <a href="announcementList_all.php">All</a>
                                    <a href="announcementList_pending.php">Pending</a>
                                    <a href="announcementList_accept.php">Accepted</a>
                                    <a href="announcementList_remove.php">Removed</a>
                                    <a href="announcementList_decline.php">Declined</a>
                                </div>
                            </div>
                        </div>
                        <!-- Search bar -->
                        <div class="search-bar">
                            <form action="" method="POST">
                                <input name="SearchInAnnouncement" type="text" placeholder="Search ...">
                                <button name="searchAnnouncement"><i class="fa fa-search"></i></button>
                            </form>
                            <h5 style='padding: 10px 20px 0px;'><?php
                            if(isset($bool) && $_GET['search'] != ''){
                                    echo "Results For: '$SearchInAnnouncement'";
                                }
                                else{
                                    echo "";
                                }
                            ?></h5>
                        </div>
                        <!-- New entry -->
                        <div class="new-entry">
                            <a style="text-decoration:none; color: white;" href="announcement_create.php"><button class="btn btn-outline-success">+ New Entry</button></a>
                        </div> 
                    </div>
                    <div class="table-container" id="all-table">
                        <table>
                            <tr>
                                <th>Id</th>
                                <th>Subject</th>
                                <th>Details</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Author</th>
                                <th>Action</th>
                            </tr>  
                            <?php
                                while($row = mysqli_fetch_assoc($showARemovedList_query)){ 
                            ?>
                            <tr>
                                <td> <?php echo $row['AnnouncementId'] ?> </td>
                                <td> <?php echo $row['Subject'] ?> </td>
                                <td> <?php echo $row['EventDetails'] ?> </td>
                                <td> <?php echo $row['DateStart'] ?> </td>
                                <td> <?php echo $row['DatePosted'] ?> </td>
                                <td> <?php echo $row['Author'] ?> </td>
                                <td> <?php echo "<a href='announcement_view.php?View_ID=".$row['AnnouncementId']."' class='btn'> View </a> "?> </td>
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
                                
                            <li class="page-item" <?php if($PageNo <= 1){ echo "class='disabled'"; } ?> >
                                <a class="page-link" <?php if($PageNo > 1){
                                    if(isset($bool)){
                                        echo "href='announcementList_remove.php?PageNo={$PrevPage}&search={$SearchInAnnouncement}'";
                                    }
                                    else{
                                        echo "href='announcementList_remove.php?PageNo=$PrevPage'";
                                    }
                                } ?>>Previous</a>
                            </li>
                                
                            <li class="page-item" <?php if($PageNo >= $NoPages){
                                    echo "class='disabled'";
                                } ?>>
                                <a class="page-link" <?php if($PageNo < $NoPages) {
                                    if(isset($bool)){
                                        echo "href='announcementList_remove.php?PageNo={$NextPage}&search={$SearchInAnnouncement}'";
                                    }
                                    else{
                                        echo "href='announcementList_remove.php?PageNo=$NextPage'";
                                    }
                                } ?>>Next</a>
                            </li>

                            <?php if($PageNo > 1){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='announcementList_remove.php?PageNo=1&search={$SearchInAnnouncement}'>First Page</a> </li>";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='announcementList_remove.php?PageNo=1'>First Page</a> </li>";
                                    }
                            } ?>
                            <?php if($PageNo < $NoPages){
                                if(isset($bool) && $_GET['search'] != ''){
                                    echo "<li class='page-item'> <a class='page-link' href='announcementList_remove.php?PageNo=$NoPages&search={$SearchInAnnouncement}'>Last Page</a> </li>";
                                    }
                                    else{
                                        echo "<li class='page-item'> <a class='page-link' href='announcementList_remove.php?PageNo=$NoPages'>Last Page</a> </li>";
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