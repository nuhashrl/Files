<?php
if(isset($_POST['request'])){
    include "./connection/dbconn.php";
    $req = $_POST['request'];
    //echo $req;
    if($req == md5("!@checklistSubject@!")){
        $courseid = $_POST["id"];
        $semesterSession = $_POST['semester'];
        $sqlSubDetail = "SELECT * FROM jengka.course
        WHERE id_course = '".$courseid."'";
        $qrySubDetail = mysqli_query($dbconn, $sqlSubDetail);
        $r = mysqli_fetch_assoc($qrySubDetail);
        echo "<h4 style='padding: 5px; margin-bottom: 10px;'>Checklist for ".strtoupper($r["code_course"])." : ".
        ucwords(strtolower($r['name_course']))."</h4>";
?>
        <style>
            /* The container */
            .checklist-container{
                padding: 0 15%;
                margin-top: 10px;
            }
            .container{
                text-align: left;
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            /* Hide the browser's default checkbox */
            .container input{
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }
            /* Create a custom checkbox */
            .checkmark{
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 25px;
                background-color: #ccc;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark{
                background-color: gray;
            }
            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark{
                background-color: #2196F3;
            }
            
            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after{
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after{
                display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after{
                left: 9px;
                top: 5px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            .checklist-item-container{
                background: #defffc; 
                border-radius: 5px;
                padding: 15px 2px 4px 10px;
                margin: 5px;
                width: 99%;
            }
        </style>
        <hr style="border: 1px solid black; width: 30%;">
        <form action="./register-checklist0.php" method = "post" name="auditprofile" autocomplete="off" class="form-horizontal">
        <div class="checklist-container">
            <?php
            // search for checklist
            $sqlCL = "SELECT * FROM checklist ORDER BY idchecklist";
            $qryCL = mysqli_query($dbconn, $sqlCL);
            while($rCL = mysqli_fetch_assoc($qryCL)){
                ?>
                <div class="checklist-item-container">
                <?php
                if($rCL['checklistcode'] == "S" || $rCL['checklistcode'] == "LP"
                ||$rCL['checklistcode'] == "M"||$rCL['checklistcode'] == "CDL"
                ||$rCL['checklistcode'] == "SUFO"||$rCL['checklistcode'] == "SAS"||$rCL['checklistcode'] == "FER"){
            ?>
                <label class="container" id="<?php echo "_".$rCL["checkitem"]?>" onclick="">
                    <?php echo $rCL["checkitem"] ?>
                    <input type="checkbox" onchange="bilChoice(this.id)" name="subject[<?php echo strtolower($rCL['checklistcode']) ?>]" id="ch<?php echo $rCL['checklistcode'] ?>" >
                    <span class="checkmark"></span>
                </label>
                    <div id="inp<?php echo $rCL['checklistcode'];?>">
                        </div>
            <?php
                }
                else{
                ?>
                    
                        <label class="container" id="<?php echo "_".$rCL["checkitem"]?>" onclick="">
                            <?php echo $rCL["checkitem"] ?>
                            <input type="checkbox" onchange="bilChoice(this.id)" name="subject[<?php echo strtolower($rCL['checklistcode']) ?>]" id="ch<?php echo $rCL['checklistcode'] ?>">
                            <span class="checkmark"></span>
                        </label>
                        <div id="inp<?php echo $rCL['checklistcode'];?>">
                        </div>
                     
                <?php
                }
                ?>
                </div> 
                <?php
            }
            ?>
                <input type="hidden"  name="subject[courseid]" id="courseId" value=<?php echo $courseid?> required>
                <input type="hidden" id="semSes" name="subject[semses]" value="<?php echo $semesterSession?>" required>
                <button type="submit" name="submit" class="btn btn-info" value="registerSub">REGISTER SUBJECT</button>
           
        </div>
    </form>
<?php
    }
}

?>
<script>
function bilChoice(id){
    var elem = document.getElementById(id);
    if(elem.checked == true){
        // console.log("CHECKED");
        var constName = elem.name;
        var inpNumber = document.createElement("INPUT");
        inpNumber.setAttribute("TYPE","NUMBER");
        var label = document.createElement("LABEL");
        var txtLabel = document.createTextNode("Number of Documents: ");
        label.setAttribute("FOR", "Number of Checklist");
        label.appendChild(txtLabel);
        // inpNumber.setAttribute("NAME", ); 
        inpNumber.style.width="100%";
        inpNumber.style.marginBottom="20px";
        var temp = id.substring(2);
        var tempNum = temp+"number";
        inpNumber.setAttribute("NAME", tempNum);
        var idInp = "inp"+temp;
        var inpCont = document.getElementById(idInp);
        inpCont.appendChild(inpNumber);
        inpCont.insertBefore(label, inpNumber);
        // console.log(inpCont);
    }else{
        var temp = id.substring(2);
        var idInp = "inp"+temp;
        var inpCont = document.getElementById(idInp);
        inpCont.innerHTML="";
        // console.log("OFF");
    }
}
</script>