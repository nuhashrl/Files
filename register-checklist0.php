<?php
//error_reporting(0);
session_start();
if(isset($_POST['submit'])){
    //print_r($_POST['subject']);
    var_dump($_POST['subject']);
    $sections0 = $_POST['subject'];
    $sections = array();
    if($_POST['subject']['s'] == 'on'){
        for($i=0;$i<$_POST['Snumber'];$i++){
        array_push($sections, "S");  
        }
    }
    if($_POST['subject']['lp'] == 'on'){
        for($i=0;$i<$_POST['LPnumber'];$i++){
        array_push($sections, "LP");   
        }
    }
    if($_POST['subject']['m'] == 'on'){
        for($i=0;$i<$_POST['Mnumber'];$i++){
        array_push($sections, "M");    
        }
    }
    if($_POST['subject']['st'] == 'on'){
        for($i=0;$i<$_POST['STnumber'];$i++){
            array_push($sections, "ST");
        }    
    }
    if($_POST['subject']['sq'] == 'on'){
        for($i=0;$i<$_POST['SQnumber'];$i++){
            array_push($sections, "SQ");    
        }
    }
    if($_POST['subject']['stuto'] == 'on'){
        for($i = 0;$i<$_POST['STutonumber'];$i++){
            array_push($sections, "STuto");
        }    
    }
    if($_POST['subject']['fq'] == 'on'){
        for($i=0;$i<$_POST['FQnumber'];$i++){
        array_push($sections, "FQ");  
        }
    }
    if($_POST['subject']['sas'] == 'on'){
        for($i=0;$i<$_POST['SASnumber'];$i++){
        array_push($sections, "SAS"); 
        }
    }
    if($_POST['subject']['fer'] == 'on'){
        for($i=0;$i<$_POST['FERnumber'];$i++){
        array_push($sections, "FER");\
        }
    }
    if($_POST['subject']['cdl'] == 'on'){
        for($i=0;$i<$_POST['CDLnumber'];$i++){
        array_push($sections, "CDL");
        }
    }
    if($_POST['subject']['sufo'] == 'on'){
         for($i=0;$i<$_POST['SUFOnumber'];$i++){
        array_push($sections, "SUFO");
         }
    }
    if($_POST['subject']['sla'] == 'on'){
        for($i=0;$i<$_POST['SLAnumber'];$i++){
            array_push($sections, "SLA");   
        } 
    }
    if($_POST['subject']['sa'] == 'on'){
        for($i=0;$i<$_POST['SAnumber'];$i++){
            array_push($sections, "SA");    
        }
    }
    /**
     * kena make sure ade portfolio
     * setiap subject mesti didaftarkan pada 1 portfolio
     * klau portfolio untuk tahun tu x de lagi kene insert
     * klau ade update n dapatkan id portfolio tu
     */
    include "./connection/dbconn.php";
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $currentdate = date('Y-m-d H:i:s',time());
    $errors = array();
    $idPortfolio="";
    $idcourseport = "";
    $idsemester = $_POST['subject']['semses'];
    $userid = $_SESSION['userid'];
    $sqlCPort = "SELECT * FROM portfolio a 
    JOIN systemuser b ON b.idsystemuser = a.systemuser_idsystemuser
    LEFT JOIN semester c ON c.idsemester = a.semester_idsemester
    WHERE b.user_user_id = '".$_SESSION['staffid']."' AND c.idsemester = '$idsemester'";
    $qryCPort = mysqli_query($dbconn, $sqlCPort);
    //buat portfolio baru klau x de portfolio
    if(mysqli_num_rows($qryCPort)==0){
        $sqlInsert = "INSERT INTO portfolio(systemuser_idsystemuser, semester_idsemester,edit_DATETIME) VALUES('$userid', '$idsemester', '$currentdate')";
        if(mysqli_query($dbconn, $sqlInsert)){
            $sqlSearchPort = "SELECT * FROM portfolio a 
            JOIN systemuser b ON b.idsystemuser = a.systemuser_idsystemuser
            LEFT JOIN semester c ON c.idsemester = a.semester_idsemester
            WHERE b.user_user_id = '".$_SESSION['staffid']."' AND c.idsemester = '$idsemester'
            ORDER BY a.idportfolio DESC LIMIT 1";
            $qrySearchPort = mysqli_query($dbconn, $sqlSearchPort);
            $rSearchPort = mysqli_fetch_assoc($qrySearchPort);
            //dapatkan portfolio yang ada
            $idPortfolio = $rSearchPort['idportfolio'];
         }else{
            array_push($errors, mysqli_error($dbconn));
         }
     }else{
         //dapatkan idportfolio yang ada
         $rCPort = mysqli_fetch_assoc($qryCPort);
         $idPortfolio = $rCPort['idportfolio'];
     }
    //echo $idPortfolio;
    //search idcourseport
    if(isset($idPortfolio)){
        $idCourse = $_POST['subject']['courseid'];
        $sqlSCourse = "SELECT * FROM course_port WHERE course_id_course = '$idCourse' AND portfolio_idportfolio='$idPortfolio'";
        //echo $sqlSCourse;
        $qrySCourse = mysqli_query($dbconn, $sqlSCourse);
        if(mysqli_num_rows($qrySCourse)>0){
            $rSCourse = mysqli_fetch_assoc($qrySCourse);
            //dapatkan idcourse_port
            $idcourseport = $rSCourse['idcourse_port'];
         }
         //klau course port x de kene insert
         else if(mysqli_num_rows($qrySCourse)==0){
            $sqlRegCourse = "INSERT INTO course_port(course_id_course, portfolio_idportfolio, edit_DATETIME) VALUES('$idCourse', '$idPortfolio', '$currentdate')";
            if(mysqli_query($dbconn, $sqlRegCourse)){
                //search newly insert course_port
                $sqlSCourse = "SELECT * FROM course_port WHERE course_id_course = '$idCourse' AND portfolio_idportfolio='$idPortfolio' 
                ORDER BY idcourse_port DESC LIMIT 1";
                $qrySCourse = mysqli_query($dbconn, $sqlSCourse);
                $rSCourse = mysqli_fetch_assoc($qrySCourse);
                $idcourseport = $rSCourse['idcourse_port'];
             }
          }
     }else{
         //echo "<script>window.alert('PROBLEM SAVING');window.location.href='./edit-checklist-subject.php'</script>";
     }
    //end searchidcourseport
    
    //insert port_check
    //echo $idcourseport;
    if(isset($idcourseport)){
        //search if there have any value
        //reset all value
        $sqlReset = "UPDATE port_check SET statusportcheck = 0 WHERE courseport_id = '$idcourseport'";
        mysqli_query($dbconn, $sqlReset);
        foreach($sections as $section){
            $sqlSCId = "SELECT * FROM checklist WHERE checklistcode = '".$section."'";
            //echo $sqlSCId;
            $qrySCId = mysqli_query($dbconn,$sqlSCId);
            $rSCId = mysqli_fetch_assoc($qrySCId);
            $idcheck = $rSCId['idchecklist'];
            $sqlSPortC = "SELECT * FROM port_check a LEFT JOIN course_port b ON a.courseport_id=b.idcourse_port 
            WHERE a.courseport_id = '$idcourseport' AND a.checklist_id = '$idcheck' AND b.portfolio_idportfolio='$idPortfolio'";
            //echo $sqlSPortC;
            $qrySPortC = mysqli_query($dbconn, $sqlSPortC);
            //echo mysqli_error($dbconn);
            if(mysqli_num_rows($qrySPortC)>0){
                //echo mysqli_num_rows($qrySPortC)."<br>";
                if($section == "ST" || $section =="SQ" || $section =="STuto"|| $section == "SLA"|| $section == "SA"){
                    if($section == "ST"){
                        //if test has been checked
                        if(mysqli_num_rows($qrySPortC)>=$_POST['STnumber']){ 
                            //echo "HHH";
                            $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                         }
                         else if(mysqli_num_rows($qrySPortC)<$_POST['STnumber']){ 
                             $addRow = $_POST['STnumber'] - mysqli_num_rows($qrySPortC);
                             //echo "HHH";
                             for($i = 0; $i<$addRow;$i++){
                                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                                if(mysqli_query($dbconn, $sqlInPortC)){
                
                                }else{
                                    //echo mysqli_error($dbconn);
                                    array_push($errors, mysqli_error($dbconn));
                                }
                             }
                         }
                     }
                    else if($section == "SQ"){
                        //if there are quiz
                        if(mysqli_num_rows($qrySPortC)>=$_POST['SQnumber']){ 
                            $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' 
                            WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                            if(!mysqli_query($dbconn, $sqlUpdPortC)){
                                array_push($errors, mysqli_error($dbconn));
                            }
                         }
                         else if(mysqli_num_rows($qrySPortC)<$_POST['SQnumber']){ 
                             $addRow = $_POST['SQnumber'] - mysqli_num_rows($qrySPortC);
                             for($i = 0; $i<$addRow;$i++){
                                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                                if(mysqli_query($dbconn, $sqlInPortC)){
                
                                }else{
                                    //echo mysqli_error($dbconn);
                                    array_push($errors, mysqli_error($dbconn));
                                }
                             }
                         }
                     }
                    else if($section == "STuto"){
                        if(mysqli_num_rows($qrySPortC)>=$_POST['STutonumber']){ 
                            $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' 
                            WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                            if(!mysqli_query($dbconn, $sqlUpdPortC)){
                                array_push($errors, mysqli_error($dbconn));
                            }
                        }
                        else if(mysqli_num_rows($qrySPortC)<$_POST['STutonumber']){ 
                            $addRow = $_POST['STutonumber'] - mysqli_num_rows($qrySPortC);
                            for($i = 0; $i<$addRow;$i++){
                                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                                if(mysqli_query($dbconn, $sqlInPortC)){
                
                                }else{
                                    echo mysqli_error($dbconn);
                                    array_push($errors, mysqli_error($dbconn));
                                }
                            }
                         }
                     }
                    else if($section == "SLA"){
                        if(mysqli_num_rows($qrySPortC)>=$_POST['SLAnumber']){ 
                            $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' 
                            WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                            if(!mysqli_query($dbconn, $sqlUpdPortC)){
                                array_push($errors, mysqli_error($dbconn));
                            }
                        }
                         else if(mysqli_num_rows($qrySPortC)<$_POST['SLAnumber']){ 
                             $addRow = $_POST['SLAnumber'] - mysqli_num_rows($qrySPortC);
                             for($i = 0; $i<$addRow;$i++){
                                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                                if(mysqli_query($dbconn, $sqlInPortC)){
                
                                }else{
                                    //echo mysqli_error($dbconn);
                                    array_push($errors, mysqli_error($dbconn));
                                }
                             }
                         }
                     }
                    else if($section == "SA"){
                        if(mysqli_num_rows($qrySPortC)>=$_POST['SAnumber']){ 
                            $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' 
                            WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                            if(!mysqli_query($dbconn, $sqlUpdPortC)){
                                array_push($errors, mysqli_error($dbconn));
                            }
                        }
                         else if(mysqli_num_rows($qrySPortC)<$_POST['SAnumber']){ 
                             $addRow = $_POST['SAnumber'] - mysqli_num_rows($qrySPortC);
                             for($i = 0; $i<$addRow;$i++){
                                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                                if(mysqli_query($dbconn, $sqlInPortC)){
                
                                }else{
                                    //echo mysqli_error($dbconn);
                                    array_push($errors, mysqli_error($dbconn));
                                }
                             }
                         }
                     }
                }else{
                    $sqlUpdPortC = "UPDATE port_check SET statusportcheck = 1, edit_DATETIME='$currentdate' WHERE courseport_id = '$idcourseport' AND checklist_id ='$idcheck'";
                }
                if(mysqli_query($dbconn, $sqlUpdPortC)){

                }else{
                    array_push($errors, mysqli_error($dbconn));
                }
            }else{
                $sqlInPortC = "INSERT INTO port_check(courseport_id, checklist_id, statusportcheck, edit_DATETIME) VALUES('$idcourseport', '$idcheck', 1, '$currentdate')";
                if(mysqli_query($dbconn, $sqlInPortC)){

                }else{
                    //echo mysqli_error($dbconn);
                    array_push($errors, mysqli_error($dbconn));
                }
            }
            /*
            if(mysqli_query($dbconn, $sqlInPortC)){

            }else{
                array_push($errors, mysqli_error($dbconn));
            }*/
        }
        foreach($errors as $error){
            echo "<br><strong>".$error."</strong><br>";
        }
    }
    //end insert portcheck
}else{
    header("location: ./register-subject.php");
}

?>