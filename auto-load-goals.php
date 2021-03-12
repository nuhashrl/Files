<?php
include "./connection/dbconn.php";
if($_POST['val'] == "load-goal"){
    session_start();
    if(isset($_POST['semester']) && $_POST['semester']!=""){
        $semester = $_POST['semester'];
        $userid = $_POST['staffid'];
        $sqlSGoal = "SELECT a.teachgoal FROM portfolio a
        LEFT JOIN semester b ON b.SEMESTER_ID = a.SEMESTER_ID 
        LEFT JOIN systemuser c ON c.idsystemuser = a.systemuser_idsystemuser
        WHERE b.SEMESTER_ID= '".$semester."' AND c.user_user_id = '$userid'";
        $qrySGoal = mysqli_query($dbconn, $sqlSGoal) or die(mysqli_error($dbconn));
        $rSGoal = mysqli_fetch_assoc($qrySGoal);
        $goal = $rSGoal['teachgoal'];

?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#goal0">VIEW TEACHING GOAL</button>
            <div id="goal0" class="collapse form-control col-md-12" style="margin-top: 15px;">
                <div class ="form-control" style="background:whitesmoke;"><?php echo $goal;?></div>
            </div>
        </div>
<?php
    }else{
//if semester == null
?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#goal0">VIEW GOAL</button>
            <div id="goal0" class="collapse form-control col-md-12">
                <div class ="form-control" style="background:gray;">NO DATA</div>
            </div>
        </div>
 <?php
    }
 }

?>