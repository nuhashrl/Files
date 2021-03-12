<?php 
session_start();
/**
 * bagi access level nanti
 */
include "./connection/dbconn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
    <title>e-Portfolio: Philosophy</title>
    <link rel="icon" href="img/uitm-logo.png">
            
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="./css/navigation.css">
    
    <script>
        /*start character counter
        function countChar(val){
            var len = val.value.length;
            $("#charnum").text(len+ " out of 5000 Characters");
         }
        //habis character counter*/
     </script>  
    
    <?php
        include "./connection/dbconn.php";
    ?>          
</head>

<body>

<div class="wrapper">

<!--INI IALAH SIDEBAR-->

<?php include "./sidebar.php";?>

<!--DISINI HABISNYA SIDEBAR-->

<div id="content">

    <!--INI IALAH TOPBAR-->
        <?php include "topbar.php";?>
    <!--TAMAT SUDAH TOPBAR-->

        <br><br><br><br>

    <!--INI IALAH PAGE PUNYA ISI-->
    <div class="cc-content">
        <form action="./update-goals0.php" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal">
            
        <div class="row justify-content-center align-content-center">
            <div class="deshbot col-md-5 align-content-center">
                <p class="h4 text-center" style="font-weight:500;">TEACHING GOALS</p>
            </div>
        </div>
        <br>
        <?php
            /**
             * get data 
             */
            $sqlSession = "SELECT * FROM semester ORDER BY SEMESTER_NAME DESC";
            $qrySession = mysqli_query($dbconn, $sqlSession);
        ?>

        <div class="row">
            <!--mulakan content untuk pilih session dan edit goals-->
            <div class="form-group col-md-12">
                <label for="" class="col-md-2">YEAR/SESSION&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                <select name="semses" id="session" onchange="loadData(this.id)" class="col-md-9" required>
                    <option value="">SELECT</option>
                    <?php
                        while($rSession = mysqli_fetch_assoc($qrySession)){
                            echo "<option value='".$rSession['SEMESTER_ID']."'>".$rSession['SEMESTER_NAME']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-12" id="data-philo">
                <!--start collapse section-->
                <div class="form-group col-md-12">
               <!--  <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#teachgoal">VIEW TEACHING GOALS</button>
                    <div id="teachgoals0" class="collapse">
                    </div>-->
                 </div>
                <!--habis collapse section-->
             </div>
            <!--habis pilih section-->
            
            <!--start 1 set untuk text area + instruction-->
            <div class="form-group col-md-12">
                <!--instruction-->
                <div class="col-md-12">
                     <div>
                <p class="h5 text-center" style="font-weight:80;">
                    "Describe your goals in order to help you and your students in the
teaching and learning process."</p>
            </div>
                    <label for="teachgoal">Please write your Teaching Goals here</label>
                </div>
                <!--tunjukkan data yang sedia ada-->
                <div class="form-group col-md-12" id="data-goals">
                    <!--start collapse section-->
                    <div class="form-group col-md-12">
                        <!-- <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#goal0">Simple collapsible</button> -->
                        <div id="goal0" class="collapse">
                        </div>
                    </div>
                    <!--habis collapse section-->
                </div>
                <!--habis load data-->

                <!--start text area-->
                <div class="col-md-12">
                    <textarea class="form-control" id="goals" rows="13" maxlength="5000" name="goals"></textarea>
                    <!--<div>
                        <small id="charnum" class="text-muted">0 out of 5000 Characters</small>
                    </div>-->
                    <!--script for text area-->
                    <script>
                        CKEDITOR.replace("goals");
                    </script>
                    <!--habis script untuk text area-->
                </div>
                <!--habis textarea-->
            </div>
            <!--habis 1 set-->
        </div>
        <!--habis row--> 
        <br>   
        <div class="row justify-content-center">
            <button class="btn btn-primary col-md-5" type="submit" value="submit" name="submit">SAVE</button>
        </div>
                          
        </form>
        </div>
    <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->

</div>

</div>

<div class="overlay"></div>

<script>
    //start load data
    var staff_id = <?php echo $_SESSION['staffid'];?>;
    function loadData(id){
        //console.log(id);
        $("#data-goals").load("./auto-load-goals.php",{
            semester: document.getElementById(id).value,
            val: "load-goal",
            staffid: staff_id
        });
    }
</script>

<?php include "./navbar.php";?>
</body>

</html>