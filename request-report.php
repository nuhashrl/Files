<?php
session_start();
$errors = array();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
        <title>e-Portfolio: Report</title>
            
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
    <?php include "./connection/dbconn.php";?>
                
</head>
<?php
    $key = "Q+l9cxo]'rnTD\"O#(kq96tEA/u$^BK";

?>

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
            include "./topbar.php"
        ?>
        <!--TAMAT SUDAH TOPBAR-->
            <br><br><br><br>
        <!--INI IALAH PAGE PUNYA ISI-->
        <form action="./generate-report.php" method="get"  enctype="multipart/form-data">
        <div class="row">
            <!--mulakan content untuk pilih session dan edit subjects-->
            <div class="form-group col-md-12">
            <?php 
                $sqlSession = "SELECT * FROM semester a 
                JOIN portfolio b ON b.SEMESTER_ID = a.SEMESTER_ID
                WHERE b.systemuser_idsystemuser = '".$_SESSION['userid']."'
                ORDER BY SEMESTER_NAME DESC";
                $qrySession = mysqli_query($dbconn, $sqlSession) or array_push($errors, mysqli_error($dbconn));
            ?>
                <label for="" class="col-md-2">YEAR/SESSION&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                <select name="semses" id="session"  onchange="" class="col-md-9 wkwkw" required>
                    <option value="">SELECT</option>
                    <?php
                        while($rSession = mysqli_fetch_assoc($qrySession)){
                            $temp = md5($rSession['SEMESTER_ID']);
                            $value = password_hash($temp, PASSWORD_DEFAULT);
                            echo "<option value='".$value."' id='sesId'>".$rSession['SEMESTER_NAME']."</option>";
                        }
                     ?>
                </select>
             </div>
             <?php 
                //echo $value;
                //echo crypt($temp, $key);
             ?>
            <!--habis pilih session-->
            <div class="form-group col-md-12">
                <button type="button" name ="submit" value="submit" class="btn btn-success col-md-12" onclick="redPage();">GENERATE REPORT</button>
             </div>
        </div>
        <script>
            function redPage(){
                var val= document.getElementById('session').value;
                if(val != ""){
                    window.location.href = './report.php?value='+val+'';
                }
            }
        </script>
        </form>
    </div>
</div>
<div class="overlay"></div>
<?php include "./navbar.php"; ?>
</body>
<script>

</script>
<?php
//}
?>