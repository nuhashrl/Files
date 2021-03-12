<?php
error_reporting(E_ALL);
    if(isset($_POST['submit'])){
        session_start();
        //echo $_SESSION['userid'];
        include "./connection/dbconn.php";
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentdate = date('Y-m-d H:i:s',time());
        $errors = array();
        $goals = mysqli_real_escape_string($dbconn, $_POST['teachgoal']);
        /**
         * make sure portfolio wujud - lepas tu baru update
         */

        //search for semester
        $sqlSemester = "SELECT * FROM semester WHERE SEMESTER_ID = '".$_POST['semses']."'";
        $qrySemester = mysqli_query($dbconn, $sqlSemester);
        $rSemester = mysqli_fetch_assoc($qrySemester);
        $smtSes = $rSemester['SEMESTER_ID'];
        $iduser = $_SESSION['userid'];
        if(isset($smtSes)){
            //search for portfolio
            $sqlPort = "SELECT * FROM portfolio WHERE SEMESTER_ID = '$smtSes' AND systemuser_idsystemuser = '".$_SESSION['userid']."'";
            $qryPort = mysqli_query($dbconn, $sqlPort);
            if(mysqli_num_rows($qryPort) > 0){
                $rPort = mysqli_fetch_assoc($qryPort);
                $idPort = $rPort['idportfolio'];
                $sqlUpdate = "UPDATE portfolio SET teachgoal = '$goals' WHERE idportfolio = '$idPort'";
                if(mysqli_query($dbconn, $sqlUpdate)){
                    
                }else{
                    array_push($errors, mysqli_error($dbconn));
                }
            }//end if num_rows -> move on to if there are no data
            else{
                $sqlInsert = "INSERT INTO portfolio(edit_DATETIME, SEMESTER_ID, systemuser_idsystemuser, teachgoal) 
                VALUES('$currentdate', '$smtSes', '$iduser', '$goals')"; 
                if(mysqli_query($dbconn, $sqlInsert)){

                }else{
                    array_push($errors, mysqli_error($dbconn));
                }
            }
        }else{
            array_push($errors, "NO DATA AVAILABLE");
        }
        if(sizeof($errors) > 0){
            $errors = addslashes(json_encode($errors));
            echo "<script>window.alert('ERRORS: ".$errors."');window.location.href='./edit-goals.php';</script>";
        }else{
            echo "<script>window.alert('SUCCESFULLY UPDATED');window.location.href='./edit-goals.php'</script>";
        }
        //echo $philo;
    }//end if isset(submit)
    else{
        header("location: ./edit-goals.php");
    }
?>