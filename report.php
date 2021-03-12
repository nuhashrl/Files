<?php
require('fpdf/fpdf.php');
session_start();
if($_SESSION['usertype'] == 1){
    
    include "./connection/dbconn.php";

class PDF extends FPDF{
    
    function WordWrap(&$text, $maxwidth)
{
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($wordwidth > $maxwidth)
            {
                // Word is too long, we cut it
                for($i=0; $i<strlen($word); $i++)
                {
                    $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                    if($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth;
                        $text .= substr($word, $i, 1);
                    }
                    else
                    {
                        $width = $wordwidth;
                        $text = rtrim($text)."\n".substr($word, $i, 1);
                        $count++;
                    }
                }
            }
            elseif($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
}
    function Header(){

        $this->SetFont('Courier','B',8);
        $this->Cell(175,10,'Teaching Portfolio',0,1,'R');
        $this->Ln(5);
    }
    function Footer(){
        //$this->Cell(190,0,'','T',1,'',true);
        $this->SetY(-15);
        $this->SetFont('Arial','B',8);
        $this->Cell(175,10,'page '.$this->PageNo(),0,0,'R');

    }
    function wrap($w,$h,$x,$t){
        $height = $h/3;
        $first = $height+2;
        $second=$height+$height+$height+3;
        $len=strlen($t);

        if($len>30){
            $txt=str_split($t,30);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'',1,1);
        }
        else{
            $this->SetX($w);
            $this->Cell($w,$h,$t,1,1);
        }
    }
}
                $staffid = $_SESSION['staffid'];
                //echo $_SESSION['staffid'];
                /**
                 * 1 - get user basic data
                 * 2 - get current semester
                 * 3 - get the status of portfolio of the current semester
                 */
                //get basic data
                $sql = "SELECT * FROM jengka.user WHERE USER_ID='".$_SESSION['staffid']."'";
                $qry = mysqli_query($dbconn, $sql);
                $r = mysqli_fetch_assoc($qry) or die("ERROR: ".mysqli_error($dbconn));
                $sqlProf = "SELECT * FROM systemuser WHERE user_user_id = '$staffid'";
                $qryProf = mysqli_query($dbconn, $sqlProf);
                $rProf = mysqli_fetch_assoc($qryProf);
                $profPic = $rProf['profilepic'];
                if($profPic == null || $profPic == ''){
                    $profPic = "./uploads/img-profile/default-image.jpg";
                }
                    $sql1 = "SELECT * FROM systemuser a 
                    LEFT JOIN jengka.user b ON b.user_id=a.user_user_id
                     LEFT JOIN position c ON a.currentpos = c.idposition LEFT JOIN uitmcampus d ON a.id_campus = d.id_campus
                    WHERE a.user_user_id = '".$_SESSION['staffid']."'";
                    $qry1 = mysqli_query($dbconn, $sql1);
                    $r1 = mysqli_fetch_assoc($qry1);
                    if($r1['profilepic'] != null){
                        $pImage = $r1['profilepic'];
                     }else{
                        $pImage = './uploads/img-profile/default-image.jpg';
                     }
                
                 $query = "SELECT * FROM academicqualification a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_aq DESC";
                 $result = mysqli_query($dbconn, $query);
                 $row = mysqli_fetch_array($result);
                 $query = "SELECT * FROM adminexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_admin DESC";
                 $result = mysqli_query($dbconn, $query);
                 $row1 = mysqli_fetch_array($result);
                 $query = "SELECT * FROM teachingexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_teachexp DESC";
                 $result = mysqli_query($dbconn, $query);
                 $row2 = mysqli_fetch_array($result);
                 $query = "SELECT * FROM workingexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_workexp DESC";
                 $result = mysqli_query($dbconn, $query);
                 $row3 = mysqli_fetch_array($result);
                 $sqlPort = "SELECT * FROM portfolio a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY idportfolio";
                $qryPort = mysqli_query($dbconn, $sqlPort);
                $phi = mysqli_fetch_array($qryPort);
    
$pdf = new PDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,15);
$pdf->SetLeftMargin(30);
$pdf->SetRightMargin(25);
$pdf->SetTopMargin(15);
$pdf->AddPage();

//Front Page start
$pdf->SetFont('Times','','34');
$pdf->Ln(15);
//$pdf->Image('',67,40,80,);

$pdf->Ln(40);
$pdf->Cell(155,100,'TEACHING PORTFOLIO',0,1,'C');
$pdf->Ln(20);
$pdf->SetFont('Times','','18');

$w=60;
$h=10;
//name
$pdf->Cell(60,10,'Name :',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,10,$r['USER_NAME'],0,1,'C');

//office number
$pdf->Cell(60,8,'Telephone No. :',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r['USER_MOBNO'],0,1,'C');
    
$pdf->Cell(40,10,'Email Address:',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,10,$r['USER_EMAIL'],0,1,'C');
/***$qryCampus=mysqli_query($dbconn,"SELECT name_campus FROM uitmcampus");
$dataCampus=mysqli_fetch_assoc($qryCampus);
$pdf->Cell(100,10,$dataCampus['name_campus'],'LR',1,);***/
//Front Page end

//Start Content page
$pdf->SetFont('Times','','16');
$pdf->AddPage();
$pdf->SetFillColor(120,100,200);
$pdf->SetDrawColor(50,50,100);
$pdf->Cell(150,8,'Content',1,1,'C',true);
$pdf->Ln(10);

$pdf->SetFont('Times','B','12');
$pdf->Cell(100,8,'SECTION A PERSONAL PROFILE',0,1,);
$pdf->Ln(2);
$pdf->Cell(100,8,'SECTION B TEACHING PHILOSOPHY',0,1,);
$pdf->Ln(2);
$pdf->SetFont('Times','','11');
$pdf->Cell(27,8,'2.1',0,0,'R');
$pdf->Cell(120,8,'Teaching Philosophy',0,1,'L');
$pdf->Cell(115,8,'- Beliefs about teaching',0,1,'C');
$pdf->Cell(27,8,'2.2',0,0,'R');
$pdf->Cell(120,8,'Teaching Goals',0,1,'L');
$pdf->Cell(143,8,'- Plans for the future to improve teaching',0,1,'C');
$pdf->Cell(27,8,'2.3',0,0,'R');
$pdf->Cell(120,8,'KPI Faculty',0,1,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','B','12');
$pdf->Cell(100,8,'SECTION C TEACHING DUTIES AND RESPONSIBILITIES',0,1,);
$pdf->Ln(2);
$pdf->SetFont('Times','','11');
$pdf->Cell(27,8,'3.1',0,0,'R');
$pdf->Cell(120,8,'Teaching Duties',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.1',0,0,'L');
$pdf->Cell(100,8,'ATA/Timetable',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.2',0,0,'L');
$pdf->Cell(100,8,'Syllabus',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.3',0,0,'L');
$pdf->Cell(100,8,'Scheme of Work/Lesson Plan',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.4',0,0,'L');
$pdf->Cell(100,8,'Material Developed & Used',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.5',0,0,'L');
$pdf->Cell(100,8,'Sample and Answer Scheme',0,1,'L');
$pdf->Cell(39);
$pdf->Cell(80,8,'i. Test',0,1,'L');
$pdf->Cell(39);
$pdf->Cell(80,8,'ii. Quiz',0,1,'L');
$pdf->Cell(39);
$pdf->Cell(80,8,'iii. tutorial/Lab',0,1,'L');
$pdf->Cell(39);
$pdf->Cell(80,8,'iv. Final Examination',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.6',0,0,'L');
$pdf->Cell(100,8,'Student Attendance Sheet',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.7',0,0,'L');
$pdf->Cell(100,8,'Final Examination Result',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.8',0,0,'L');
$pdf->Cell(100,8,'CDL/CQI',0,1,'L');
$pdf->Cell(27);
$pdf->Cell(12,8,'3.1.9',0,0,'L');
$pdf->Cell(100,8,'SuFO',0,1,'L');
//end content page

//Section A Start
//personal profile page start
$pdf->AddPage();
$pdf->SetFont('Times','B','12');
$pdf->Cell(5,8,'1.0',0,0,'R');
$pdf->Cell(80,8,'PERSONAL PROFILE',0,1,'L');
$pdf->SetFont('Times','','12');
$pdf->Cell(5);
$pdf->Cell(80,8,'Please provide the following information:',0,1,'L');
$pdf->Ln(30);
//$pdf->Cell(60,10,$profPic,0,1,'C');
$pdf->Image($profPic,90,50,50);
//$pdf->Image('img/uitmlogo.png',90,50,50);
//$pdf->Cell(40,40,'',1,1);
$pdf->Ln(10);

$pdf->SetFont('Times','B','12');
$pdf->Cell(5);
$pdf->Cell(60,8,'Name :',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r['USER_NAME'],0,1,'C');
$pdf->Cell(5);
    
$pdf->Cell(60,8,'Staff ID :',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r['USER_ID'],0,1,'C');
$pdf->Cell(5);

$pdf->Cell(60,8,'Telephone No. (Office/HP) :',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r['USER_OFFNO'],0,1,'C');
/***$qryPhone=mysqli_query($dbconn,"SELECT phone_number FROM user");
$dataPhone=mysqli_fetch_assoc($qryPhone);
$pdf->Cell(80,8,$dataName['phone_number'],'LR',1,);***/
$pdf->Cell(5);

$pdf->Cell(60,8,'Current Position: ',0,0,);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r1['positionname'],0,1,'C');
$pdf->Cell(5);

$pdf->Cell(60,8,'Area(s) of Expertise: ',0,0);
$x=$pdf->GetX();
$pdf->Cell(60,8,$row['areaExpertise_aq'],0,1,'C');
$pdf->Cell(5);

$pdf->Cell(60,8,'Date Joined UiTM: ',0,0);
$x=$pdf->GetX();
$pdf->Cell(60,8,$r1['datejoinuitm'],0,1,'C');
$pdf->Cell(5);

$pdf->Ln(10);
$pdf->Cell(5);
$pdf->Cell(50,8,'Academic Qualifications',0,1);
$pdf->Ln(3);
$pdf->SetFont('Times','','10');
$pdf->Cell(5);
//qualification
$pdf->Cell(40,10,'Qualifications',1,0,'C');

//specialization
$pdf->Cell(40,10,'Areas of Specialization',1,0,'C');

//uni/organization
$pdf->Cell(40,10,'Universities/Organizations',1,0,'C');

//date
$pdf->Cell(30,10,'Date',1,1,'C');
$pdf->Cell(5);
$pdf->Cell(40,10,print_r($row['qualification_aq'],true),1,0,'C');
$pdf->Cell(40,10,print_r($row['areaExpertise_aq'],true),1,0,'C');
$pdf->Cell(40,10,print_r($row['organisation_aq'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row['date_aq'],true),1,1,'C');



$pdf->SetFont('Times','B','12');

$pdf->Cell(5);
$pdf->Cell(50,8,'Administrative Experience in UiTM',0,1);
$pdf->Ln(3);
$pdf->SetFont('Times','','10');
$pdf->Cell(5);

//position
$pdf->Cell(40,10,'Positions',1,0,'C');
$pdf->Cell(30,10,'Year (From)',1,0,'C');
$pdf->Cell(30,10,'Year (To)',1,0,'C');
$pdf->Cell(50,10,'Dept./Faculty /Campus,etc.',1,1,'C');
$pdf->Cell(5);
$pdf->Cell(40,10,print_r($row1['position_admin'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row1['startYear_admin'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row1['endYear_admin'],true),1,0,'C');
$pdf->Cell(50,10,print_r($row1['institute_admin'],true),1,1,'C');
$pdf->AddPage();
$pdf->SetFont('Times','B','12');

$pdf->Ln(5);
$pdf->Cell(5);
$pdf->Cell(50,8,'Past Teaching Experience',0,1);
$pdf->Ln(3);
$pdf->SetFont('Times','','10');
$pdf->Cell(5);
//$pdf->Cell(10,10,'',1,0);

$pdf->Cell(40,10,'Institution(s)',1,0,'C');
$pdf->Cell(30,10,'Year (From)',1,0,'C');
$pdf->Cell(30,10,'Year (To)',1,0,'C');
$pdf->Cell(50,10,'Position',1,1,'C');
$pdf->Cell(5);
$pdf->Cell(40,10,print_r($row2['position_teachexp'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row2['startYear_teachexp'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row2['endYear_teachexp'],true),1,0,'C');
$pdf->Cell(50,10,print_r($row2['institute_teachexp'],true),1,1,'C');

$pdf->SetFont('Times','B','12');

$pdf->Ln(5);
$pdf->Cell(5);
$pdf->Cell(50,8,'Past Working Experience (Other than teaching)',0,1);
$pdf->Ln(3);
$pdf->SetFont('Times','','10');
$pdf->Cell(5);
//$pdf->Cell(10,10,'',1,0);

//institution
$pdf->Cell(40,10,'Institution(s)/Organisation(s)',1,0,'C');
$pdf->Cell(30,10,'Year (From)',1,0,'C');
$pdf->Cell(30,10,'Year (To)',1,0,'C');
$pdf->Cell(50,10,'Position',1,1,'C');
$pdf->Cell(5);
$pdf->Cell(40,10,print_r($row3['position_workexp'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row3['startYear_workexp'],true),1,0,'C');
$pdf->Cell(30,10,print_r($row3['endYear_workexp'],true),1,0,'C');
$pdf->Cell(50,10,print_r($row3['institute_workexp'],true),1,1,'C');

//Section A ENd

//Section B Start
$pdf->AddPage();
$pdf->SetFont('Times','B','12');
$pdf->Cell(5,8,'2.0',0,0,'R');
$pdf->Cell(80,8,'TEACHING PHILOSOPHY',0,1,'L');
$pdf->Cell(10,8,'2.1',0,0,'R');
$pdf->Cell(80,8,'Teaching Philosophy',0,1,'L');
$pdf->SetFont('Times','','12');
$nb=$pdf->WordWrap($text,50);
$pdf->Write(5,$phi['philosophy']);

$pdf->AddPage();
$pdf->SetFont('Times','B','12');
$pdf->Cell(10,8,'2.2',0,0,'R');
$pdf->Cell(80,8,'Teaching Goals',0,1,'L');
$pdf->Ln(2);
$pdf->SetFont('Times','','12');
$nb=$pdf->WordWrap($text,50);
$pdf->Write(5,$phi['teachgoal']);
$pdf->AddPage();
$pdf->SetFont('Times','B','12');
$pdf->Cell(10,8,'2.3',0,0,'R');
$pdf->Cell(80,8,'KPI',0,1,'L');
$pdf->Image($phi['kpi'],90,50,50);
//$sqlKpi="SELECT kpi FROM portfolio WHERE staffid='".$_SESSION[userid]."'";
//$qryKpi=mysqli_query($dbconn,$sqlKpi);
//$kpi=mysqli_fetch_assoc($qryKpi);
//$x=$pdf->GetX();
//$pdf->wrap($w,$h,$x,$kpi['kpi']);

$pdf->Ln(2);

//Section B End

//Section C Start
/**$pdf->AddPage();
$pdf->SetFont('Times','B','12');
$pdf->Cell(5,8,'3.0',0,0,'R');
$pdf->Cell(80,8,'TEACHING DUTIES AND RESPONSIBILITIES',0,1,'L');
$pdf->SetFont('Times','','10');
$pdf->Cell(10,8,'3.1',0,0,'R');
$pdf->Cell(80,8,'Teaching Duties',0,1,'L');

$pdf->Ln(2);
$pdf->Cell(12);
$pdf->Cell(10,8,'i)',0,0,'C');
$pdf->Cell(50,8,'Full-time Teaching',0,1,);
$pdf->Ln(2);
$pdf->Cell(5);
$pdf->Cell(50,8,'Name of Program/Course',1,0,'C');
$pdf->Cell(30,8,'Level',1,0,'C');
$pdf->Cell(30,8,'Credit Hour',1,0,'C');
$pdf->Cell(30,8,'No. of Students',1,0,'C');
$pdf->Cell(30,8,'Year/Semester',1,0,'C');
$pdf->Ln(10);

$pdf->Ln(2);
$pdf->Cell(12);
$pdf->Cell(10,8,'ii)',0,0,'C');
$pdf->Cell(50,8,'Part-time Teaching',0,1,);
$pdf->Ln(2);
$pdf->Cell(5);
$pdf->Cell(50,8,'Name of Program/Course',1,0,'C');
$pdf->Cell(30,8,'Level',1,0,'C');
$pdf->Cell(30,8,'Credit Hour',1,0,'C');
$pdf->Cell(30,8,'No. of Students',1,0,'C');
$pdf->Cell(30,8,'Year/Semester',1,1,'C');**/

//Section C End

/***while(){//compare while with db subject entry.

}***/
$pdf->SetFont('Times','B','28');
//Subject material upload start
$pdf->AddPage();
$pdf->Ln(100);
$pdf->SetFillColor(120,100,200);
$pdf->SetDrawColor(50,50,100);
$pdf->Cell(150,15,'TEACHING MATERIALS',1,1,'C',true);//insert subject name

$pdf->SetFont('Times','B','12');
//timetable
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.1',0,0,'R');
$pdf->Cell(80,8,'ATA/Timetable',0,1,'L');
$pdf->Image($phi['timetable'],90,50,50);
//fetch timetable from db

$pdf->Ln(5);

//Syllabus
//$pdf->AddPage();
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.2',0,0,'R');
$pdf->Cell(80,8,'Syllabus',0,1,'L');
$pdf->Image($phi['syllabus'],90,50,50);
//fetch syllabus from db
$pdf->Ln(5);

//Lesson plan
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.3',0,0,'R');
$pdf->Cell(80,8,'Scheme of Work / Lesson Plan',0,1,'L');
//$pdf->Image($phi['lessonPlan'],90,50,50);
//fetch lesson plan from db
$pdf->Ln(5);

//Materials
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.4',0,0,'R');
$pdf->Cell(80,8,'Materials',0,1,'L');
//$pdf->Image($phi['material'],90,50,50);
//fetch material from db
$pdf->Ln(5);

//sample and answer scheme
$pdf->SetFont('Times','B','12');
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.5',0,0,'R');
$pdf->Cell(80,8,'Sample and Answer Scheme (includes samples of student work)',0,1,'L');
$pdf->Ln(2);
//test
$pdf->AddPage();
$pdf->Cell(10,8,'i)',0,0,'R');
$pdf->Cell(40,8,'Test',0,1,'L');
//fetch test from db
$pdf->Ln(5);
//quiz
$pdf->AddPage();
$pdf->Cell(10,8,'ii)',0,0,'R');
$pdf->Cell(40,8,'Quiz',0,1,'L');
//fetch quiz from db
$pdf->Ln(5);
//tutorial/lab
$pdf->AddPage();
$pdf->Cell(10,8,'iii)',0,0,'R');
$pdf->Cell(40,8,'Tutorial/Lab',0,1,'L');
//fetch tuto from db
$pdf->Ln(5);
$pdf->AddPage();
//final examination
$pdf->Cell(10,8,'iv)',0,0,'R');
$pdf->Cell(40,8,'Final Examination',0,1,'L');
//fetch final from db
$pdf->Ln(5);

//student attendance
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.6',0,0,'R');
$pdf->Cell(80,8,'Student Attendance Sheet',0,1,'L');
//fetch attendance from db
$pdf->Ln(2);

//Final exam result
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.7',0,0,'R');
$pdf->Cell(80,8,'Final Examination Result',0,1,'L');
//fetch exam from db
$pdf->Ln(2);

//cdl//cqi
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.8',0,0,'R');
$pdf->Cell(80,8,'CDL/CQI',0,1,'L');
//fetch cdl cqi from db
$pdf->Ln(2);

//SuFo
$pdf->AddPage();
$pdf->Cell(5,8,'3.1.9',0,0,'R');
$pdf->Cell(80,8,'SuFO',0,1,'L');
//fetch sufo from db
$pdf->Ln(2);
//Subject material upload end

$pdf->Output();
}
?>
