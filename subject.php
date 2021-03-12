<?php
session_start();
if($_SESSION['usertype'] == 1){
    
    include "./connection/dbconn.php";
    function listOutSubject($dbconn){
        $sqlSubject = " SELECT * FROM jengka.course ORDER BY id_course ASC";
        $qrySubject = mysqli_query($dbconn, $sqlSubject);
        $subjects = array();
        while ($rSubject = mysqli_fetch_assoc($qrySubject)){
            $sub = array([
                "courseId" => $rSubject['id_course'],
                "courseCode" => $rSubject['code_course'],
                "courseName" => $rSubject['name_course']
            ]);
            $subjects = array_merge($subjects, $sub);
        }
        return $subjects;
    }
    
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
        <title>e-Portfolio: Subject Registration</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
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
                <div class="container-fluid p-4 text-center"  style="background: white; border-radius: 20px; padding-top: 40px;">       
                    <div class="row justify-content-center align-content-center">
                            <div class="deshbot col-md-5 align-content-center">
                                <p class="h4 text-center" style="font-weight:500;">Subject Registration</p>
                            </div>
                    </div>
                    <br>
                    <div class="my-3">
                        <?php
                            /**
                             * get data 
                             */
                            $sqlSession = "SELECT * FROM semester ORDER BY SEMESTER_NAME DESC";
                            $qrySession = mysqli_query($dbconn, $sqlSession);
                            
                        ?>
                        <!--select session-->
                       
                        
                        <div class="form-group col-md-12">
                            <label for="" class="col-md-2">PORTFOLIO YEAR/SESSION&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                            <select name="semses" id="session" class="col-md-9" required>
                                <option value="">SELECT</option>
                                <?php
                                    while($rSession = mysqli_fetch_assoc($qrySession)){
                                        echo "<option value='".$rSession['SEMESTER_ID']."'>".$rSession['SEMESTER_NAME']."</option>";
                                    }
                                ?>
                             </select>
                         </div>
                        <!--start row-->
                        <div class="row">
                    
                            <div class="table-responsive">
                                <table class="table table-bordered" id="crud_table">
                                <tr>
                                    <th width="20%">COURSE</th>
                                    <th width="3%"></th>
                                </tr>
                                <tr>
                                    <?php
                /**
                 * get data 
                 */
                $sqlSession = "SELECT * FROM jengka.course ORDER BY id_course ASC";
                $qrySession = mysqli_query($dbconn, $sqlSession);
                $subjects = listOutSubject($dbconn);
            ?>
            <!--select session-->
                               <td><select name="courseId" id="subject0" class="col-md-9 name_course" required>
                                    <option value="">SELECT</option>
                                    <?php
                                        foreach($subjects as $subject){
                                            echo "<option value='".$subject['courseId']."'>".$subject['courseCode']."</option>";
                                        }
                                    ?>
                                   </select></td>
                                    <td></td>
                                </tr>
                                </table>
                                    <div align="right">
                                        <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
                                    </div>
                                    <div align="center">
                                         <button type="button" name="save" id="save" class="btn btn-info">Save</button>
                                    </div>
                                <br />
                                <div id="inserted_item_data"></div>
                            </div>
                        </div>
                    </div>  
                </div>
         </div>
                <footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge"></footer>
                <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->
    <?php 
        include "navbar.php";
    ?>
    </div>
    
    
</body>


<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+ "'>";
   html_code += "<td><select name='courseId' id='subject0' class='col-md-9 name_course' required><option value=''>SELECT</option>\
     <?php foreach($subjects as $subject) {
        echo "<option value='".$subject['courseId']."'>".$subject['courseCode']. "</option>";
    } ?> </select></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
     var sessionId = $('#session').val();
  var courseId = [];
  $('.name_course').each(function(){
   courseId.push($(this).val());
  });
  console.log(courseId);
  $.ajax({
   url:"subject0.php",
   method:"POST",
   data:{
       "courseId" : courseId,
       "sessionId": sessionId
   },
   success:function(data){
    alert(data);
    $("td[contentEditable='true']").text("");
    for(var i=2; i<= count; i++)
    {
     $('tr#'+i+'').remove();
    }
    fetch_item_data();
   }
  });
 });
 
 function fetch_item_data()
 {
  $.ajax({
   url:"view-subject.php",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
 
});
</script>
<?php
}
?>
