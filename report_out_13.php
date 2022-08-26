<?php
  $serverdpphp =  $_SERVER['DOCUMENT_ROOT'].'/Tracer/DATABASEPHP/database.php'; 
  require($serverdpphp);
  session_start();

    
if(isset($_SESSION['login_info'])&& $_SESSION['login_info']['AccessToken']=="ADMIN")
{
//GRADUATES
          $sqlgrad ="SELECT Batchyear,
         (SELECT COUNT(Course)  WHERE Course = 'BSIT') as BSIT,
         (SELECT COUNT(Course)  WHERE Course = 'BSCS')as BSCS,
         (SELECT COUNT(Course)  WHERE Course = 'BEED') as BEED,
         (SELECT COUNT(Course)  WHERE Course = 'BSBM')as BSBM,
         (SELECT COUNT(Course)  WHERE Course = 'BSHRM')as BSHRM,
         (SELECT COUNT(Course)  WHERE Course = 'BSOA')as BSOA,
         (SELECT COUNT(Course)  WHERE Course = 'BSE')as BSE,
         (SELECT COUNT(Course)  WHERE Course = 'AB Journalism')as 'AB Journalism',
         (SELECT COUNT(Course)  WHERE Course = 'BS Psychology')as 'BS Psychology',
         (SELECT COUNT(Course)  WHERE Course = 'BS Entrep')as 'BS Entrep'
        FROM alumniinfo group by  Course, Batchyear order by Batchyear";
         $resultgrad = mysqli_query($con,$sqlgrad);  

        foreach ($resultgrad as $rowgrad) 
        {
            $byear[]=$rowgrad['Batchyear'];
            $bsit[]=$rowgrad['BSIT'];
            $bscs[]=$rowgrad['BSCS'];
            $beed[]=$rowgrad['BEED'];
            $bsbm[]=$rowgrad['BSBM'];
            $bshrm[]=$rowgrad['BSHRM'];
            $bsoa[]=$rowgrad['BSOA'];
            $bse[]=$rowgrad['BSE'];
            $abj[]=$rowgrad['AB Journalism'];
            $bsp[]=$rowgrad['BS Psychology'];
            $bsentrep[]=$rowgrad['BS Entrep'];

        }
//REGISTERED ALUMNI
    $regsql="SELECT COUNT(Email) as numberofpersons, year(regdate) as year FROM alumniinfo GROUP BY year(regdate)";
    $resultreg = $con->query($regsql);
    $regisnum = array();
    $year = array();
    foreach ($resultreg as $rowreg) {
    $regisnum[] = $rowreg['numberofpersons'];
    $year[] = $rowreg['year'];
    }
//SURVEY

//Q1
$q1sql="SELECT Q1, COUNT(Q1) as numq1 FROM survey GROUP BY Q1";
$resultq1 = $con->query($q1sql);
$q1 = array();
$q1count = array();
foreach ($resultq1 as $rowq1) {
$q1[] = $rowq1['Q1'];
$q1count[] = $rowq1['numq1'];
}
//Q2
$q2sql="SELECT Q2, COUNT(Q2) as numq2 FROM survey GROUP BY Q2";
$resultq2 = $con->query($q2sql);
$q2 = array();
$q2count = array();
foreach ($resultq2 as $rowq2) {
$q2[] = $rowq2['Q2'];
$q2count[] = $rowq2['numq2'];
}
//Q3
$q3sql="SELECT Q3, COUNT(Q3) as numq3 FROM survey GROUP BY Q3";
$resultq3 = $con->query($q3sql);
$q3 = array();
$q3count = array();
foreach ($resultq3 as $rowq3) {
$q3[] = $rowq3['Q3'];
$q3count[] = $rowq3['numq3'];
}
//Employment Status
$sqlemp ="SELECT year(DateHired),
(SELECT COUNT(Course)  WHERE Course = 'BSIT' AND EmpStat = 'Employed') as eBSIT,
(SELECT COUNT(Course)  WHERE Course = 'BSCS'AND EmpStat = 'Employed')as eBSCS,
(SELECT COUNT(Course)  WHERE Course = 'BEED'AND EmpStat = 'Employed') as eBEED,
(SELECT COUNT(Course)  WHERE Course = 'BSBM'AND EmpStat = 'Employed')as eBSBM,
(SELECT COUNT(Course)  WHERE Course = 'BSHRM'AND EmpStat = 'Employed')as eBSHRM,
(SELECT COUNT(Course)  WHERE Course = 'BSOA'AND EmpStat = 'Employed')as eBSOA,
(SELECT COUNT(Course)  WHERE Course = 'BSE'AND EmpStat = 'Employed')as eBSE,
(SELECT COUNT(Course)  WHERE Course = 'AB Journalism'AND EmpStat = 'Employed')as 'eAB Journalism',
(SELECT COUNT(Course)  WHERE Course = 'BS Psychology'AND EmpStat = 'Employed')as 'eBS Psychology',
(SELECT COUNT(Course)  WHERE Course = 'BS Entrep'AND EmpStat = 'Employed')as 'eBS Entrep'
FROM jobinfo group by  year(DateHired), Course, EmpStat order by year(DateHired)";
$sqltemp ="SELECT year(DateHired),
(SELECT COUNT(year(DateHired))  WHERE   EmpStat = 'Employed') as TotalEmp
FROM jobinfo group by  year(DateHired) order by year(DateHired)";


$resulemp = mysqli_query($con,$sqlemp);  
foreach ($resulemp as $rowemp) 
{
    $datehired[]=$rowemp['year(DateHired)'];
    $ebsit[]=$rowemp['eBSIT'];
    $ebscs[]=$rowemp['eBSCS'];
    $ebeed[]=$rowemp['eBEED'];
    $ebsbm[]=$rowemp['eBSBM'];
    $ebshrm[]=$rowemp['eBSHRM'];
    $ebsoa[]=$rowemp['eBSOA'];
    $ebse[]=$rowemp['eBSE'];
    $eabj[]=$rowemp['eAB Journalism'];
    $ebsp[]=$rowemp['eBS Psychology'];
    $ebsentrep[]=$rowemp['eBS Entrep'];
}

$resultemp = mysqli_query($con,$sqltemp);  
foreach ($resultemp as $rowtemp) 
{
    $totalemp[]=$rowtemp;
}

//echo json_encode( $ebsit);
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
    <title>Admin | Dashboard</title>
    <link rel="icon" href="img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboard.css">
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
                    <h1>Report</h1>
                </div>

                     <!-- chart -->
                    
                    <div style="margin: 5% 10% 0 10%;width:80%;height:100%;text-align:center; display:flexbox; border:2px solid green; box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30); border-radius:1.5%">
                    <a href="dl-cvsugrad.php" style="float:right; margin-right:1%; color:green; font-size:17px; text-decoration:none">Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    <h2 class="page-header" style="font-size:2vw; color: grey; margin-top:2%; margin-left: 5%;" >CVSU-IMUS GRADUATES</h2>
                    <canvas  id="canvasgrad"></canvas>  
                   </div> 
                    <div class="graphbox"style="margin: 5% 10% 0 10%; width:80%;height:100%; text-align:center; display:flexbox; border:2px solid green; box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30);border-radius:1.5%">
                    <a href="dl-regchart.php" style="float:right; margin-right:1%; color:green; font-size:17px; text-decoration:none">Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    <h2 style="font-size:2vw; color: grey; margin-top:2%; margin-left: 5%;">Yearly Registration Status</h2>
                        <canvas id="regisChart"></canvas>
                    </div>
                    <div class="graphbox"style="margin: 5% 10% 0 10%; width:80%;height:100%; text-align:center; display:flexbox; border:2px solid green; box-shadow: 1px 1px 1px 1px rgb(0,0,0,.30);border-radius:1.5%">
                    <a href="dl-empstatus.php" style="float:right; margin-right:1%; color:green; font-size:17px; text-decoration:none">Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    <h2 style="font-size:2vw; color: grey; margin-top:2%; margin-left: 5%;">Employment Status</h2>
                        <canvas id="empcanvas"></canvas>
                        <div style="color:grey; font-size:small">
                        <br>Total: 
                        <?php 
                        $resultemp2 = mysqli_query($con,$sqltemp); 
                        if (mysqli_num_rows($resultemp2) > 0) {
                        // output data of each row
                        while($row3 = mysqli_fetch_assoc($resultemp2)) {
                            echo  '&nbsp;'.$row3['year(DateHired)'] .' = ' .'<b>'. $row3['TotalEmp']. '</b>'.'&nbsp;|&nbsp;';
                        }
                        } 
                        ?>      
                </div><br>
             </div>
             </div>
             <div class="container-fluid">
              <div class="graphbox"style="margin: 5% 10% 0 10%; width:80%;height:100%; text-align:center; border:2px solid grey; border-radius:1.5%">
                    <a href="dl-survey.php" style="float:right; margin-right:1%; color:green; font-size:17px; text-decoration:none">Export <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    <h2 style="font-size:20px; color: grey; margin-top:2%; margin-left: 5%;">Survey</h2><br>
                    
                    <div class="row">
                        <div class="col-xs-4 col-md-4 col-lg-4"><p style="font-size:100%; color: grey; margin: 2% 1% .8% 1%">Q1: Employment Sector</p>
                        <canvas id="q1Chart"></canvas></div><br>
                        <div class="col-xs-4 col-md-4 col-lg-4"><p style="font-size:100%; color: grey;  margin: 2% 1% 1% 1%">Q2: The skills acquired in job relevant to the following current labour demands </p>
                        <canvas id="q2Chart"></canvas> </div><br>
                        <div class="col-xs-4 col-md-4 col-lg-4"> <p style="font-size:100%; color: grey;  margin: 2% 1% 1% 1%">Q3: Job alligned to the following curriculum offered in CVSU-Imus</p>
                        <canvas id="q3Chart"></canvas></div>
                    </div>
                    </div>
                    
                           
                       
                  
        <br><br>
                    						
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.0.0/chartjs-plugin-zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-adapter-moment/1.0.0/chartjs-adapter-moment.min.js"></script>
    <script src="my_chart.js"></script>
    <script src="admin.js"></script>

    <script>

// graduate chart script
  var byear = <?php echo json_encode($byear)?>;
  var bsit = <?php echo json_encode($bsit)?>;
  var bscs = <?php echo json_encode($bscs)?>;
  var beed= <?php echo json_encode($beed)?>;
  var bsbm= <?php echo json_encode($bsbm)?>;
  var bshrm= <?php echo json_encode($bshrm)?>;
  var bsoa= <?php echo json_encode($bsoa)?>;
  var bse= <?php echo json_encode($bse)?>;
  var abj= <?php echo json_encode($abj)?>;
  var bsp= <?php echo json_encode($bsp)?>;
  var bsentrep= <?php echo json_encode($bsentrep)?>;
          
    const config = {
            type: 'bar',
            data: {
                labels: byear,
                datasets: [{
                    label: 'BSIT',
                    data: bsit,
                    backgroundColor: 'rgb(30,81,40, .2)', 
                    borderColor: 'rgb(30,81,40, .5)',
                    borderWidth: 2  
                }, {
                    label: 'BSCS',
                    data: bscs,
                    backgroundColor: 'rgb(78,159,61, 0.2)', 
                    borderColor: 'rgb(78,159,61, .6)',
                    borderWidth: 2  
                }, {
                    label: 'BEED',
                    data: beed,
                    backgroundColor: 'rgb(216,233,168, 0.2)',   
                    borderColor: 'rgb(216,233,168, 1)',
                    borderWidth: 2       
                },
                {
                    label: 'BSBM',
                    data: bsbm,
                    backgroundColor: 'rgb(181,221,208, 0.2)', 
                    borderColor: 'rgb(181,221,208, 1)',
                    borderWidth: 2 
                },
                {
                    label: 'BSHRM',
                    data: bshrm,
                    backgroundColor: 'rgb(153,197,204, 0.2)', 
                    borderColor: 'rgb(153,197,204, 1)',
                    borderWidth: 2
                },
                {
                    label: 'BSOA',
                    data: bsoa,
                    backgroundColor: 'rgb(191, 203, 168,0.2)', 
                    borderColor: 'rgb(191, 203, 168, 1)',
                    borderWidth: 2
                },
                {
                    label: 'BSE',
                    data: bse,
                    backgroundColor: 'rgb(91, 138, 114,0.2)', 
                    borderColor: 'rgb(91, 138, 114,0.5)',
                    borderWidth: 2
                },
                {
                    label: 'AB Journalism',
                    data: abj,
                    backgroundColor: 'rgb(86, 119, 108,0.2)', 
                    borderColor: 'rgb(86, 119, 108,0.5)',
                    borderWidth: 2
                },
                {
                    label: 'BS Entrep',
                    data: bsentrep,
                    backgroundColor: 'rgb(70, 79, 65,0.2)', 
                    borderColor: 'rgb(70, 79, 65,0.5)',
                    borderWidth: 2
                },
              ]
            },
            options: {
              plugins: {
  legend: {
    display: true,
    position: 'right'
  }
},
scales: {
  x: {
    type: 'linear',
    position: 'bottom',
    ticks: {
        precision: 0,
        beginAtZero: true,
        callback: function(value, index, values) {
            if (parseInt(value) >= 1000) {
            return '' + value.toString().replace(/,/g, "");
            } else {
            return '' + value;
            }}
            }
  },
  y: {
     ticks: {
        precision: 0,
        }
  }
}
}
        };



// regitered chart script
    const data = {
        labels: <?php echo json_encode($year)?>,
        datasets: [{
        label: 'Yearly Registration Status',
        data:<?php echo json_encode($regisnum)?>,
        backgroundColor: [
            'rgba(3, 128, 2, .5)'
        ],
        borderColor: [
            'rgba(3, 128, 2, .8)'
        ],
        borderWidth:3
        }]
    };

    const con = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        
    },
    };

    var regischart = new Chart(
        document.getElementById('regisChart'),
        con
    ); 

  // Q1 CHART
  const dataq1 = {
        labels: <?php echo json_encode($q1)?>,
        datasets: [{
        label: 'Q1',
        data:<?php echo json_encode($q1count)?>,
        backgroundColor: [
            'rgb(14, 24, 95)',
            'rgb(47, 164, 255)',
            'rgb(0, 255, 221)',
            'rgb(232, 255, 194)',
            'rgb(169, 16, 121)',
            'rgb(118, 186, 153)',
            'rgb(173, 207, 159)',
            'rgb(206, 216, 158)',
            'rgb(255, 220, 174)'
        ],
        borderColor: 'rgb(125, 157, 156,.7)',
        borderWidth: 3
        }]
    };

    const conq1 = {
    type: 'doughnut',
    data: dataq1,
    options: {
        responsive: true,
        plugins:{
            legend: {
            display: true,
            position: 'bottom'
  },
        }
        
    },
    };

    var q1chart = new Chart(
        document.getElementById('q1Chart'),
        conq1
    ); 


//Q2 CHART
const dataq2 = {
        labels: <?php echo json_encode($q2)?>,
        datasets: [{
        label: 'Q2',
        data:<?php echo json_encode($q2count)?>,
        backgroundColor: [
            'rgb(130, 100, 0)',
            'rgb(26, 150, 46)',
            'rgb(0, 100, 0)',
            'rgb(230, 159, 41)',
            'rgb(6, 40, 61)',
            'rgb(19, 99, 223)',
            'rgb(71, 181, 255)',
            'rgb(223, 246, 255)'
        ],borderColor: 'rgb(125, 157, 156,.7)',
        borderWidth: 3
        }]
    };

    const conq2 = {
    type: 'doughnut',
    data: dataq2,
    options: {
        responsive: true,
        plugins:{
            legend: {
            display: true,
            position: 'bottom'
  },
        }
        
    },
    };

    var q2chart = new Chart(
        document.getElementById('q2Chart'),
        conq2
    ); 


    //Q2 CHART
const dataq3 = {
        labels: <?php echo json_encode($q3)?>,
        datasets: [{
        label: 'Q3',
        data:<?php echo json_encode($q3count)?>,
        backgroundColor: [
            'rgb(33, 33, 33)',
            'rgb(109, 152, 134)',
            'rgb(217, 202, 179)',
            'rgb(246, 246, 246)',
            'rgb(49, 107, 131)',
            'rgb(109, 130, 153)',
            'rgb(140, 161, 165)',
            'rgb(213, 191, 191)'
        ],
        borderColor: 'rgb(125, 157, 156,.7)',
        borderWidth: 3
        }]
    };

    const conq3 = {
    type: 'doughnut',
    data: dataq3,
    options: {
        responsive: true,
        plugins:{
            legend: {
            display: true,
            position: 'bottom'
  },
        }
        
    },
    };

    var q3chart = new Chart(
        document.getElementById('q3Chart'),
        conq3
    ); 
  
    //Employment Status chart script
  var datehired= <?php echo json_encode($datehired)?>;
  var ebsit = <?php echo json_encode($ebsit)?>;
  var ebscs = <?php echo json_encode($ebscs)?>;
  var ebeed= <?php echo json_encode($ebeed)?>;
  var ebsbm= <?php echo json_encode($ebsbm)?>;
  var ebshrm= <?php echo json_encode($ebshrm)?>;
  var ebsoa= <?php echo json_encode($ebsoa)?>;
  var ebse= <?php echo json_encode($ebse)?>;
  var eabj= <?php echo json_encode($eabj)?>;
  var ebsp= <?php echo json_encode($ebsp)?>;
  var ebsentrep= <?php echo json_encode($ebsentrep)?>;
  var totalemp= <?php echo json_encode($totalemp)?>;
  
          
    const empconfig = {
            type: 'bar',
            data: {
                labels: datehired,
                datasets: [{
                    label: 'BSIT',
                    data: ebsit,
                    backgroundColor: 'rgb(30,81,40, .8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2  
                }, {
                    label: 'BSCS',
                    data: ebscs,
                    backgroundColor: 'rgb(78,159,61, 0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2  
                }, {
                    label: 'BEED',
                    data: ebeed,
                    backgroundColor: 'rgb(216,233,168, 0.8)',   
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2       
                },
                {
                    label: 'BSBM',
                    data: ebsbm,
                    backgroundColor: 'rgb(181,221,208, 0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2 
                },
                {
                    label: 'BSHRM',
                    data: ebshrm,
                    backgroundColor: 'rgb(153,197,204, 0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2
                },
                {
                    label: 'BSOA',
                    data: ebsoa,
                    backgroundColor: 'rgb(191, 203, 168,0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2
                },
                {
                    label: 'BSE',
                    data: ebse,
                    backgroundColor: 'rgb(91, 138, 114,0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2
                },
                {
                    label: 'AB Journalism',
                    data: eabj,
                    backgroundColor: 'rgb(86, 119, 108,0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2
                },
                {
                    label: 'BS Entrep',
                    data: ebsentrep,
                    backgroundColor: 'rgb(70, 79, 65,0.8)', 
                    borderColor: 'rgb(0,128,0,.7)',
                    borderWidth: 2
                },

              ]
            },
            options: {
              plugins: {
  legend: {
    display: true,
    position: 'right'
  }
},
scales: {
  x: {
    type: 'linear',
    position: 'bottom',
    ticks: {
        precision: 0,
        beginAtZero: true,
        callback: function(value, index, values) {
            if (parseInt(value) >= 1000) {
            return '' + value.toString().replace(/,/g, "");
            } else {
            return '' + value;
            }}
            }
  },
  y: {
     ticks: {
        precision: 0,
        }
  }
}
}
        };

    window.onload = function() {
        //load grad chart
        const ctx = document.getElementById('canvasgrad').getContext('2d');
        let chartgrad  = new Chart(ctx, config);
        //load emp chart
        const empctx = document.getElementById('empcanvas').getContext('2d');
        let empchart  = new Chart(empctx, empconfig);
    };

</script>
</body>
</html>