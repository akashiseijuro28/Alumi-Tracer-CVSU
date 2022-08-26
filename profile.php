<?php
  $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
  session_start();

    
if(isset($_SESSION['login_info'])&& $_SESSION['login_info']['AccessToken']=="ADMIN")
{
      $_SESSION['login_info'];
      $email=$_SESSION['login_info']['Email'];
      $access=$_SESSION['login_info']['AccessToken'];

//SELECT ALUMNIINFO-CLYDE
      $alumniinfo="SELECT * FROM alumniinfo WHERE `Email`='$email'";
      $alumniuser = $con->query($alumniinfo) or die ($con->error);
      $row = $alumniuser->fetch_assoc();
      $totalalumniinfo = $alumniuser->num_rows; 
        if ($totalalumniinfo>0)
        {
          $_SESSION ['Firstname']=  $row["Firstname"];
          $_SESSION ['Lastname']=  $row["Lastname"];
          $_SESSION ['Middlename']=  $row["Middlename"];
          $_SESSION ['CivilStat']=  $row["CivilStat"];
          $_SESSION ['Sex']=  $row["Sex"];
          $_SESSION ['Phonenum']=  $row["Phonenum"];
          $_SESSION ['Address']=  $row["Address"];
          $_SESSION ['Email']=  $row["Email"];
          $_SESSION ['Birthdate']=  $row["Birthdate"];
        }
        $currentDate = date("d-m-Y");
        $age = date_diff(date_create($_SESSION ['Birthdate']), date_create($currentDate));

//UPDATE ALUMNIINFO -CLYDE
       if(isset($_POST['update']))
       {
        $Firstname = strtoupper($_POST['Firstname']);
        $Lastname = strtoupper($_POST['Lastname']);
        $Middlename =strtoupper($_POST['Middlename']);
        $Address =strtoupper($_POST['Address']);
        $Sex = strtoupper($_POST['Sex']);
        $CivilStat =strtoupper($_POST['CivilStat']);
        $Phonenum =($_POST['Phonenum']);
        $Birthdate = ($_POST['Birthdate']);

        $sql2 = "UPDATE `alumniinfo` 
                 SET `Firstname` = '$Firstname',
                    `Birthdate` = '$Birthdate',
                    `Lastname`= '$Lastname',  
                    `Middlename` = '$Middlename',
                    `Address`= '$Address',
                    `Sex`= '$Sex',
                    `CivilStat`= '$CivilStat',
                    `Phonenum`= '$Phonenum'          
                 WHERE  `Email`='$email'";
        if($con->query($sql2)==TRUE)
        {
            echo'<script> alert("Your Profile has been Updated.")</script>';
            $_SESSION['Firstname']=$Firstname;
            $_SESSION['Lastname']=$Lastname;
            $_SESSION['Middlename']=$Middlename;
            $_SESSION['Address']=$Address;
            $_SESSION['Sex']=$Sex;
            $_SESSION['CivilStat']=$CivilStat;
            $_SESSION['Phonenum']=$Phonenum;
            $_SESSION['Birthdate']=$Birthdate;      
        } 
      }
}
else
{
  header("location:../LOGOUTMODULE/logout.php");
}
if(!isset($_SESSION['login_info']))
{
  header("location:../LOGOUTMODULE/logout.php");
}     

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                <div class="head-page">
                    <h1>Profile</h1>
                </div>
                     
                    </div>
                     <!--profile -->
     <!-- START OF CONTENT - CLYDE --><!-- START OF CONTENT - CLYDE --><!-- START OF CONTENT - CLYDE --><!-- START OF CONTENT - CLYDE -->
<div class="content-wrapper" >        
<!-- clyde -->
<div class="container-xxl flex-grow-1 container-p-y">
<BR>
  <div class="card mb-4" style="padding:2px;box-shadow: 2px 3px 5px 2px rgb(164,164,164,.1);"">
      <div class="row"style="margin-bottom:-8%">
        <div class="col"style="width:80%">
        <h5 
            style="position:absolute;
                    float:left;
                    margin-top:2%; 
                    margin-left:3%;
                    font-size: larger;
                    background:white;
                    text-decoration:none">Personal Details 
        </h5>
    </div>
    <div class="col"style="width:20%"> 
    <div id="feedback">
    <button type="button" 
            class="btn btn-info btn-lg"
            data-toggle="modal" 
            data-target="#feedback-modal"  
            style="border:none; 
                  margin:3%;
                  margin-right:5%;
                  float:right ;
                  background:#349c64;
                  box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30);
                  padding:2px 7px 2px 7px">Edit
      </button>
      </div>
      </div>

<!--start of table 1 -->

<!-- Trigger the modal with a button -->
  <div class="container-a"style="margin:10px"> 

      <div id="feedback-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <div class="modal-content">	
          <div class="modal-header">
            <h3 class="modal-title"style="margin-left:32%;;text-align:center;color:GREY">Update Profile </h3>
                <button type="button" 
                        class="btn-close" 
                        style="margin:-2% 0% -2% 0%; border:2px outset #eeeee4"
                        data-dismiss="modal"> 
                </button>
          </div>			
    <br>
    <div class="modal-body">
    <div class="container2">

      <form class="feedback" 
            name="feedback" 
            id="feedback">

        <div class="row">
        <div class="col-md-6">
          <input type="hidden" 
                 name="update" 
                 id="update" 
                 value="">

            <label style="padding-left:2%">First Name:</label>
            <input type="text" 
                   name = "Firstname" 
                   onkeypress="return /[zA-Z]/i.test(event.key)" 
                   style="width: 100%; height:35px; margin-bottom:5%;" 
                   value ="<?php echo $_SESSION['Firstname']; ?>">

            <label style="padding-left:2%">Middle Name:</label>
            <input type="text" 
                   name = "Middlename"
                   onkeypress="return /[zA-Z]/i.test(event.key)"
                   style="width: 100%; height:35px; margin-bottom:5%;" 
                   value ="<?php echo $_SESSION['Middlename']; ?>">

            <label style="padding-left:2%">Last Name:</label>
            <input type="text" 
                  name = "Lastname"
                  onkeypress="return /[zA-Z]/i.test(event.key)" 
                  style="width: 100%; height:35px; margin-bottom:5%;" 
                  value ="<?php echo $_SESSION['Lastname']; ?>">

            <label style="padding:0%">Sex:</label>
            <select class="sexo"
                    name="Sex" 
                    style="width: 100%; height:35px; margin-bottom:5%;">
                    <option value="<?php echo $_SESSION['Sex']?>" style="display: none;" ><?php echo $_SESSION['Sex']?></option>    
                <option value="Male" <?php echo ($_SESSION['Sex']=="Male")? 'selected':'';?> >Male</option>
                <option value="Female" <?php echo ($_SESSION['Sex']=="Female")? 'selected':'';?>>Female</option>
            </select>
            <br>
            <label style="padding-left:2%">Birthday:</label><br>
            <input type="date" 
                   id="birthday" 
                   style="border: .5px solid #666563;border-radius:0; width: 100%; height:35px; margin-bottom:5%;" 
                   value="<?php echo $_SESSION['Birthdate']; ?>" 
                   name="Birthdate" 
                   class="form-control"/>
                
          </div>
        <div class="col-md-6">
            <label style="padding-left:2%">Civil Status:</label><br>
              <select name="CivilStat" style="width: 100%; height:35px; margin-bottom:5%;">
              <option value="<?php echo $_SESSION['CivilStat']?>" style="display: none;" ><?php echo $_SESSION['CivilStat']?></option>
                <option value="Single" <?php echo ($_SESSION['CivilStat']=="Single")? 'selected':'';?> >Single</option>
                <option value="Married" <?php echo ($_SESSION['CivilStat']=="Married")? 'selected':'';?> >Married</option>
                <option value="Widowed" <?php echo ($_SESSION['CivilStat']=="Widowed")? 'selected':'';?> >Widowed</option>
              </select>
            
            <label style="padding-left:2%">Address:</label><br>
            <input type="text" 
                    style="width: 100%; 
                          height:35px; 
                          margin-bottom:5%;" 
                    name = "Address" 
                    value ="<?php echo $_SESSION['Address']; ?>">
            <label style="padding-left:2%">Contact Number:</label>
            <br>

            <input type="tel" 
                    onkeypress="return /[0-9-+]/i.test(event.key)" 
                    maxlength="11"PLACEHOLDER="09-123-456-789" 
                    required 
                    style="width: 100%; height:35px; margin-bottom:5%;" 
                    name = "Phonenum" 
                    value ="<?php echo $_SESSION['Phonenum']; ?>">

        </div>
        </div>
        </div>			
      <br>
        <div class="modal-footer">  
            <button type="reset" 
                    id="reset" 
                    clear() 
                    class="btn btn-info btn-lg" 
                    style="color:white; 
                           border: none; 
                           padding: 4px 7px 4px 7px;
                           margin-right:2%;
                           background:#a35755; 
                           box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30);">Clear
              </button>
          </form>
            <button type="submit"
                    id="submit" 
                    name="update" 
                    class="btn btn-info btn-lg" 
                    style="color:white;
                          margin-right:-2%;
                           border: none; 
                           padding: 4px 7px 4px 7px;
                           background:#349c64; 
                           box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30);"
                    data-dismiss="modal">Update
            </button>
        </div>

    </div>
    </div>
</div>
</div>
</div>
</div>
 
  
        <table class ="table" style="background-color:white;margin:4% 2% 2% 2%; width:96%">
        <tr>
            <td>Full Name: </td>
            <th><?php echo $_SESSION['Firstname']; ?>&emsp;
                <?php echo $_SESSION['Middlename']; ?>&emsp; 
                <?php echo $_SESSION['Lastname']; ?>
            </th>
          </tr>
            <td>Birthday: </td>
            <th> <?php echo date('M d, Y', strtotime($_SESSION['Birthdate']));?></th>
          </tr>
          <tr>
            <td>Age: </td>
            <th> <?php echo $age->format("%y"); ?></th>
          </tr>
          <tr>
          <tr>
            <td>Sex: </td>
            <th> <?php echo $_SESSION['Sex']; ?></th>
          </tr>
          <tr>
          <tr>
            <td>Address: </td>
            <th><?php echo $_SESSION['Address']; ?></th>
          </tr>
          <tr>
            <td>Civil Status: </td>
            <th><?php echo $_SESSION['CivilStat']; ?></th>
          </tr>
          <tr>
            <td>Contact Number: </td>
            <th><?php echo $_SESSION['Phonenum']; ?></th>
          </tr>
          <tr>
            <td>Email: </td>
            <th><?php echo $_SESSION['Email']; ?></th>
          </tr>
          <br>
        
        </table>

</div>

</div>
<!--end of table 1 -->
<br> 

</div>
</div>      
  </div>

    </div>
  </div>
  <script>
  if ( window.history.replaceState ) 
  {
  window.history.replaceState( null, null, window.location.href );
  }

  $(document).ready(function(){ 	
	$("button#submit").click(function(){
		$.ajax({
			type: "POST",
			url: "profile.php",
			data: $('form.feedback').serialize(),
			success: function(message){
				$("#feedback-modal").modal('hide'); 
                 window.location.reload();
			},
			error: function(){
				alert("Error");
			}
		});
  	});	
    });

//    $("#updatesurvey").click(function() {
//       alert("Survey has been submitted.");
//    });

//    $("#updatejob").click(function() {
//       alert("Your Job Information has been Updated.");
//    }); 

   $("#submit").click(function() {
      alert("Your profile has been Updated.");
   });
</script>
 <!-- END OF CONTENT -CLYDE -->

        </div>
      </div>

<!-- / Content -->
						

    <script src="my_chart.js"></script>
    <script src="admin.js"></script>

</script>
</body>
</html>