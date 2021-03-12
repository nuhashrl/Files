<?php
include "./connection/dbconn.php";
if($_POST['val'] == "loadphilosophy"){
    session_start();
    if(isset($_POST['semester']) && $_POST['semester']!=""){
        $semester = $_POST['semester'];
        $userid = $_POST['staffid'];
        $sqlSPhilo = "SELECT a.philosophy FROM portfolio a
        LEFT JOIN semester b ON b.SEMESTER_ID = a.SEMESTER_ID 
        LEFT JOIN systemuser c ON c.idsystemuser = a.systemuser_idsystemuser
        WHERE b.SEMESTER_ID= '".$semester."' AND c.user_user_id = '$userid'";
        $qrySPhilo = mysqli_query($dbconn, $sqlSPhilo) or die(mysqli_error($dbconn));
        $rSPhilo = mysqli_fetch_assoc($qrySPhilo);
        $philo = $rSPhilo['philosophy'];

?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#philo0">VIEW TEACHING PHILOSOPHY</button>
            <div id="philo0" class="collapse form-control col-md-12">
                <div class ="form-control" style="background:whitesmoke;"><?php echo $philo;?></div>
            </div>
        </div>
<?php
    }else{
//if semester == null
?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#philo0">VIEW PHILOSOPHY</button>
            <div id="philo0" class="collapse form-control col-md-12">
                <div class ="form-control" style="background:gray;">NO DATA</div>
            </div>
        </div>
 <?php
    }
 }

?>