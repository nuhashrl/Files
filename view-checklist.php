<?php 
    session_start();
    /**GET CHECKLIST FOR EACH OF THE DESIRED SUBJECT
     * 1 - choose session & subject
     * 2 - view checklist
     * 3 - 
     */
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
        <!--INI IALAH PAGE PUNYA ISI-->
        <div class="cc-content" style="background: white;">
        <form action="./update-upload-checklist0.php" method="post"  enctype="multipart/form-data">
            <!--Tajuk Besar-->
            <div style="text-align: center;margin: 20px 0;">
                <div class="deshbot align-content-center" style="width: 20%;margin: 0 auto;min-width: 200px;">
                    <p class="h4 text-center" style="font-weight:500;">VIEW SUBJECTS</p>
                </div>
            </div>
            <!-- habis tajuk besar -->
            <!--mulakan content untuk pilih session dan edit subjects-->
            <div class="form-group col-md-12">
            <?php $sqlSession = "SELECT * FROM semester ORDER BY SEMESTER_NAME DESC";
                $qrySession = mysqli_query($dbconn, $sqlSession);
            ?>
                <label for="" class="col-md-2">YEAR/SESSION&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                <select name="subject[semses]" id="session"  onchange="loadCheckList(this.id)" class="col-md-9 wkwkw" required>
                    <option value="">SELECT</option>
                    <?php
                        while($rSession = mysqli_fetch_assoc($qrySession)){
                            echo "<option value='".$rSession['SEMESTER_ID']."'>".$rSession['SEMESTER_NAME']."</option>";
                        }
                     ?>
                </select>
             </div>
            <!--habis pilih session-->
            <!--select subject-->
            <div class="form-group col-md-12" id="subjectList">
                
             </div>
            <div class="form-group col-md-12">
                <input type="button" class="btn btn-info col-md-12" id="loadCheck" onclick="chkListOut()" value="CHECKLIST">
            </div>
            <div class="form-group col-md-12" id="checklist">
            </div>
           
            <!--habis select subject-->
            </form>
        </div>
        <!--TAMAT ISI PAGE-->
    </div>
</div>
<div class="overlay"></div>
<?php include "./navbar.php"; ?>
</body>
<script>
function loadCheckList(id){
    var val = "getSubject";
    var session = document.getElementById(id).value;
    var staffid = "<?php echo $_SESSION['staffid'];?>";
    $("#subjectList").load("./auto-load-checklist.php", {
        sesId: session,
        staffid: staffid,
        val: val
    })
}
</script>
</html>
