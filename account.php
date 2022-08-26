<?php
  $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
  session_start();

       //clyde///
       if(isset($_SESSION['login_info'])&& $_SESSION['login_info']['AccessToken']=="ADMIN"){
        $_SESSION['login_info'];
        $email=$_SESSION['login_info']['Email'];
        $oldpass=$_SESSION['login_info']['Password'];
        }
        else{
        header("location:../LOGOUTMODULE/logout.php");
             }
         if(!isset($_SESSION['login_info']))
            {
        header("location:../LOGOUTMODULE/logout.php");
            }
        //clyde///
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <!-- <link rel="icon" href="img/logo.png"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">

    <!-- clyde -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script/feedback.js"></script>
    <!--font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    label{
        color: #2F4F4F;
        font-weight: 500;
    }
    select{
        color: grey;
        font-weight: 500;
    }
    input{
        color: grey;
        font-weight: 500;
    }
    </style>
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
                    <a href="dashboard.php"><i class="fa fa-home" id="icon"  style="color:rgb(230, 172, 62);"></i>Dashboard</a>
                    <a href="profile.php"><i class="fa fa-user" id="icon"></i>Profile</a>
                    <a onclick="myFunction()"><i class="fa fa-bullhorn" id="icon"></i>Annoucement <i class="fa fa-caret-right" aria-hidden="true" id="arrow"></i></a>
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
 
<div class="card mb-4"style="border:none; margin-top:5%">
   
   <!--start of table 1 -->
   <div class="row">                               
         <div class="col-lg-6 m-b30"style="padding-bottom:5%;">
         <div class="box1"style="margin-bottom:2%;
                                 background-color: white; 
                                 padding:5%;
                                 border-radius:1%; 
                                 box-shadow: 1px 3px 4px 1px rgb(0,0,0,.20);">
   
         <div class="wc-title">    
         <h4>Change Password</h4><hr>
   
       <?php
       //verify password, compare Password from db and entered old password.
       if(isset($_POST['changepassword'])){
         $newpass = $_POST['newpass'];
         $md5pass=md5($newpass);
         $confirm_newpass = $_POST['confirm_newpass'];
         $md5cpass=md5($confirm_newpass);
         $confirm_oldpass = $_POST['confirm_oldpass'];
         $md5oldpass=md5($confirm_oldpass);
         
         $select2="SELECT * FROM userauth WHERE `Password`='$md5pass'";
         $user2 = $con->query($select2) or die ($con->error);
             $row = $user2->fetch_assoc();
             $totaluser2 = $user2->num_rows;
   
           if ($totaluser2>0)
           {
             echo '<div class="alert alert-danger alert-dismissible" role="alert">
             Password must differ from your old password.
             <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
             </div>'; }      
           if($md5pass != $md5cpass){
             echo '<div class="alert alert-danger alert-dismissible" role="alert">
                     Password and Confirm Password Field do not match  !!
                     <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                     </div>'; } 
           if($md5oldpass != $oldpass) {
             echo '<div class="alert alert-danger alert-dismissible" role="alert">
                   You entered an incorrect Current Password.
                   <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                   </div>';}
           if($md5oldpass == $oldpass && $md5pass == $md5cpass && $md5pass!=$oldpass) 
           {   
             $sql ="UPDATE `userauth` SET `Password`= '$md5pass' where `Email`= '$email'";
               mysqli_query($con,$sql);
               $oldpass=$md5pass;         
                   echo '<div class="alert alert-success alert-dismissible" role="alert">
                   Your Password has been changed.
                   <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                   </div>';
                   echo'';
                   sleep(2);
                   unset($_SESSION['login_info']);
                   echo'<script>if(!alert("Password has been changed. Please log in again..")){window.location.reload();}</script>';          
           }
          }           
         ?>                           
   </div>								
   <div class="widget-inner">							
   <form name="chngpwd" onSubmit="return valid();" class="edit-profile m-b30" method="POST" id="formPassword">
     <div class="row">									
         <div class="form-group col-12">
             <label class="col-form-label">Enter Current Password</label>
             <div>
                 <input class="form-control" 
                       type="password" 
                       id="confirm_oldpass" 
                       name="confirm_oldpass" 
                       pattern=".{8,20}" 
                       required="" title="Password must be 8 to 20 characters">
             </div>
         </div>
         <div class="form-group col-12">
             <label class="col-form-label">Enter New Password</label>
             <div>
                 <input class="form-control" 
                       type="password" 
                       id="newpass" 
                       name="newpass" 
                       required="" 
                       pattern=".{8,20}" 
                       required="" 
                       title="Password must be 8 to 20 characters">
               
             </div>
         </div>		
         <div class="form-group col-12">
             <label class="col-form-label">Confirm New Password</label>
             <div>
                 <input class="form-control" 
                         type="password" 
                         id="confirm_newpass" 
                         name="confirm_newpass" 
                         required=""pattern=".{8,20}" 
                         required="" 
                         title="Password must be 8 to 20 characters" >
             </div>
         </div>											
         <div class="col-12">													
             <button style="color:white;
                             background:#349c64; 
                             box-shadow: 1px 1px 1px 1px rgb(0,0,0,.50);
                             border:none;margin-top:5%;float:right;" 
                             type="submit"
                             class="btn btn-info btn-sm" 
                             name="changepassword" 
                             id="changepassword">Submit</button>
         </div>
     </div>
   </form>
   </div>
   </div>
   </div>
   
   
         <div class="col-lg-6 m-b30">
             <div class="box1"
                   style="background-color:white; 
                   padding:5%;
                   border-radius:1%; 
                   box-shadow: 1px 3px 4px 1px rgb(0,0,0,.20);">
           <div class="wc-title">
           <h4>Change Email Address</h4><hr>
   
           <?php 
           
           if(isset($_POST['changeemail']))
           {
            $errormail=false;
            $noerror=false;
               $newemail =($_POST['newemail']);
               $confirm_newemail = ($_POST['confirm_newemail']);
               $confirm_oldpass2 = $_POST['confirm_oldpass2'];
               $md5oldpass2=md5($confirm_oldpass2);

               $select1="SELECT `Email` FROM userauth WHERE `Email`='$newemail'";
               $user1 = $con->query($select1) or die ($con->error);
               $row = $user1->fetch_assoc();
               $totaluser1 = $user1->num_rows;
             if ($totaluser1>0){
                $noemail=$row["Email"];
                 echo '<div class="alert alert-danger alert-dismissible" role="alert">
                 Email already exists !!
                 <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                 </div>'; }
             if($md5oldpass2!=$oldpass ){
                 echo'<div class="alert alert-danger alert-dismissible" role="alert">
                 Incorrect Password !!
                 <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                 </div>';}
             if($newemail!=$confirm_newemail){
                 echo'<div class="alert alert-danger alert-dismissible" role="alert">
                 Email and Confirm Email do not match !!
                 <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                 </div>';}
                if(!isset($noemail) && $newemail!=$email && $md5oldpass2==$oldpass && $newemail==$confirm_newemail)
              {
               $sqlcode1 ="UPDATE `userauth` a,`alumniinfo`b,`jobinfo` c,`survey` d 
                           SET a.`Email`= '$newemail', b.`Email`= '$newemail', c.`Email`= '$newemail', d.`Email`= '$newemail' 
                           where a.`Email`= '$email' AND b.`Email`= '$email'  AND c.`Email`= '$email' AND d.`Email`= '$email'";
               mysqli_query($con,$sqlcode1);
               $email=$newemail;  
                   echo '<div class="alert alert-success alert-dismissible" role="alert">
                   Your Email has been changed.
                     <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                   </div>';
                   echo'';
                   sleep(2);
                   unset($_SESSION['login_info']);
                   echo'<script>if(!alert("Email has been changed. Please log in again..")){window.location.reload();}</script>';
             }
             } 			
        ?>		
                  
   </div>								
   <div class="widget-inner">							
       <form class="edit-profile m-b30" method="POST"  id="formEmail">
           <div class="row">								
               <div class="form-group col-12">
                   <label class="col-form-label">Enter New Email Address</label>
                   <div>
                       <input class="form-control" 
                             type="email" 
                             id="newemail" 
                             name="newemail" 
                             required="">
                   </div>
               </div>
               <div class="form-group col-12">
                   <label class="col-form-label">Confirm New Email Address</label>
                   <div>
                       <input class="form-control" 
                       type="email" 
                       id="confirm_newemail" 
                       name="confirm_newemail" 
                       required="">
                   </div>
               </div>		
               <div class="form-group col-12">
                   <label class="col-form-label">Password</label>
                   <div>
                       <input class="form-control" 
                             type="password" 
                             id="confirm_oldpass2" 
                             name="confirm_oldpass2" 
                             required="">
               </div>
               </div>											
               <div class="col-12">								
                   <button style="color:white;
                                 background:#349c64; 
                                 box-shadow: 1px 1px 1px 1px rgb(0,0,0,.50);
                                 border:none;
                                 margin-top:5%;
                                 float:right;" 
                                 type="submit" 
                                 class="btn btn-info btn-sm" 
                                 name="changeemail" 
                                 id="changeemail">Submit</button>
               </div>
           </div>
   </form>
   </div>
   </div>
   </div>
   </div></div>
   </div>
   
   
   <script>
   if ( window.history.replaceState ) {
     window.history.replaceState( null, null, window.location.href );
   }
   </script>   
   
           <!--clyde  -->
   
          
         </div>
       </div>
     </div>			

    <script src="my_chart.js"></script>
    <script src="admin.js"></script>

</script>
</body>
</html>