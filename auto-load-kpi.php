<?php 
session_start();
$errors = array();
if(!empty($_POST["request"])){
    include "./connection/dbconn.php";
    $semester = $_POST['yearSession'];
    $userid = $_SESSION['userid'];
    $sqlPort= "SELECT kpi FROM portfolio WHERE semester_SEMESTER_ID = '$semester' AND systemuser_idsystemuser = '$userid'";
    $qryport = mysqli_query($dbconn,$sqlport);
    if(mysqli_num_rows($qryport)>0){
        $res = mysqli_fetch_assoc($qryport);
        $fileId = $res['kpi'];
    }
}else{
    push_array($errors, "ERROR: PERMISSION DENIED");
}

?>