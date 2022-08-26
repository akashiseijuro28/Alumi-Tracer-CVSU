<?php
    $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
    session_start(); 

    if(isset($_GET['View_ID'])){
        $ViewID = mysqli_real_escape_string($con, $_GET['View_ID']);
        $sql_View = "SELECT * FROM announcementcreation WHERE Id='$ViewID' ";
        $View_query = mysqli_query($con, $sql_View);

        if(mysqli_num_rows($View_query) > 0){
            $row = mysqli_fetch_array($View_query);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | View</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/view.css">
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
                <div class="wrapper">
                    <div class="row-1">
                        <div class="head">
                            <h1><?php echo $row['title']; ?></h1>
                        </div>
                        <div class="listed">
                            <div class="cty">
                               <div class="label">Category :</div>
                               <div class="data"><?php echo $row['category'] ?></div>
                            </div>
                            <div class="sub-cty">
                                <div class="label">Sub Category :</div>
                                <div class="data"><?php echo $row['subcat']; ?></div>
                            </div>
                            <div class="posted">
                                <div class="label">Posted on</div>
                                <div class="data"><?php echo $row['fromdate']; ?></div>
                            </div>
                        </div>  
                    </div>
                    <div class="row-2">
                        <div class="image">
                            <div class="img">
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']);?>" alt="<?php echo htmlentities($row['title']);?> ">
                            </div>
                        </div>
                        <div class="details">
                           <?php echo $row['postdetail']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>