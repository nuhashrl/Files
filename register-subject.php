<?php 
session_start();
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>e-Portfolio: Duties & Responsibilities</title>     
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
    <?php include "./connection/dbconn.php";?>
    <style>
        .select-gp{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
            width: 98%;
        }
        .select-gp label{
            width: 40%;;
        }
        .select{
            width: 98%;
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
        include "./topbar.php"
    ?>
    <!--TAMAT SUDAH TOPBAR-->
    <br><br><br><br>
    <form action="./register-subject0.php" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal">
    <div class="cc-content" style="background: white;">
        <!--tajuk besar-->
        <div style="text-align: center;margin: 20px 0;">
            <div class="deshbot align-content-center" style="width: 20%;margin: 0 auto;min-width: 200px;">
                <p class="h4 text-center" style="font-weight:500;">REGISTER SUBJECTS</p>
            </div>
         </div>
         <!--habis tajuk besar-->
        
        <!--mulakan content untuk pilih session-->
        <?php
            //query pilih session(semester)
            $sqlSession = "SELECT * FROM semester ORDER BY SEMESTER_NAME DESC";
            $qrySession = mysqli_query($dbconn, $sqlSession);
        ?>
        <!--habis query pilih subject-->
        <!--start pilih session-->
        <center>
        <div class="form-group col-md-12 m-2 select-gp">
            <label>YEAR/SESSION</label>
            <select name="subject[semses]" id="sessionSelect" class="select" onchange="checklist()" required>
                <option value="">SELECT</option>
                <?php
                    while($rSession = mysqli_fetch_assoc($qrySession)){
                        echo "<option value='".$rSession['SEMESTER_ID']."'>".$rSession['SEMESTER_NAME']."</option>";
                    }
                    ?>
                </select>
        </div>
        <!--end pilih session(semester)-->
        <!--pilih course-->
        <div class="form-group col-md-12 m-2 select-gp">
            <label>COURSE</label>
            <select name="subject[courseid]" id="courseId" class="select" onchange="checklist()" required>
                <option value="">SELECT</option>
            </select>
        </div>
        <!--habis pilih course-->
        </center>
    </div>
    </form>
    <div class="cc-content" id="checklist-container" style="margin: 12px 0;background: none;border: none;">
        <div class="form-group col-md-12">
            <label for="" class="">Syllabus</label>
            <input type="text" id="" name="subject[syllabus]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="" value="">
        </div>
    </div>
    
</div>
<!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->

</div>

<div class="overlay"></div>

<?php include "./navbar.php"; ?>
    <script>
        $('#sessionSelect').select2();
        $('#courseId').select2({
            ajax:{
                url: 'get-data-subject.php',
                type: 'post',
                dataType: 'json',
                data: function(params){
                    var query = {
                        searchTerm: params.term
                    }
                    return query;
                }, 
                processResults: function(response){
                    return {
                        results: response
                    };
                }, 
                cache: true
            }
        });
        /*function numberList(id){
            var chkId = document.getElementById(id);
            if(chkId.checked == true){
                var valId = id+"number";
                document.getElementById(valId).disabled = false;
            }else{
                var valId = id+"number";
                document.getElementById(valId).disabled = true;
            }
        }*/
        function checklist(){
            // get from year/session & course listdown
            var value = document.getElementById("courseId").value; 
            var semester = document.getElementById("sessionSelect").value;
            if(value != ""){
                if(semester==""){
                    document.getElementById("checklist-content").innerHTML="";
                    document.getElementById("checklist-container").style.background="none";
                }else if(semester!=""){
                    document.getElementById("checklist-container").style.background="white";
                    //console.log(document.getElementById("checklist-container"));
                    $("#checklist-content").load("./auto-load-reg-subject.php", {
                        "request" : <?php echo json_encode(md5("!@checklistSubject@!"))?>,
                        "id": value,
                        "semester": semester
                    });
                }
            }
        }
    </script>
</body>
</html>