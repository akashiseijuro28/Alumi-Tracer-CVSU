<?php 
    $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);

    session_start(); 

    $sql_News = "SELECT a.*,b.* FROM announcementcreation a, announcement b WHERE a.category='News' AND b.announcementId = a.Id AND b.Status='Accepted' order by Id DESC";
    $ShowNews_Query = mysqli_query($con, $sql_News);

    if(isset($_POST['sortNews'])){
        $SubCategorySort = $_POST['SubCatSort'];
        if($SubCategorySort != "All"){
            $sql_News = "SELECT a.*,b.* FROM announcementcreation a, announcement b WHERE a.category='News' AND b.announcementId = a.Id AND b.Status='Accepted' AND a.subcat = '".$SubCategorySort."' order by Id DESC";
            $ShowNews_Query = mysqli_query($con, $sql_News);
        }
        else{
            $sql_News = "SELECT a.*,b.* FROM announcementcreation a, announcement b WHERE a.category='News' AND b.announcementId = a.Id AND b.Status='Accepted' order by Id DESC";
            $ShowNews_Query = mysqli_query($con, $sql_News);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annoucement | News</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/newsandevents.css">
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
                <div class="head-page">
                    <h1>News and Events</h1>
                </div>
                <div class="wrapper">
                    <div class="row-1"> 
                        <div class="buttons">
                            <a href="announcement_news.php"><button style="background-color: #7BADEE;">News</button></a>
                            <a href="announcement_events.php"><button style="background-color: #FC3134;">Events</button></a> 
                        </div>
                        
                        <div class="cty">
                            <form action="" method="POST">
                                <div class="select">
                                    <select name="SubCatSort" id="">
                                        <option value="All" selected hidden>Select Category</option>
                                        <option value="BS - Information Technology">BS - Information Technology</option>
                                        <option value="BS - Computer Science">BS - Computer Science</option>
                                        <option value="BS - Business Management">BS - Business Management</option>
                                        <option value="BS - Hotel and Restaurant Management">BS - Hotel and Restaurant Management</option>
                                        <option value="BS - Entrepreneurship">BS - Entrepreneurship</option>
                                        <option value="BS - Office Administration">BS - Office Administration</option>
                                        <option value="BS - Psychology">BS - Psychology</option>
                                        <option value="B - Secondary Education">B - Secondary Education</option>
                                        <option value="B - Arts in Journalism">B - Arts in Journalism</option>
                                    </select>
                                </div>
                                <div class="button">
                                    <button name="sortNews" class="btn btn-outline-success" type="submit">Sort</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    </form>
                    <div class="row-2">
                    <?php
                        if ($ShowNews_Query->num_rows > 0) {
                            while($row = mysqli_fetch_assoc($ShowNews_Query)) {
                                $monthNum = date('m', strtotime($row['fromdate']));
                                $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                    ?>
                        <div class="box">
                            <div class="date">
                                <h1> <?php echo date('d', strtotime($row['fromdate'])) ?> </h1>
                                <p> <?php echo $monthName ?> </p>
                            </div>
                            <div class="text">
                                <?php echo "<a href='announcement_view.php?View_ID=".$row['Id']."'> <h1>  ".$row['title']." </h1> </a>"?>
                                <p> <?php echo date('d', strtotime($row['fromdate']));
                                echo " ".$monthName. ", ";
                                echo date('y', strtotime($row['fromdate']));
                                 ?> </p>
                                <p style="color: gray;"> <?php echo $row['postdetail'] ?> </p>
                            </div>
                        </div>  
                        <?php
   }} else { $seemore = false;
   ?>
    <div class="container-xxl container-p-y" style="width:100%;">
        <div class="misc-wrapper" style="align-items:center ; text-align:center;">
        <h2 class="mb-2 mx-2 text-center" style="font-size: 30px;">Sorry no announcement yet</h2>
        <p class="mb-4 mx-2 text-center fs-5">Please wait for a while</p>
        </div>
    </div>
    

    <?php
     }  
     ?>
                    </div>
                    <?php
                        if (!isset($seemore)) {
                            # code...
                            echo '<div class="row-3">
                            <a href=""><button>See All Events</button></a> 
                         </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="admin.js"></script>
</body>
</html>