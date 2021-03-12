<?php
session_start();
$errors = array();
include "./connection/dbconn.php";
//if($_SESSION['usertype'] == ??){
    if(isset($_GET['value'])){
        
            //search portfolio
                $encsession = $_GET['value'];
                $sqlSession = "SELECT * FROM semester";
                // echo $sqlSession;
                $qrySession = mysqli_query($dbconn, $sqlSession);
                while($rSession = mysqli_fetch_assoc($qrySession)){
                    if(password_verify(md5($rSession['SEMESTER_ID']),$encsession)){
                        $idsession = $rSession['SEMESTER_ID'];
                        break;
                    }
                }
                $iduser = $_SESSION['userid'];
                $sqlS = "SELECT * FROM semester a JOIN portfolio b 
                ON b.SEMESTER_ID = a.SEMESTER_ID
                WHERE SEMESTER_ID = '$idsession' AND b.systemuser_idsystemuser = '$iduser'";
                $qryS = mysqli_query($dbconn, $sqlS) or array_push($errors, mysqli_error($dbconn));
                $rS = mysqli_fetch_assoc($qryS);
            //end search portfolio
            //search for systemuser detail
                $sqlUser = "SELECT * FROM systemuser a
                LEFT JOIN position b ON b.idposition=a.currentpos
                WHERE idsystemuser = '".$_SESSION['userid']."'";
                $qryUser = mysqli_query($dbconn, $sqlUser);
                $rUser = mysqli_fetch_assoc($qryUser);
            //end search systemuser
            //search username
                $sqlSName = "SELECT USER_NAME,USER_ID FROM jengka.user WHERE USER_ID = '".$_SESSION['staffid']."'";
                $qrySName = mysqli_query($dbconn, $sqlSName) or array_push($errors, mysqli_error($dbconn));
                $rSName = mysqli_fetch_assoc($qrySName);
            //end search username
            //search department
               // $sqlDptCampus = "SELECT * FROM portalauditor.dpt_campus a 
               // JOIN portalauditor.department b ON b.iddepartment = a.department_iddepartment
               // JOIN portalauditor.campus c ON c.idcampus = a.campus_idcampus
               // WHERE a.iddpt_campus = '".$rUser['dptcampus_id']."'";
               // $qryDptCampus = mysqli_query($dbconn, $sqlDptCampus) or array_push($errors, mysqli_error($dbconn));
               // $rDptCampus = mysqli_fetch_assoc($qryDptCampus);
            //end search department

            //get academic qualification
                $sqlQ = "SELECT * FROM systemuser a 
                LEFT JOIN academicqualification b ON a.idsystemuser = b.systemuser_idsystemuser
                WHERE a.idsystemuser = '".$_SESSION['userid']."'";
                $qryQ = mysqli_query($dbconn, $sqlQ);
                $rQ = mysqli_fetch_assoc($qryQ);
            //end get academic qualification
        
        
        $userId = $_SESSION['staffid'];
        $sqlGetUser = "SELECT * FROM systemuser a 
        JOIN jengka.user b ON a.user_user_id = b.USER_ID
        WHERE user_user_id='".$userId."'";
        $qryGetUser = mysqli_query($dbconn, $sqlGetUser);
        $qryGetFaculty = mysqli_query($dbconn, $sqlGetUser);
        if($qryGetUser){
            $resultGetUser = mysqli_fetch_assoc($qryGetUser);
        }else{
            echo mysqli_error($dbconn);
        }
        
        if($qryGetFaculty){
            $resultGetUser = mysqli_fetch_assoc($qryGetUser);
        }else{
            echo mysqli_error($dbconn);
        }
        
        
        require ("./fpdf/fpdf.php");
        class PDF extends FPDF
        {
            // Page header
            function Header()
            {
                // Logo
                // $this->Image('logo.png',10,6,30);
                // Arial bold 15
                $this->SetFont('Arial','BI',5);
                // Move to the right
                //$this->Cell(80);
                // Title
                $this->SetTextColor(173, 173, 173);
                $this->Cell(170,10,'Teaching Portfolio',0,1,'R');
                // Line break
            }

            /* Page footer
                function Footer()
                {
                    // Position at 1.5 cm from bottom
                    $this->SetY(-15);
                    // Arial italic 8
                    $this->SetFont('Arial','I',8);
                    // Page number
                    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
                }
            */
        }
        
        //generate pdf
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf ->SetLeftMargin(20);
        $pdf ->SetRightMargin(20);
        $fontname = "Arial";
        //A4 Size => 210X297(mm)
        
        //page 1 - cover page
            $pdf ->AddPage('P', 'A4');
            $pdf ->SetFont($fontname, 'B', 16);
            /**
             * Image(param1, param2, param3, param 4, param5, param6, param7)
             * param1 => filepath || URL
             * param2 => abscissa (length to the y-coordinate, parallel to x-coordinate)
             * param3 => ordinate (length to the x-coordinate, parallel to y-coordinate)
             * param4 => width of the image
             * param5 => height of the image(if not written, then auto)
             * param6 => image format
             * param7 => identifier(URL:return by AddLink())
             *  */
            $pdf -> Image("./report/img-report/uitm.png", 55, 30, 100);
            $pdf ->Ln();
            $pdf ->SetFont('Arial', '', 24);
            $pdf ->Cell(0,55,'', 0, 2);
            $pdf ->Cell(0,75,'TEACHING PORTFOLIO', 0, 2, 'C');
            $pdf ->SetLeftMargin(20);
            $pdf ->SetRightMargin(20);
            $pdf ->SetFont('Arial', '', 14);
            $pdf->AddFont('A1', '', 'Aller_Rg.php');
            $pdf->AddFont('A2', '', 'Aller_Bd.php');
            //row
                $pdf ->Cell(52, 15,'Name', 0, 0, 'L');
                $pdf ->Cell(4, 15, ':', 0, 0, 'L');
                $pdf ->MultiCell(120,15,'MUHD EIZAN SHAFIQ BIN ABD AZIZ.', 0,'L'); 
            //end row
            //row
               $pdf ->Cell(52, 15,'Programme/Dept.', 0, 0, 'L');
                $pdf ->Cell(4, 15, ':', 0, 0, 'L');
                 $pdf ->MultiCell(120,15,'JABATAN SAINS KOMPUTER.', 0,'L'); 
            //end row
            //row
                $pdf ->Cell(52, 15,'Faculty/Campus', 0, 0, 'L');
                $pdf ->Cell(4, 15, ':', 0, 0, 'L');
                 $pdf ->MultiCell(120,15,'FSKM, UITM CAWANGAN PAHANG.', 0,'L'); 
            //end row
        //end page 1
        //page 2 - table of content
            $pdf->AddPage();
            $pdf ->SetFont($fontname, 'B', 12);
            $pdf->SetFillColor(143, 4, 138);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(170, 6, 'CONTENTS', 0,1,'C', true);
            //section 1
                $pdf->SetFont($fontname, 'B', 12);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(35, 16, 'SECTION A', 0, 0,'L');
                $pdf->Cell(135, 16, 'PERSONAL PROFILE', 0, 1,'L');
            //end section 1
            //section 2
                $pdf->SetFont($fontname, 'B', 12);
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(35, 16, 'SECTION B', 0, 0,'L');
                $pdf->Cell(135, 16, 'TEACHING PHILOSOPHY', 0, 1,'L');
            //end section 2
        //end page 2 - end table of content
        //divider - section A
            $pdf->AddPage();
            $pdf->Cell(170,65,'',0,1,'C');
            $pdf->SetFont($fontname, 'B', 40);
            $pdf->Cell(170,30,'SECTION A',0,1,'R');
            $pdf->SetFont($fontname, '', 20);
            $pdf->Cell(170,11,'PERSONAL PROFILE',0,1,'R');
        //end divider

        //start content section a
            $pdf->AddPage();
            $pdf->SetFont($fontname, 'B', 12);
            $pdf ->SetRightMargin(20);
            $pdf ->SetLeftMargin(20);
            $pdf->Cell(170, 10, '1.0 PERSONAL PROFILE', 0, 1, 'L');
            /* if($rUser['profilepic'] == null || $rUser['profilepic'] == ''){
                $profImg;
            }
            else{
                $profImg = $rUser['profilepic'];
            }*/
            // $pdf->Image($profImg, 85, 30, 35, 35);
           /* $pdf->Cell(170,44,'',0,1);
            $confont = 'A1';
            $confont2 = 'A2';
            $pdf->SetFont($confont2, '', 12);
            $pdf->SetFillColor(194, 194, 194);
            $pdf->Cell(85, 7, 'Name', 1, 0, 'L', true);
            $pdf->SetFont($confont, '', 12);
            // $pdf->Cell(85, 7, ucwords(strtolower($rSName['USER_NAME'])), 1, 1, 'L');*/
            $pdf ->Cell(52, 15,'Name', 0, 0, 'L');
            $pdf ->Cell(4, 15, ':', 0, 0, 'L');
            $pdf ->MultiCell(120,15,'MUHD EIZAN SHAFIQ BIN ABD AZIZ.', 0,'L'); 
        /*    $pdf->SetFont($confont2, '', 12);
            /*$pdf->Cell(85, 7, 'Staff ID No : ', 1, 0, 'L', true);
            $pdf->SetFont($confont, '', 12);
            // $pdf->Cell(85, 7, ucwords(strtolower($rSName['USER_ID'])), 1, 1, 'L');*/
        /*   $pdf ->Cell(52, 15,'Staff ID No', 0, 0, 'L');
            $pdf ->Cell(4, 15, ':', 0, 0, 'L');
            $pdf ->MultiCell(120,15,'236900.', 0,'L'); 
            $pdf->SetFont($confont2, '', 12);
            $pdf->SetFillColor(194, 194, 194);*/
            $pdf->Cell(85, 7, 'Telephone No. (Office/HP)', 1, 0, 'L', true);
    /*        $pdf->SetFont($confont, '', 12);
            // $pdf->Cell(85, 7, ucwords(strtolower($rUser['officephonenum']))." / ".$rUser['hpnum'], 1, 1, 'L');
            $pdf->SetFont($confont2, '', 12);
            $pdf->Cell(85, 7, 'Current Position', 1, 0, 'L', true);
            $pdf->SetFont($confont, '', 12);
            // $pdf->Cell(85, 7, ucwords(strtolower($rUser['positionname'])), 1, 1, 'L');
            $pdf->SetFont($confont2, '', 12);
            $pdf->SetFillColor(194, 194, 194);
            $pdf->Cell(85, 7, 'Area(s) of Expertise', 1, 0, 'L', true);
            $pdf->SetFont($confont, '', 12);
            $pdf->Cell(85, 7, '-----', 1, 1, 'L');
            $pdf->SetFont($confont2, '', 12);
            $pdf->Cell(85, 7, 'Date Joined UiTM', 1, 0, 'L', true);
            $pdf->SetFont($confont, '', 12);*/
            //get Date
                // $lDate = date("d F Y", strtotime($rUser['datejoinuitm']));
            // $pdf->Cell(85, 7, $lDate, 1, 1, 'L');
            $pdf->Cell(170, 10, '', 0, 1);
            $pdf->SetFont($fontname, 'B', 12);
            $pdf->Cell(170, 10,'Academic Qualifications', 0, 1);
        //end content section a

        //divider - section B
            $pdf->AddPage();
            $pdf->Cell(170,65,'',0,1,'C');
            $pdf->SetFont($fontname, 'B', 40);
            $pdf->Cell(170,30,'SECTION B',0,1,'R');
            $pdf->SetFont($fontname, '', 20);
            $pdf->Cell(170,11,'TEACHING PHILOSOPHY',0,1,'R');
        //end divider
        //divider - section C
            $pdf->AddPage();
            $pdf->Cell(170,65,'',0,1,'C');
            $pdf->SetFont($fontname, 'B', 40);
            $pdf->Cell(170,30,'SECTION C',0,1,'R');
            $pdf->SetFont($fontname, '', 20);
            $pdf->Cell(170,11,'TEACHING RESPONSIBILITIES',0,1,'R');
        //end divider
        // $filename = "REPORT(".$rS['semDesc'].") by ".$rSName['USER_NAME'];
        $pdf->Output();
    }
//}
?>