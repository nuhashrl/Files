<?php
session_start();
if($_SESSION['usertype'] == 1){
    
    include "./connection/dbconn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
        <title>e-Portfolio: Profile</title>
            
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
<style>
        #imgSelector{
            display: none;
        }
        #dispImage{
            max-width: 100px;
            min-width: 100px;
            min-height: 100px;
            max-height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .cc-content{
            position: relative;
            display: flex;
            justify-content: center;
            flex-direction: column;
            background: white;
            border: solid #C2C2C2 1px;
            border-radius: 10px;
        }
        .card-container{
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between; 
            font-size: 1em;
            align-content: center;
            flex-direction: column;
        }
        .card{
            position: relative;
            display:flex;
            margin: 0% 1% 1% 1%;
            min-height: 180px;
            min-width: 200px;
            width: 98%;
            transition: 0.5s;
            opacity: 0.5;
            z-index: 0;
            align-items: center;
            text-align: center;
            flex-direction: column;
            justify-content: center;
            background: whitesmoke;
            border: .5px solid #c4c4c4;
            border-radius: 10px;
            /*
            -webkit-filter: blur(2px);
            -moz-filter: blur(2px);
            -o-filter: blur(2px);
            -ms-filter: blur(2px);
            filter: blur(2px);
            */
        }
        .card-active, .card:hover{
            position: relative;
            background: #d6d6d6;
            opacity: 1;
            transition: 0.5s;
            z-index: 1;
            color: white;
            background: gray;
            width: 120%;
            cursor: pointer;
            /*
            width: 150%;
            -webkit-filter: blur(0px);
            -moz-filter: blur(0px);
            -o-filter: blur(0px);
            -ms-filter: blur(0px);
            filter: blur(0px);
            */
        }
        .chart{
            position: relative;
            width: 110px;
            height: 110px;
            margin: 0 auto;
            text-align: center;
            line-height: 110px;
        }
        .progress-container .progress-box canvas{
            position: absolute;
            top: 0;
            left: 0;

        }
        .card:hover .content p{
            color: white;
        }
        @media screen and (min-width: 930px){
            .card-container{
                flex-direction: row;
                justify-content: center;
                align-items: center;
            }
        }
    </style>      
</head>
<body>

<div class="wrapper">

<!--INI IALAH SIDEBAR-->

<?php 
    include "./sidebar.php";
?>
<!--DISINI HABISNYA SIDEBAR-->
<div id="content">

    <!--INI IALAH TOPBAR-->
     <?php
            include "./topbar.php";
        ?>
    <!--TAMAT SUDAH TOPBAR-->  
    <br><br><br><br>
    <!--INI IALAH PAGE PUNYA ISI-->
 <form action="" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal">
     
    <br>
            <?php
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
    
    //get profile data
                $sqlProf = "SELECT * FROM systemuser WHERE user_user_id = '$staffid'";
                $qryProf = mysqli_query($dbconn, $sqlProf);
                $rProf = mysqli_fetch_assoc($qryProf);
                $profPic = $rProf['profilepic'];
                if($profPic == null || $profPic == ''){
                    $profPic = "./uploads/img-profile/default-image.jpg";
                }
                $currSess = date('Y');
                if(date('m') >=6){
                    $currSess .= '/2';
                }else if(date('m') > 0 && date('m')<6){
                    $currSess .= '/1';
                }
                //count bil subject
                $sqlCSbj = "SELECT COUNT(idcourse_port) as numSbj FROM portfolio a
                 JOIN jengka.semester b ON a.semester_SEMESTER_ID=b.SEMESTER_ID
                 JOIN course_port c ON c.portfolio_idportfolio = a.idportfolio
                JOIN jengka.course d ON d.ID_COURSE = c.course_id_course 
                WHERE b.SEMESTER_NAME = '$currSess'";
                $qryCSbj = mysqli_query($dbconn, $sqlCSbj);
     //           $rCSbj = mysqli_fetch_assoc($qryCSbj);
                //status portfolio
    
            ?>
     
        <div style="border: solid #C2C2C2 1px;border-radius: 10px;background: white;border-collapse: collapse;" class="cc-content container-fluid">
                    <div style="display: inline-block;">
                        <br>
                            <center><img src="<?php echo $profPic?>" alt="" id="dispImage" srcset=""></center>
                        <br>
                        <center><p style="font-size: 1.5rem">Welcome! <?php echo ucwords(strtolower($r['USER_NAME']))?></p></center>
                    </div>
                    <div class="card-container">
                        <div class="card" id="subject-card" onclick="clickMe(this.id)">
                            <div class="content mx-4">
                                <br>
                                <div>
                                    Number of Subject Registered for <?php echo $currSess;?>
                                
                                </div> 
                            </div>
                        </div>   
                        <div class="card">
                            <div class="content mx-4">
                                <div class="progress-container">
                                    Progress of Portfolio for <?php echo $currSess;?>
                                    <div class="progress-box">
                                        <div class="chart" data-percent="">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="checklist-card" class="card" onclick="clickMe(this.id)">
                            <div class="content mx-4">
                                Checklist for <?php echo $currSess;?>
                            </div>
                        </div>     
                        <div class="card">
                            <div class="content mx-4">
                                <p>Deadline</p>
                            </div>
                        </div> 
                         
                    </div>
                    
                </div>
                    <br>
                <div>  
                    <?php
                       
                       //get latest sem
                        
                        $sqlSem = "SELECT * FROM portfolio a
                         JOIN jengka.semester b ON a.semester_SEMESTER_ID=b.SEMESTER_ID
                         JOIN course_port c ON c.portfolio_idportfolio = a.idportfolio
                        JOIN jengka.course d ON d.ID_COURSE = c.course_id_course 
                        WHERE b.SEMESTER_NAME = '$currSess'";
                        $qrySem = mysqli_query($dbconn, $sqlSem);
                        $regCoursePort = array();
                        $checklist = array();
                        $countSbj = 0;
                        while($rSem = mysqli_fetch_assoc($qrySem)){
                            $countCL = 0;
                            $countDone = 0;
                            $countXDone = 0;
                            array_push($regCoursePort, $rSem['idportfolio']);
                            $sqlCheckList = "SELECT * FROM port_check a 
                            JOIN checklist b ON a.checklist_id = b.idchecklist
                            WHERE a.courseport_id = '".$rSem['idportfolio']."' AND a.statusportcheck = 1 ORDER BY idchecklist ASC";
                            $qryCheck = mysqli_query($dbconn, $sqlCheckList);
                            while($rCL = mysqli_fetch_assoc($qryCheck)){
                                //echo $rCL['checkitem']."<br>";
                                $countCL++;
                            }
                            $countSbj++;
                        }
    
                    ?>
                </div>  
                <div class="cc-content" id="auto-load-container" style="background: none;border: none;text-align: center;padding: 5px;">
                    
                </div>               
            </form>
        
        <footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge">
      
     
    </footer>
        <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->
    <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->

</div>

</div>
<?php 
    include "navbar.php";
?>

</body>
    <script>
        function clickTrigger(){
            document.querySelector('#imgSelector').click();
        }
        function displayImage(e){
            if(e.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    document.querySelector('#dispImage').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }
    </script>

    <script>
    $(document).ready(function(){
        var i = 0;
        var j = 0;
        var k = 0;
        var l = 0;
        $("#addTeach").click(function(){
            l++;
            $("#teachArea").append('<div id="adminTeachExpRowL'+l+'" style="background: #CCCCCC;">\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>INSTITUTION</center></label>\
                    <input type="text" id="" name="teachExp[inst][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>FROM [YEAR]</center></label>\
                    <input type="number" id="" name="teachExp[syear][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>TO [YEAR]</center></label>\
                    <input type="number" id="" name="teachExp[eyear][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>POSITION</center></label>\
                    <input type="text" id="" name="teachExp[pos][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <br>\
                    <center><button type="button" name="remove" id="L'+l+'" class="btn_remove btn btn-danger slide-in-right col-md-1">DELETE</button></center>\
                <br>\
            </div>');
        });

        $("#addExpert").click(function(){
            i++;
            $("#expertArea").append('<div id="expertRowI'+i+'"><br>\
            <input type="text" id="valExpertI'+i+'" name="user[areaExpertise][]"\
            class="form-control slide-in-right col-md-12" style="border-radius:5px;border-color:#000;"\
            placeholder="" value="<?php ?>"required><br>\
            <button type="button" name="remove" id="I'+i+'" class="btn_remove btn btn-danger slide-in-right col-md-1">DELETE</button><br>\
            </div>\
            <br>');
        });
        
        var studyLvl = <?php echo json_encode($studlvl); ?>;

        $("#addAcad").click(function(){
            j++;
            $("#acadArea").append('<div id="acadRowJ'+j+'" class="" style="background: #CCCCCC;">\
            <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>STUDY LEVEL</center></label>\
                    <select name="academicQ[level][]" id="" class="form-control slide-in-right col-8">\
                        <option value="">SELECT</option>\
                        <?php
                            while($rStudLvl = mysqli_fetch_assoc($qryStudLvl)){
                                echo "<option value='".$rStudLvl['idstudylevel']."'>".$rStudLvl['qualificationlevel']."</option>";
                            }
                        ?>
                    </select>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>AREAS OF SPECIALIZATION</center></label>\
                    <input type="text" id="valAcadJ0" name="academicQ[specarea][]" class="form-control slide-in-right col-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>UNIVERSITIES/ORGANISATIONS</center></label>\
                    <input type="text" id="valAcadJ0" name="academicQ[uni][]" class="form-control slide-in-right col-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>END DATE</center></label>\
                    <input type="number" id="valAcadJ0" name="academicQ[gdate][]" class="form-control slide-in-right col-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                    <center><button type="button" name="remove" id="J'+j+'" class="btn_remove btn btn-danger slide-in-right col-md-1">DELETE</button></center>\
                <br>\
                <br>\
            </div>\
            ');
         });

        $("#addExp").click(function(){
            k++;
            $("#expArea").append('<div id="adminExpRowK'+k+'" style="background: #CCCCCC;">\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>POSITION</center></label>\
                    <input type="text" id="valExpK0" name="adminexp[positions][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>FROM [YEAR]</center></label>\
                    <input type="number" id="valExpK0" name="adminexp[syear][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>TO [YEAR]</center></label>\
                    <input type="number" id="valExpK0" name="adminexp[eyear][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                <div class="row">\
                    <label for="" class="form-control slide-in-right col-3" style="border:none;background:none;"><center>DEPT/FACULTY/CAMPUS, ETC</center></label>\
                    <input type="text" id="valExpK0" name="adminexp[dept][]" class="form-control slide-in-right col-md-8" style="border-radius:5px;border-color:#000;" placeholder="" value=""required><br>\
                </div>\
                <br>\
                    <center><button type="button" name="remove" id="K'+k+'" class="btn_remove btn btn-danger slide-in-right col-md-1">DELETE</button></center>\
                <br>\
            </div>\
            ');
        });
        /**
         * - buat array utk dapatkan data 
         * - data kene send pada page seterusnya
         * - lpastu delete kat page process
         */
        /*
        $(document).on('click', '.btn_remove',
            function(){
                var button_id = $(this).attr("id");
                var expertVal = $('#valExpert'+button_id+'').val();
                console.log(expertVal);
                $('#expertRow'+button_id+'').remove();
        });

        $(document).on('click', '.btn_remove',
            function(){
                var button_id = $(this).attr("id");
                $('#adminTeachExpRow'+button_id+'').remove();
        });
        
        $(document).on('click', '.btn_remove',
            function(){
                var button_id = $(this).attr("id");
                $('#acadRow'+button_id+'').remove();
        });

        $(document).on('click', '.btn_remove',
            function(){
                var button_id = $(this).attr("id");
                $('#adminExpRow'+button_id+'').remove();
        });
        */ //--------------------------------HABIS [NANTI] SETTLE 2
    });
    
    </script>
</html>
<?php
}
?>