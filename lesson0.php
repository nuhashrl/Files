<?php
session_start();
$errors = array();
if(!empty($_SESSION['usertype'])){
    if(!empty($_FILES['lesson'])){
        include "./connection/dbconn.php";
        $sqlSemester = "SELECT * FROM semester WHERE SEMESTER_ID = '".$_POST['semses']."'";
        
        $qrySemester = mysqli_query($dbconn, $sqlSemester);
        $rSemester = mysqli_fetch_assoc($qrySemester);

        $smtSes = $rSemester['SEMESTER_ID'];
        $iduser = $_SESSION['userid'];
        $idportfolio="";
        //search portfolio id
        $sqlPortfolio = "SELECT idportfolio FROM portfolio a JOIN semester b ON a.SEMESTER_ID=b.SEMESTER_ID JOIN systemuser c ON c.idsystemuser= a.idportfolio WHERE a.SEMESTER_ID  = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
       // echo $sqlPortfolio;
        $qryPortfolio = mysqli_query($dbconn, $sqlPortfolio);
        $test = true;
        if(mysqli_num_rows($qryPortfolio)>0){
            #dapatkan data
            $res = mysqli_fetch_assoc($qryPortfolio);
            $idportfolio = $res['idportfolio'];
            echo $idportfolio;
        }else{
            #kalau portfolio x wujud lagi
            #kene buat satu portfolio baru
            $sqlInsertPort = "INSERT INTO portfolio(system_idsystemuser, SEMESTER_ID)
            VALUES($iduser, $smtSes)";
            if(!mysqli_query($dbconn, $sqlInsertPort)){
                array_push($errors, mysqli_error($dbconn));
            }
            $sqlPortfolio = "SELECT idportfolio FROM portfolio WHERE SEMESTER_ID = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
            $qryPortfolio = mysqli_query($dbconn, $sqlPortfolio);
            
            if(mysqli_num_rows($qryPortfolio)>0){
                #dapatkan data
                $res = mysqli_fetch_assoc($qryPortfolio);
                $idportfolio = $res['idportfolio'];
                
            }else{
                array_push($errors,"ERROR: NO DATA");
            }
        }
        $fileName = $_FILES['lesson']['name'];
        $fileTmpName = $_FILES['lesson']['tmp_name'];
        $fileSize = $_FILES['lesson']['size'];
        $fileError = $_FILES['lesson']['error'];
        $fileType = $_FILES['lesson']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf','jpg','jpeg','png','svg');

        // checking allowed list & fileExt
        if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            
            if($fileSize < 5000000){
               //add sql to insert in db
                $sqlCheck = "SELECT idportfolio FROM portfolio WHERE SEMESTER_ID = '".$_POST['semses']."' AND systemuser_idsystemuser = '".$_SESSION['userid']."'";
                //echo $sqlCheck;
                $qryCheck = mysqli_query($dbconn, $sqlCheck);
                $rCheck = mysqli_fetch_assoc($qryCheck);
                $idportfolio = $rCheck['idportfolio'];
                
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/lessonplan/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sqlUpdateTimetable = "UPDATE portfolio SET lessonplan = '$fileDestination' WHERE idportfolio = '$idportfolio'";
                //echo $sqlUpdateKPI;
               
                $LastId =  mysqli_insert_id($dbconn);
                echo $LastId;
                $query0 = mysqli_query($dbconn,$sqlUpdateTimetable) or die ("Error : " .mysqli_error($dbconn)) ;
                
                header("Location: lesson.php?uploadsuccess");
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