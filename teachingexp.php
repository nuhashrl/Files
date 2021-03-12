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
                                <p class="h4 text-center" style="font-weight:500;">TEACHING EXPERIENCE</p>
                            </div>
                    </div>
                    <br>
                    <div class="my-3">
                        <!--start row-->
                        <div class="row">
                    
                            <div class="table-responsive">
                                <table class="table table-bordered" id="crud_table">
                                <tr>
                                    <th width="20%">FROM</th>
                                    <th width="20%">TO</th>
                                    <th width="35%">POSITION</th>
                                    <th width="30%">INSTITUTE</th>
                                    <th width="10%"></th>
                                </tr>
                                <tr>
                                    <td contenteditable="true" class="startYear_teachexp"></td>
                                    <td contenteditable="true" class="endYear_teachexp"></td>
                                    <td contenteditable="true" class="position_teachexp"></td>
                                    <td contenteditable="true" class="institute_teachexp"></td>
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
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td contenteditable='true' class='startYear_teachexp'></td>";
   html_code += "<td contenteditable='true' class='endYear_teachexp'></td>";
   html_code += "<td contenteditable='true' class='position_teachexp'></td>";
   html_code += "<td contenteditable='true' class='institute_teachexp' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var startYear_teachexp = [];
  var endYear_teachexp = [];
  var position_teachexp = [];
  var institute_teachexp = [];
  $('.startYear_teachexp').each(function(){
   startYear_teachexp.push($(this).text());
  });
  $('.endYear_teachexp').each(function(){
   endYear_teachexp.push($(this).text());
  });
  $('.position_teachexp').each(function(){
   position_teachexp.push($(this).text());
  });
  $('.institute_teachexp').each(function(){
   institute_teachexp.push($(this).text());
  });
  $.ajax({
   url:"teachingexp0.php",
   method:"POST",
   data:{startYear_teachexp:startYear_teachexp, endYear_teachexp:endYear_teachexp, position_teachexp:position_teachexp, institute_teachexp:institute_teachexp},
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
   url:"view-teaching.php",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
 
});
    var index, table = document.getElementById('table');
            for(var i = 1; i < table.rows.length; i++)
            {
                table.rows[i].cells[3].onclick = function()
                {
                    var c = confirm("do you want to delete this row");
                    if(c === true)
                    {
                        index = this.parentElement.rowIndex;
                        table.deleteRow(index);
                    }
                    
                    //console.log(index);
                };
                
            }
</script>

<?php
}
    ?>