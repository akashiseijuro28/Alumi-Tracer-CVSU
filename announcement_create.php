<?php
    $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);

    session_start();
    $sqlcode = "SELECT * FROM alumniinfo b WHERE Email = '{$_SESSION['login_info']['Email']}' ;";
    $result = mysqli_query($con, $sqlcode);
    $row =  $result->fetch_assoc();
    
    $_SESSION["Firstname"] =  $row['Firstname'];
    $_SESSION["Lastname"] =  $row['Lastname'];

    if (isset($_POST['CreateAnnouncement'])) {
      $category = $_POST['ctgry1'];
      $seccategory = $_POST['ctgry2'];
      
      $fromdate = date ('Y-m-d\ H:i:s', strtotime($_POST['DateStart']));
      $todate = date ('Y-m-d\ H:i:s', strtotime($_POST['DateEnd']));
      $Ptitle = $_POST['Title'];
      $body = $_POST['Details'];
      $fimage = addslashes(file_get_contents($_FILES["AnnouncementImage"]["tmp_name"]));
      $uniqid = uniqid('id'); 
      $author =  $_SESSION["Firstname"]." ".$_SESSION["Lastname"]; 
      
      $sqlcode = "INSERT INTO `announcement` (`AnnouncementId`, `Subject`, `EventDetails`, `DateStart`, `DatePosted`, `Author`, `Status`) VALUES ('{$uniqid}', '{$Ptitle}', '{$body}', '{$fromdate}', '{$todate}', '{$author}', 'Accepted');";
      $result = mysqli_query($con,$sqlcode);
      /*$sqlcode ="INSERT INTO `announcementcreation` (`Id`, `fromdate`, `todate`, `category`, `subcat`, `postdetail`, `image`, `title`) VALUES ('{$uniqid}', '{$fromdate}', '{$todate}', '{$category}', '{$seccategory}', '{$body}', '{$fimage}', '{$Ptitle}');";
      $result = mysqli_query($con,$sqlcode);*/

        $imgfile=$_FILES["AnnouncementImage"]["name"];
        $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
        $allowed_extensions = array(".jpg","jpeg",".png",".gif");
        if(!in_array($extension,$allowed_extensions)){

        }
        else{
        //rename the image file
        $imgnewfile=md5($imgfile).$extension;
        // Code for move image into directory
        //move_uploaded_file($_FILES["AnnouncementImage"]["tmp_name"],"images/".$imgnewfile);
        $imgnewfile = $fimage;
        $sqlcode ="INSERT INTO `announcementcreation` (`Id`, `fromdate`, `todate`, `category`, `subcat`, `postdetail`, `image`, `title` ) VALUES ('{$uniqid}', '{$fromdate}', '{$todate}', '{$category}', '{$seccategory}', '{$body}', '{$imgnewfile}', '{$Ptitle}');";
        $result = mysqli_query($con,$sqlcode);
        if($result){
        	echo "<script> alert('Announcement Successfully Created!'); </script>";
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Annoucement</title>
    <link rel="stylesheet" href="css/new_announcement.css">
    <link rel="icon" href="img/logo.png">
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
                    <div class="text">
                        <h1>Create an Announcement</h1>
                    </div>
                    <div class="back">
                        <a href="announcementList_all.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go back</a>
                    </div>   
                </div>
               <div class="container-data">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="input-data">
                            <div class="row">
                                <div class="col-1">
                                    <div class="date">
                                        <div class="from-date">
                                            <label for="">From date</label>
                                            <!-- <input name="DateStart" type="date" id="from" /> -->
                                            <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>"
                                            name="DateStart" id="from" required />
                                        </div>
                                        <div class="to-date">
                                            <label for="">To date</label>
                                            <!-- <input name="DateEnd" type="date" id="to"> -->
                                            <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>"
                                            name="DateEnd" id="to" required />
                                        </div>
                                    </div>
                                <div class="post-title">
                                    <label for="">Post title</label>
                                    <input name="Title" type="text" placeholder="Place title here" required>
                                </div>
                                <div class="category">
                                    <div class="cty-1">
                                        <label for="">Category</label>
                                        <select name="ctgry1" id="" required>
                                            <option value="" disabled selected hidden>Open this select menu</option>
                                            <option value="News">News</option>
                                            <option value="Events">Events</option>
                                        </select>
                                    </div>
                                    <div class="cty-2">
                                        <label for="">Sub Category</label>
                                        <select name="ctgry2" id="" required>
                                            <option value="" disabled selected hidden>Open this select menu</option>
                                            <option value="BS - Information Technology">BS - Information Technology</option>
								            <option value="BS - Computer Science">BS - Computer Science</option>
								            <option value="BS - Business Management">BS - Business Management</option>
								            <option value="BS - Hotel and Restaurant Management">BS - Hotel and Restaurant Management</option>
								            <option value="BS - Entrepreneurship">BS - Entrepreneurship</option>
								            <option value="BS - Office Administration">BS - Office Administration</option>
								            <option value="BBS - Psychology">BS - Psychology</option>
								            <option value="B - Secondary Education">B - Secondary Education</option>
								            <option value="B - Arts in Journalism">B - Arts in Journalism</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-2">
                                    <img src="img/undraw_referral_re_0aji.svg" alt="">
                                </div>
                            </div>
                            <div class="details">
                                <label for="">Post details</label>
                                <textarea name="Details" id="" cols="30" rows="10" placeholder="Click here to create announcement" required></textarea>
                            </div>
                            <div class="file">
                                <label for="formFile">Featured imaged</label>
                                <!--<label for="file" id="upload"><i class="fa fa-picture-o"></i> + Add image</label>
                                <input name="AnnouncementImage" type="file" id="file" accept="image/png, image/gif, image/jpeg, image/jpg"style="display: none;"> -->
                                <input class="form-control" type="file" accept="image/png, image/gif, image/jpeg" id="formFile"
                                name="AnnouncementImage" required/>
                            </div>
                            <div class="buttons">
                                <button Name="CreateAnnouncement" type="submit" id="send">Create</button>
                                <span> | </span>
                                <button type="reset" id="discard">Discard</button>
                            </div> 
                        </div>
                    </form>
               </div>
            </div>
        </div>
    </div>
    <script>
        function CreateNotif(){
            alert("Announcement Successfully Created!");
        }
    </script> 
    <script src="admin.js"></script>
    <script src="limit.js"></script>
</body>
</html>