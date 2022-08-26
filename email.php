<?php
    ob_start();
    session_start();

    require("../ADMIN_2.0/assets/PHPMailer/src/PHPMailer.php");
    require("../ADMIN_2.0/assets/PHPMailer/src/SMTP.php");

    $mailTo = "jarenfe.deloy@cvsu.edu.ph ";//where we send the email
    $body = "<h1>Hello Hi!!</h1>";//the message

    function mailGmail($mailTo,$subject,$body)
    {

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->SMTPDebug = 0;// pero ung sa tutorial 3 nilagay para sa debug
        // set to 0 so that no one can see the log

        $mail->isSMTP();

        $mail->Host = "mail.smtp2go.com";// smtp2go server
        $mail->SMTPAuth = true;
        $mail->Username="cvsualumni-tracker";
        $mail->Password="cvsualumni-tracker";
        $mail->SMTPSecure = "tls";

        $mail->Port="2525";
        $mail->From ="sychopomp123@gmail.com";// lalabas kung sna galing ung email
        $mail->FromName = "cvsualumni-tracker";//senders name
        $mail->addAddress($mailTo, "Hehe");

        $mail->isHTML(true);//lung gusto mo hmtl format
        $mail->Subject = $subject;//subject
        $mail->Body = $body;//the message
        $mail->AltBody = "This is the plain text version of the email content";// incase na d supported ng email ung html content
        if (!$mail->send()) {
            echo "Mailer error : ".$mail->ErrorInfo;
        }else{
            $_SESSION['send'] = true;
            
        }
    }

    if (isset($_POST['submitted'])) {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        mailGmail($email,$subject,$message);

    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Email</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="css/email.css">
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
                    <a onclick="myFunction_1()"><i class="fa fa-graduation-cap" id="icon"></i>Alumni <i class="fa fa-caret-right" aria-hidden="true" id="arrow-1"></i></a>
                    <div class="list-drpdown-1">
                        <a href="alumni_list.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Alumni List</div></a>
                        <a href="alumni_roles.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #FC3134;"></i> Access Role</div></a>
                        <a href="birhtdaylist.php"><div class="items-1"><i class="fa fa-circle-o" aria-hidden="true" style="color: #7BADEE;"></i> Birthday List</div></a>
                     </div>
                    <a href="email.php"><i class="fa fa-envelope" id="icon" style="color:rgb(230, 172, 62);"></i>Email</a>
                    <a href="report.php"><i class="fa fa-exclamation-circle" id="icon"></i>Report</a>
                    <a href="account.php"><i class="fa fa-gear"id="icon"></i>Account Settings</a>
                    <a href="../LOGOUTMODULE/logout.php"><i class="fa fa-sign-out" id="icon"></i>Logout</a>
                </div>
            </div>
        </div>
        <div class="content-box">
            <div class="content">
                <div class="head-page">
                    <h1>Email</h1>
                </div>
                <div class="email-container">
                    <div class="email-content">
                        <form action="" method="POST">
                            <div class="row-1"> <!-- Email -->
                                <div class="email-label">
                                    <label for="">Email</label>
                                </div>
                                <div class="email-input">
                                    <input type="email" name="email" id="" placeholder="Email" required>
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                            </div>
                            <div class="row-1"> <!-- Subject -->
                                <div class="email-label">
                                    <label for="">Subject</label>
                                </div>
                                <div class="email-input">
                                    <input type="text" name="subject" id="" placeholder="Subject" required>
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                            </div>
                            <div class="row-1"> <!-- Concern --> 
                                <div class="email-label">
                                    <label for="">Concern</label>
                                </div>
                                <div class="email-input">
                                    <textarea name="message" id="" cols="30" rows="10" placeholder="Your Concern"></textarea>
                                    <i class="fa fa-comment-o" id="comment"></i>
                                </div>
                            </div>  <!-- End -->
                            <div class="send-button"> <!-- Button -->
                                <button type="reset" style="background-color: #FC3134;">Clear</button>
                                <span></span>
                                <button type="submit" value="Submit" name="submitted">Send</button>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function EmailNotif(){
            alert("Announcement Successfully Created!");
        }
    </script> 
    <script src="admin.js"></script>
</body>
</html>