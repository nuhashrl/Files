<?php
include "./connection/dbconn.php";
if($_POST['val'] == "loadphilosophy"){
    session_start();
    if(isset($_POST['semester']) && $_POST['semester']!=""){
        $semester = $_POST['semester'];
        $userid = $_POST['staffid'];
        $sqlTimetable = "SELECT a.tutorial FROM portfolio a JOIN semester b ON b.SEMESTER_ID = a.SEMESTER_ID  JOIN systemuser c ON c.idsystemuser = a.systemuser_idsystemuser WHERE b.SEMESTER_ID '".$semester."' AND c.user_user_id = '$userid'";
        $qryTimetable = mysqli_query($dbconn, $sqlTimetable) or die(mysqli_error($dbconn));
        $rTimetable = mysqli_fetch_assoc($qryTimetable);
        $timetable= $rTimetable['tutorial'];

?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#tutorial0">VIEW TUTORIAL</button>
            <div id="tutorial0" class="collapse form-control col-md-12">
                <div class ="form-control" style="background:whitesmoke;"><?php echo $timetable;?></div>
            </div>
        </div>
<?php
    }else{
//if semester == null
?>
        <div class="form-group col-md-12">
            <button type="button" class="btn btn-primary col-md-2" data-toggle="collapse" data-target="#tutorial0">VIEW TUTORIAL</button>
            <div id="tutorial0" class="collapse form-control col-md-12">
                <div class ="form-control" style="background:gray;">NO DATA</div>
            </div>
        </div>
 <?php
    }
 }

?>