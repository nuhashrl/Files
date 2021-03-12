<?php
session_start();
if($_SESSION['usertype'] == 1){
    
    include "./connection/dbconn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
        <title>e-Portfolio: Profile</title>
            
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
    <style>
        #imgSelector{
            display: none;
        }
        #dispImage{
            max-width: 200px;
            min-width: 200px;
            min-height: 200px;
            max-height: 200px;
            border-radius: 50%;
            object-fit: cover;
            
        }
    </style>            
</head>
<body>

<div class="wrapper">

<!--INI IALAH SIDEBAR-->
<?php 
    include "./sidebar.php";
?>
<!--DISINI HABISNYA SIDEBAR-->

<div id="content">

    <!--INI IALAH TOPBAR-->

        <?php
            include "./topbar.php";
        ?>

    <!--TAMAT SUDAH TOPBAR-->

        <br><br><br><br>

    <!--INI IALAH PAGE PUNYA ISI-->
    <div class="container-fluid cc-content" style="background: white; border-radius: 10px">
        <form action="" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal" style="max-width:100%;">
        
        <!-- <img src="" alt="" srcset=""> -->

        <br>
        <?php
            $staffid = $_SESSION['staffid'];
            /**
             * 1 - get user basic data
             * 2 - get current semester
             * 3 - get the status of portfolio of the current semester
             */
            //get basic data
            $sql = "SELECT * FROM jengka.user WHERE USER_ID='".$_SESSION['staffid']."'";
            $qry = mysqli_query($dbconn, $sql);
            $r = mysqli_fetch_assoc($qry) or die("ERROR: ".mysqli_error($dbconn));
            
            //get current status
            $sqlSem = "SELECT * FROM jengka.semester ORDER BY SEMESTER_NAME DESC LIMIT 1";
            $qrySem = mysqli_query($dbconn, $sqlSem) or die("ERROR: ".mysqli_error($dbconn));
            $rSem = mysqli_fetch_assoc($qrySem);

            //get profile data
            $sqlProf = "SELECT * FROM systemuser a
            JOIN jengka.user b ON a.user_user_id=b.user_id
            LEFT JOIN position c ON c.idposition = a.currentpos LEFT JOIN uitmcampus d ON a.id_campus = d.id_campus
            WHERE user_user_id = '$staffid'";
            $qryProf = mysqli_query($dbconn, $sqlProf) or die(mysqli_error($dbconn));
            $rProf = mysqli_fetch_assoc($qryProf);
            $profPic = $rProf['profilepic'];
            if($profPic == null || $profPic == ''){
                $profPic = "./uploads/img-profile/default-image.jpg";
            }

            //status portfolio
        ?>
         
        <div>
            <div class="row justify-content-center align-content-center">
                <div class="deshbot col-md-5 align-content-center">
                    <p class="h4 text-center" style="font-weight:1000;">PROFILE</p>
                </div>
            </div>
            <br>
            <center><img src="<?php echo $profPic?>" alt="" id="dispImage" srcset=""></center>
            <br>
        <table class="table table-bordered table-striped dashboardtable table-hover" id="">
            <tbody>
                <tr >
                    <th>NAME</th> 
                        <td><center><?php echo $r['USER_NAME']; ?></center></td>
                </tr>

                <tr>
                    <th>STAFF ID</th>
                        <td><center><?php echo $r['USER_ID']?></center></td>
                </tr>
                <tr>
                    <th>TELEPHONE NO/PHONE NUMBER</th>
                        <td><center><?php echo $rProf['hpnum']?></center></td>
                </tr>
                <tr>
                    <th>OFFICE PHONE NUMBER</th>
                        <td><center><?php echo $rProf['officephonenum']?></center></td>
                </tr>
                <tr>
                    <th>CURRENT POSITION</th>
                        <td><center><?php echo $rProf['positionname']?></center></td>
                </tr>
                <tr>
                    <th>DATE JOIN</th>
                        <td><center><?php echo $rProf['datejoinuitm']?></center></td>
                </tr>
                <tr>
                    <th>CAMPUS</th>
                        <td><center><?php echo $rProf['name_campus']?></center></td>
                </tr>
                
            </tbody>
        </table>
        <div class="col-md-12 d-flex justify-content-center">
            <button type="button" class="btn btn-info"><a href="edit-profile.php">EDIT PROFILE</a></button>
        </div>
        
        </div>
                  
        <br>                     
        </form>
    </div>
    <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->

</div>

</div>
<?php 
    include "navbar.php";
?>

</body>

</html>
<?php
}
?>