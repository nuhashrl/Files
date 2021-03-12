<?php
include "./connection/dbconn.php";
if(isset($_POST["val"])){
    if($_POST["val"] == "getSubject"){
        $session = $_POST['sesId'];
        $sqlSId = "SELECT idsystemuser FROM systemuser WHERE user_user_id = '".$_POST['staffid']."'";
        $rSId = mysqli_fetch_assoc(mysqli_query($dbconn, $sqlSId));
        $userid = $rSId['idsystemuser'];
        $sqlSCourse = "SELECT * FROM course_port a 
        LEFT JOIN classbook_backup_jengka.course b ON b.id_course = a.course_id_course
        LEFT JOIN portfolio c ON c.idportfolio = a.portfolio_idportfolio
        WHERE c.semester_idsemester='$session' AND systemuser_idsystemuser='$userid'";
        $qrySSub = mysqli_query($dbconn, $sqlSCourse);
        echo mysqli_error($dbconn);
        
    ?>
    <label for="" class="col-md-2">SUBJECT&nbsp;&nbsp;&nbsp;&nbsp;: </label>
    <select class="col-md-9 wkwkw" id="dw" name ="subject[courseid]" 
    required>
        <option value="">SELECT</option>
        <?php
        while($rSub = mysqli_fetch_assoc($qrySSub)){
            echo "<option value='".$rSub['id_course']."'>".$rSub['code_course']." - ".$rSub['name_course']."</option>";
        }
        ?>
    </select>
    <script>
        function chkListOut(){
            var val = "getList";
            var session = "<?php echo $_POST["sesId"];?>";
            var userid = "<?php echo $userid;?>";
            var courseid = document.getElementById("dw").value;
            $("#checklist").load("./auto-load-checklist.php",{
                val: val,
                session: session,
                userid: userid,
                courseid: courseid
            });
        }
    </script>
    
    <?php
    }//endif => getSubject
    if($_POST["val"] == "getList"){
        $session = $_POST['session'];
        $userid = $_POST['userid'];
        $courseid = $_POST['courseid']; 
        $sqlSList = "SELECT * FROM port_check a 
        LEFT JOIN course_port b ON b.idcourse_port = a.courseport_id
        LEFT JOIN portfolio c ON c.idportfolio = b.portfolio_idportfolio
        LEFT JOIN checklist d ON d.idchecklist = a.checklist_id
        WHERE c.systemuser_idsystemuser ='$userid' AND a.statusportcheck =1 
        AND c.semester_idsemester = '$session' AND b.course_id_course = '$courseid'
        ORDER BY d.checklistcode";
        $qrySList = mysqli_query($dbconn, $sqlSList);
        $qrytemp = mysqli_query($dbconn, $sqlSList);
        $names = array();
        $num = 0;
        while($rTemp = mysqli_fetch_assoc($qrytemp)){
            if(in_array($rTemp['checkitem'],$names)){
                $num++;
                array_push($names,$rTemp['checkitem']."#".($num+1));
            }else{
                $num = 0;
                array_push($names,$rTemp['checkitem']);
            }
        }
        ?>
        <input type="hidden" name="idportfolio" value="<?php echo $rTemp['idportfolio']?>">
        <table class="table table-bordered table-striped dashboardtable table-hover" id="tabledash">
            <thead>
                <th>SECTION</th>
                <th>UPLOAD BUTTON</th>
                <th>CHECKLIST</th>
            </thead>
            <tbody>
        <?php
        if(mysqli_num_rows($qrySList)>0){
            $i = 0;
            while($rSList = mysqli_fetch_assoc($qrySList)){
                $i++;
                $name = $names[($i-1)];
                ?>
                        <tr>
                            <?php
                                echo "<td>".$name."</td>";
                                echo "<td>
                                <input type='file' id='".$rSList['idport_check']."' name='item[]' onchange = 'activeId(this.id)'>
                                <input type='hidden' name='idportcheck[]' id='h".$rSList['idport_check']."'>
                                </td>";
                            if($rSList['workstatus'] == 0){
                                echo "<td><i class=\"fas fa-times\" style='font-size: 1.7em; color: red;'></i></td>";
                            }else if($rSList['workstatus'] == 1){
                                echo "<td><a href='".$rSList['uploadURL']."' target='_blank'><i class='fas fa-check' style='font-size: 1.7em;color: green;'></i><span style='padding: 15px;font-size: 1em;'></span>[CLICK ME]</a></td>";
                            }
                            ?>
                        </tr>
                <?php
            }
        }
        ?>
            </tbody>
        </table>
        <div class="form-group col-md-12">
            <button type="submit" name="submit" value="submit" class="col-md-12 btn btn-success">SUBMIT</button>
        </div>
        <script>
            function activeId(id){
                var tempId = "#"+id;
                //console.log($(tempId)[0].files);
                if($(tempId)[0].files != null){
                    var newId = "h"+id;
                    document.getElementById(newId).value=id;
                }
            }
         </script>
        <?php
    }
    ?>
<?php   
}
?>