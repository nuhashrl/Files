<?php
session_start();
include "./connection/dbconn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>e-Portfolio: Upload Material</title>     
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
        include "./topbar.php";
    ?>

    <!--TAMAT SUDAH TOPBAR-->
    <br><br><br><br>
    <!--INI IALAH PAGE PUNYA ISI-->
    <div class="container-fluid p-4 text-center" style="background: white; border-radius: 20px;"> 
        <form action="uploads.php" enctype="multipart/form-data" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal">
            
        <div class="row justify-content-center align-content-center">
            <div class="deshbot col-md-5 align-content-center">
                <p class="h4 text-center" style="font-weight:500;">UPLOAD MATERIAL</p>
            </div>
        </div>

        <div class="my-3">
            
            <div class="custom-file py-2 w-75">
                <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="syllabus" class="custom-file-input" required>
                <label for="uploadsyllabus" class="custom-file-label">Upload Syllabus File</label>
                <small class="form-text text-muted">PDF Only</small>
                </div>
                <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="lessonplan" class="custom-file-input" required>
                <label for="uploadlesson" class="custom-file-label">Upload Lesson Plan File</label>
                <small class="form-text text-muted">PDF Only</small>
                </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="material" class="custom-file-input" required>
                <label for="uploadmaterial" class="custom-file-label">Upload Learning Material File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="studAttend" class="custom-file-input" required>
                <label for="uploadatt" class="custom-file-label">Upload Student Attendance File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="sufo" class="custom-file-input" required>
                <label for="uploadsufo" class="custom-file-label">Upload SUFO File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="cdl" class="custom-file-input" required>
                <label for="uploadcdl" class="custom-file-label">Upload CDL/CQI File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="test" class="custom-file-input" required>
                <label for="uploadtest" class="custom-file-label">Upload Test File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="quiz" class="custom-file-input" required>
                <label for="uploadquiz" class="custom-file-label">Upload Quiz File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="tuto" class="custom-file-input" required>
                <label for="uploadtuto" class="custom-file-label">Upload Tutorial File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="lab" class="custom-file-input" required>
                <label for="uploadlab" class="custom-file-label">Upload Lab Tutorial File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="assignment" class="custom-file-input" required>
                <label for="uploadass" class="custom-file-label">Upload Assignment File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="final" class="custom-file-input" required>
                <label for="uploadfinal" class="custom-file-label">Upload Final Exam File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
            <div class="custom-file py-2 w-75">
                <input type="file" accept="pdf/*" onchange="" name="answer" class="custom-file-input" required>
                <label for="uploadanswer" class="custom-file-label">Upload Answer Scheme File</label>
                <small class="form-text text-muted">PDF Only</small>
            </div>
                </div>
            <!-- if there are any recorded timetable in database -->
            <div class="my-2" style="width: 100%;" id="rec-kpi">
            </div>
            <!-- end if there are no data -->
            <div class="my-2" style="width: 100%;">
                <img style="width: 100%;" id="output_file"/>
            </div>
            <br>
            <button type="submit"  class="btn btn-success" value="Upload" hidden>UPLOAD</button>
        </div>

        <br>                     
        </form>
    </div>
    <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->

</div>

</div>

<div class="overlay"></div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            // hide sidebar
            $('#sidebar').removeClass('active');
            // hide overlay
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            // open sidebar
            $('#sidebar').addClass('active');
            // fade in the overlay
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });

    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function()
    {
        var output = document.getElementById('output_file');
        output.src = reader.result;
    }
        reader.readAsDataURL(event.target.files[0]);
    }

	$(document).ready(
    function(){
        $('input:file').change(
            function(){
                if ($(this).val()) {
                    $('button:submit').attr('hidden',false); 
                } 
            }
            );
    });

    function showKpi(id){
        var value = document.getElementById(id).value;
        if(value=""){
            document.getElementById("rec-kpi").innerHTML = "";
            return;
        }else{
            $('#rec-kpi').load("./.php", {
                yearSession: value,
                request: "load-kpi"
            });
        }
    }
    </script>
</body>

</html>