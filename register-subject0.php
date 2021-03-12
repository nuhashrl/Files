<?php
session_start();
$errors = array();
if(!empty($_SESSION['usertype'])){
    if(!empty($_FILES['subject'])){
        include "./connection/dbconn.php";
        $sqlSemester = "SELECT * FROM semester WHERE SEMESTER_ID = '".$_POST['semses']."'";
        
        $qrySemester = mysqli_query($dbconn, $sqlSemester);
        $rSemester = mysqli_fetch_assoc($qrySemester);

        $smtSes = $rSemester['SEMESTER_ID'];
        $iduser = $_SESSION['userid'];
        $idportfolio="";
        //search portfolio id
        $sqlSub = "SELECT idsubject FROM subject a JOIN semester b ON a.SEMESTER_ID=b.SEMESTER_ID JOIN systemuser c ON c.idsystemuser= a.idsubject WHERE a.SEMESTER_ID  = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
       // echo $sqlPortfolio;
        $qrySub = mysqli_query($dbconn, $sqlSub);
        $test = true;
        if(mysqli_num_rows($qrySub)>0){
            #dapatkan data
            $res = mysqli_fetch_assoc($qrySub);
            $idsubject = $res['idsubject'];
            echo idsubject;
        }else{
            #kalau portfolio x wujud lagi
            #kene buat satu portfolio baru
            $sqlInsertSub = "INSERT INTO subject(system_idsystemuser, SEMESTER_ID)
            VALUES($iduser, $smtSes)";
            if(!mysqli_query($dbconn, $sqlInsertSub)){
                array_push($errors, mysqli_error($dbconn));
            }
            $sqlSub = "SELECT idsubject FROM subject WHERE SEMESTER_ID = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
            $qrySub = mysqli_query($dbconn, $sqlSub);
            
            if(mysqli_num_rows($qrySub)>0){
                #dapatkan data
                $res = mysqli_fetch_assoc($qrySub);
                $idsubject = $res['idsubject'];
                
            }else{
                array_push($errors,"ERROR: NO DATA");
            }
        }
        $fileName = $_FILES['subject']['name'];
        $fileTmpName = $_FILES['subject']['tmp_name'];
        $fileSize = $_FILES['subject']['size'];
        $fileError = $_FILES['subject']['error'];
        $fileType = $_FILES['subject']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf');

        // checking allowed list & fileExt
        if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            
            if($fileSize < 100000){
               //add sql to insert in db
                $sqlCheck = "SELECT idsubject FROM subject WHERE SEMESTER_ID = '".$_POST['semses']."' AND systemuser_idsystemuser = '".$_SESSION['userid']."'";
                //echo $sqlCheck;
                $qryCheck = mysqli_query($dbconn, $sqlCheck);
                $rCheck = mysqli_fetch_assoc($qryCheck);
                $idportfolio = $rCheck['idportfolio'];
                
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/content/syllabus'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sqlUpdateSyllabus = "UPDATE subject SET syllabus = '$fileDestination' WHERE idsubject = '$idsubject'";
                //echo $sqlUpdateKPI;
               
                $LastId =  mysqli_insert_id($dbconn);
                echo $LastId;
                $query0 = mysqli_query($dbconn,$sqlUpdateKPI) or die ("Error : " .mysqli_error($dbconn)) ;
                
                header("Location: register-subject.php?uploadsuccess");
            }else{
                echo "File exceeded size allowed";
            }
        }else{
            echo "Error uploading file";
        }
        }else{
            echo "File of this type cannot be uploaded";
            }
}
}
?>