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
        max-width: 200px;
        min-width: 200px;
        min-height: 200px;
        max-height: 200px;
        border-radius: 50%;
        object-fit: cover;
        
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
    <?php 
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
    
    ?>
    <div class="container"  style="background: white; border-radius: 20px; padding-top: 40px;">
    <form action="edit-profile0.php" method = "post" enctype="multipart/form-data" name="auditprofile" autocomplete="off" class="form-horizontal slide-in-right">
            
        <div class="row justify-content-center align-content-center">
            <div class="deshbot col-md-5 align-content-center">
                <p class="h4 text-center" style="font-weight:500;">EDIT PROFILE</p>
            </div>
        </div>

        <br>
        <div id="imgCont">
            <center><img src="<?php echo $pImage;?>" alt="" id="dispImage" srcset="" 
            onclick="clickTrigger()"></center>
            <input type="file" name="profileimg" id="imgSelector" onchange="displayImage(this)">
        </div>

        <div class="form-group col-md-12">
            <label for="" class="">NAME</label>
            <input type="name" id="" name="user[name]" class="form-control slide-in-right" style="border-radius:5px; background:#D3D3D3; border-color:#000;" 
            placeholder="" value="<?php echo $r1['USER_NAME']?>" readonly>
        </div>

        <div class="form-group col-md-12">
            <label for="" class="">STAFF ID</label>
            <input type="name" id="" name="user[staffid]" class="form-control slide-in-right" style="border-radius:5px; background:#D3D3D3; border-color:#000;" 
            placeholder="" value="<?php echo $r1['USER_ID'] ?>"readonly>
        </div>
        
        <div class="form-group col-md-12">
            <label for="" class="">OFFICE TEL NO</label>
            <input type="text" id="" name="user[officeno]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="" value="<?php if($r1['officephonenum']!=''){echo $r1['officephonenum'];}?>">
        </div>

        <div class="form-group col-md-12">
            <label for="" class="">H/P TEL NO</label>
            <input type="text" id="" name="user[hpno]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="" value="<?php if($r1['hpnum']!=''){echo $r1['hpnum'];}?>">
        </div>

        <div class="form-group col-md-12">
            <label for="" class="">CURRENT POSITION</label>
            <select id="" name="user[currPos]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="">
                <option value="">SELECT</option>
                <?php
                    $sqlPos = "SELECT * FROM position";
                    $qryPos = mysqli_query($dbconn, $sqlPos);
                    while($rPos = mysqli_fetch_assoc($qryPos)){
                        if($r1['currentpos'] == $rPos['idposition']){
                            echo '<option value="'.$rPos['idposition'].'" selected>'.$rPos['positionname'].'</option>';
                        }else{
                            echo '<option value="'.$rPos['idposition'].'">'.$rPos['positionname'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="" class="">DATE JOIN UiTM</label>
            <input type="date" id="" name="user[datejoin]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="" value="<?php echo $r1['datejoinuitm']?>">
        </div>
        
        <div class="form-group col-md-12">
            <label for="" class="">CAMPUS</label>
            <select id="" name="user[campus]" class="form-control slide-in-right" style="border-radius:5px;border-color:#000;" 
            placeholder="">
                <option value="">SELECT</option>
                <?php
                    $sqlPos = "SELECT * FROM uitmcampus";
                    $qryPos = mysqli_query($dbconn, $sqlPos);
                    while($rPos = mysqli_fetch_assoc($qryPos)){
                        if($r1['id_campus'] == $rPos['id_campus']){
                            echo '<option value="'.$rPos['id_campus'].'" selected>'.$rPos['name_campus'].'</option>';
                        }else{
                            echo '<option value="'.$rPos['id_campus'].'">'.$rPos['name_campus'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <br><br>
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block slide-in-right submitbutton slide-in-right" name ="submit" value="save" >SAVE</button>
        </div>
        <br>         
        <br>     
    </form>
    </div>   
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