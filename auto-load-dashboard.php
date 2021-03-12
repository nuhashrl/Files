<?php
session_start();
if(isset($_POST['requesting'])){
    ?>
    <style>
        .collapsible{
            background-color: #777;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: center;
            outline: none;
            font-size: 15px;
            justify-content: center;
            border-radius: 20px;
        }
        .coll-active, .collapsible: hover{
            background-color: #555;
        }
        .collapse-content{
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
            padding: 4px;
            border-radius: 5px;
        }
        .table-group{
            width: 100%;
        }
        table, tr, th, td{
            border: .2px solid #cccccc;
            border-collapse: collapse;
        }
    </style>
    <?php
    $req = $_POST['requesting'];
    include "./connection/dbconn.php";
    $currSem = $_POST['currentSem'];
    $userid = $_SESSION['userid'];
    $sqlCPort = "SELECT * FROM course_port a 
    JOIN portfolio b ON a.portfolio_idportfolio = b.idportfolio
    JOIN jengka.semester c ON c.idsemester = b.semester_SEMESTER_ID
    JOIN jengka.course d ON d.id_course = a.course_id_course
    WHERE c.semDesc = '$currSem' AND b.systemuser_idsystemuser = '$userid'";
    $qryCPort = mysqli_query($dbconn, $sqlCPort);
    //checklist card has been choose
    if($req == "checklist"){
        echo "<div class='my-2'>";
        echo "<h4>Checklist for Each Subject in  $currSem</h4>
        </div>";
        /**search checklist for the current semester session
         * 1 - know current semester
         * 2 - get all the subject and idcourse_port
         * 3 - get all data from port_check based on idcourse_port
         */
        while($rCPort = mysqli_fetch_assoc($qryCPort)){
            $sqlCheck = "SELECT * FROM port_check a 
            JOIN course_port b ON b.idcourse_port = a.courseport_id
            JOIN checklist c ON c.idchecklist = a.checklist_id
            WHERE a.courseport_id = '".$rCPort['idcourse_port']."'";   
            //echo $sqlCheck;  
            $qryCheck = mysqli_query($dbconn, $sqlCheck);  
            ?>
            <div class="plus-content my-1 mx-3">
                <button type="button" class="collapsible"><?php echo $rCPort['code_course']."\t : \t".$rCPort['name_course']?></button>
                <div class="collapse-content"> 
                    <table class="table-group">
                        <?php 
                        while($rCheck = mysqli_fetch_assoc($qryCheck)){
                        ?>
                            <tr>
                                <th width="50%"><?php echo $rCheck['checkitem']?></th>
                                <?php
                                    if($rCheck['workstatus'] == 0){
                                        echo "<td><i class=\"fas fa-times\" style='font-size: 1.7em; color: red;'></i></td>";
                                    }else if($rSList['workstatus'] == 1){
                                        echo "<td><a href='".$rCheck['uploadURL']."'target='_blank'><i class='fas fa-check' style='font-size: 1.7em;color: green;'></i><span style='padding: 15px;font-size: 1em;'></span>[CLICK ME]</a></td>";
                                    }
                                ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
        <script>
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                    this.classList.toggle("coll-active");
                    var content = this.nextElementSibling;
                    
                    if (content.style.display === "block") {
                    content.style.display = "none";
                    } else {
                    content.style.display = "block";
                    }
                });
            }
        </script>
        <?php
    }
    //subject card has been choose
    if($req == "subjectlist")
    {
        echo "<div class='my-2'><h4>Registered Subject for $currSem</h4></div>";
        /**
         * 1 - know current session
         * 2 - know idportfolio
         * 3 - select all course that has been registered in the system based on idportfolio
         */
    if(mysqli_num_rows($qryCPort) != 0){
        $rPortfolio = mysqli_fetch_assoc($qryCPort);
        $idPortfolio = $rPortfolio['idportfolio'];
        $sqlCourseport = "SELECT * FROM course_port a JOIN jengka.course b ON b.id_course = a.course_id_course WHERE a.portfolio_idportfolio = '$idPortfolio'";
        echo $sqlCourseport;
        $qryCourseport = mysqli_query($dbconn, $sqlCourseport);
        echo "<ul style='padding: 0;list-style: none;'>";
        while($rCourseport = mysqli_fetch_assoc($qryCourseport)){
        ?>
            <li><?php echo $rCourseport['name_course']?></li>
        <?php
        }
        
    }
        else{return null;}
        echo "</ul>";
    }
}//end if -> isset(request)
else{
    return null;
}
?>