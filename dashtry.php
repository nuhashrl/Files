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
            
        <title>e-Portfolio: Subject</title>
    
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
                        <table class="table table-bordered table-striped dashboardtable table-hover" id="subjectform" style="display:none">
                <tbody>
                    <tr>
                        <th>SYLLABUS</th>
                            <td>  
                            <input class="syllabus" type="file" name="syllabus" id="syllabus" required>
                            <a class="preview1">View</a>
                            </td>
                        </tr>

                    <tr>
                        <th>LESSON PLAN</th>
                            <td>  
                            <input class="plan" type="file" name="file" id="file" required>
                            <a class="preview2">View</a>
                            </td>
                    </tr>
                                
                    <tr>
                         <th>MATERIALS DEVELOPED & USED</th>
                         <td>  
                            <input class="materials" type="file" name="file" id="file" required>
                            <a class="preview3">View</a>
                            </td>
                    </tr>

                    <tr>
                            <th>SAMPLE & ANSWER SCHEME</th>
                            <td>  
                            <input class="sample" type="file" name="file" id="file" required>
                            <a class="preview4">View</a>
                            </td>
                    </tr>

                    <tr>
							<th>TEST</th>
                            <td>  
                            <input class="test" type="file" name="file" id="file" required>
                            <a class="preview5">View</a>
                            </td>
                    </tr>

                    <tr>
				            <th>QUIZ / ASSIGNMENT</th>
                            <td>  
                            <input class="quiz" type="file" name="file" id="file" required>
                            <a class="preview6">View</a>
                            </td>
                    </tr>

                    <tr>
			                <th>TUTORIAL / LAB</th>
                            <td>  
                            <input class="lab" type="file" name="file" id="file" required>
                            <a class="preview7">View</a>
                            </td>
                    </tr>

                    <tr>
		                    <th>FINAL EXAMINATION</th>
                            <td>  
                            <input class="final" type="file" name="file" id="file" required>
                            <a class="preview8">View</a>
                            </td>
                    </tr>

                    <tr>
	                        <th>STUDENT ATTENDANCE SHEET</th>
                            <td>  
                            <input class="sheet" type="file" name="file" id="file" required>
                            <a class="preview9">View</a>
                            </td>
                    </tr>
	                <tr>
	                            <th>FINAL EXAMINATION RESULT</th>
                                <td>  
                            <input class="finalresult" type="file" name="file" id="file" required>
                            <a class="preview10">View</a>
                            </td>
                    </tr>

                    <tr>
	                    <th>CDL/CQI</th>
                        <td>  
                            <input class="cdl" type="file" name="file" id="file" required>
                            <a class="preview11">View</a>
                            </td>
                        
                    </tr>

                    <tr>
	                    <th>SuFO</th>
                        <td>  
                            <input class="sufo" type="file" name="file" id="file" required>
                            <a class="preview12">View</a>
                            </td>
                    </tr>
                </tbody>

            </table>
                <footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge"></footer>
                <!--MAKA BERAKHIRLAH PAGE CONTENT DI SINI-->
    <?php 
        include "navbar.php";
    ?>
    </div>
    
             </div>
        </div>
    </div>
</body>


<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td> <select name='subject' id='subject' class='' required><option value="">SELECT</option>
                  <?php while($rSession = mysqli_fetch_assoc($qrySession)){echo "<option value='".$rSession['name_course']."'>".$rSession['name_course'].'</option>';}
                                    ?></select></td>";
   html_code += "<td ><a href = 'dashboard.php'>Uploads</a></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var name_course = [];
  $('.name_course').each(function(){
   name_course.push($(this).text());
  });
  $.ajax({
   url:"dashtry0.php",
   method:"POST",
   data:{name_course:name_course},
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
   url:"view-dashtry.php",
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