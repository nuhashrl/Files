
<html>  
    <head>  
       <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
            
        <title>e-Portfolio: Profile</title>
        <title>e-Portfolio: Working Experience </title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="icon" href="img/uitm.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/navigation.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <style>
        #imgSelector{
            display: none;
        }
        #dispImage{
            max-width: 100px;
            min-width: 100px;
            min-height: 100px;
            max-height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .cc-content{
            position: relative;
            display: flex;
            justify-content: center;
            flex-direction: column;
            background: white;
            border: solid #C2C2C2 1px;
            border-radius: 10px;
        }
        .card-container{
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between; 
            font-size: 1em;
            align-content: center;
            flex-direction: column;
        }
        .card{
            position: relative;
            display:flex;
            margin: 0% 1% 1% 1%;
            min-height: 180px;
            min-width: 200px;
            width: 98%;
            transition: 0.5s;
            opacity: 0.5;
            z-index: 0;
            align-items: center;
            text-align: center;
            flex-direction: column;
            justify-content: center;
            background: whitesmoke;
            border: .5px solid #c4c4c4;
            border-radius: 10px;
            /*
            -webkit-filter: blur(2px);
            -moz-filter: blur(2px);
            -o-filter: blur(2px);
            -ms-filter: blur(2px);
            filter: blur(2px);
            */
        }
        
    </style>      
    </head>  
    <body>  
        
<!--INI IALAH SIDEBAR-->

<?php 
    //include "./sidebar.php";
?>
        <br><br><br><br>    
   <div class="container-fluid cc-conte" style="background: white; border-radius: 20px;"> 
        <div class="container">
            <div class="row justify-content-center align-content-center">
            <div class="deshbot col-md-5 align-content-center">
                <p class="h4 text-center" style="font-weight:500;">TEACHING EXPERIENCES</p>
            </div>
        </div>
   <br />
   <br />
   <div align="right" style="margin-bottom:10px;">
    <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
   </div>
   <br />
   <form method="post" id="user_form">
    <div class="table-responsive">
     <table class="table table-striped table-bordered" id="user_data">
      <tr>
       <th>Organisation</th>
       <th>Position</th>
        <th>Year Start</th>
        <th>Year End</th>
       <th>Details</th>
       <th>Remove</th>
      </tr>
     </table>
    </div>
    <div align="center">
     <input type="submit" name="insert" id="insert" class="btn btn-primary" value="SAVE" />
    </div>
   </form>

   <br />
  </div>
    
  <div id="user_dialog" title="Add Data">
   <div class="col-md-12">
    <label>Enter Organisation/Institute Name</label>
    <input type="text" name="institute_workexp" id="institute_workexp" class="form-control" />
    <span id="error_institute_workexp" class="text-danger"></span>
   </div>
      <div class="col-md-12">
    <label>Enter Position</label>
    <input type="text" name="position_workexp" id="position_workexp" class="form-control" />
    <span id="error_position_workexp" class="text-danger"></span>
   </div>
   <div class="col-md-12">
    <label>Enter Year Start</label>
    <input type="text" name="startYear_workexp" id="startYear_workexp" class="form-control" />
    <span id="error_startYear_workexp" class="text-danger"></span>
   </div>   
   <div class="col-md-12">
    <label>Enter Year End</label>
    <input type="text" name="endYear_workexp" id="endYear_workexp" class="form-control" />
    <span id="error_endYear_workexp" class="text-danger"></span>
   </div>
   <div class="form-group" align="center">
    <input type="hidden" name="row_id" id="hidden_row_id" />
    <button type="button" name="save" id="save" class="btn btn-info">Add</button>
   </div>
  </div>
  <div id="action_alert" title="Action">

  </div>
            
        
    </body>  
</html> 

<script>  
$(document).ready(function(){ 
 
 var count = 0;

 $('#user_dialog').dialog({
  autoOpen:false,
  width:400
 });

 $('#add').click(function(){
  $('#user_dialog').dialog('option', 'title', 'Add Data');
  $('#institute_workexp').val('');
  $('#position_workexp').val('');
  $('#startYear_workexp').val('');
  $('#endYear_workexp').val('');
  $('#error_institute_workexp').text('');
  $('#error_position_workexp').text('');
  $('#error_startYear_workexp').text('');
  $('#error_endYear_workexp').text('');
  $('#institute_workexp').css('border-color', '');
  $('#position_workexp').css('border-color', '');
  $('#startYear_workexp').css('border-color', '');
  $('#endYear_workexp').css('border-color', '');
  $('#save').text('Save');
  $('#user_dialog').dialog('open');
 });

 $('#save').click(function(){
  var error_institute_workexp = '';
  var error_position_workexp = '';
  var error_startYear_workexp = '';
  var error_endYear_workexp = '';
  var institute_workexp = '';
  var position_workexp = '';
  var startYear_workexp = '';
  var endYear_workexp = '';
  if($('#institute_workexp').val() == '')
  {
   error_institute_workexp = 'Institute Name is required';
   $('#error_institute_workexp').text(error_institute_workexp);
   $('#institute_workexp').css('border-color', '#cc0000');
   institute = '';
  }
     else
  {
   error_institute_workexp = '';
   $('#error_institute_workexp').text(error_institute_workexp);
   $('#institute_workexp').css('border-color', '');
   institute_workexp = $('#institute_workexp').val();
  } 
     if($('#position_workexp').val() == '')
  {
      error_position_workexp = '';
 = 'Position is required';
   $('#error_position_workexp').text(error_position);
   $('#position_workexp').css('border-color', '#cc0000');
   position_workexp = '';
  }
     else
  {
   error_position_workexp = '';
   $('#error_position_workexp').text(error_position_workexp);
   $('#position_workexp').css('border-color', '');
   position_workexp = $('#position_workexp').val();
  } 
     if($('#startYear_workexp').val() == '')
  {
   error_startYear_workexp = 'Year Start is required';
   $('#error_startYear_workexp').text(error_startYear_workexp);
   $('#startYear_workexp').css('border-color', '#cc0000');
   startYear_workexp = '';
  }
     else
  {
   error_startYear_workexp = '';
   $('#error_startYear_workexp').text(error_startYear_workexp);
   $('#startYear_workexp').css('border-color', '');
   startYear_workexp = $('#startYear_workexp').val();
  } 
     if($('#endYear_workexp').val() == '')
  {
   error_endYear_workexp = 'Year End is required';
   $('#error_endYear_workexp').text(error_endYear_workexp);
   $('#endYear_workexp').css('border-color', '#cc0000');
   endYear_workexp = '';
  }
  else
  {
   error_endYear_workexp = '';
   $('#error_endYear_workexp').text(error_endYear_workexp);
   $('#endYear_workexp').css('border-color', '');
   endYear_workexp = $('#endYear_workexp').val();
  } 
  if(error_institute_workexp!= '' || error_position_workexp != ''||error_startYear_workexp != ''||error_endYear_workexp != '')
  {
   return false;
  }
  else
  {
   if($('#save').text() == 'Save')
   {
    count = count + 1;
    output = '<tr id="row_'+count+'">';
    output += '<td>'+institute_workexp+' <input type="hidden" name="hidden_institute_workexp[]" id="institute_workexp'+count+'" class="institute_workexp" value="'+institute_workexp+'" /></td>';
    output += '<td>'+position_workexp+' <input type="hidden" name="hidden_position_workexp[]" id="position_workexp'+count+'" class="position_workexp" value="'+position_workexp+'" /></td>';
    output += '<td>'+startYear_workexp+' <input type="hidden" name="hidden_startYear_workexp[]" id="startYear_workexp'+count+'" class="startYear_workexp" value="'+startYear_workexp+'" /></td>';
    output += '<td>'+endYear_workexp+' <input type="hidden" name="hidden_endYear_workexp[]" id="endYear_workexp'+count+'" class="endYear_workexp" value="'+endYear_workexp+'" /></td>';
    output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'">View</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
    output += '</tr>';
    $('#user_data').append(output);
   }
   else
   {
    var row_id = $('#hidden_row_id').val();
    output = '<td>'+institute_workexp+' <input type="hidden" name="hidden_institute_workexp[]" id="institute_workexp'+row_id+'" class="institute_workexp" value="'+institute_workexp+'" /></td>';
    output = '<td>'+institute_workexp+' <input type="hidden" name="hidden_position_workexp[]" id="position_workexp'+row_id+'" class="position_workexp" value="'+position_workexp+'" /></td>';
    output = '<td>'+startYear_workexp+' <input type="hidden" name="hidden_startYear_workexp[]" id="startYear_workexp'+row_id+'" class="startYear_workexp" value="'+startYear_workexp+'" /></td>';
     output = '<td>'+endYear_workexp+' <input type="hidden" name="hidden_endYear_workexp[]" id="endYear_workexp'+row_id+'" class="endYear_workexp" value="'+endYear_workexp+'" /></td>';
    output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+row_id+'">View</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
    $('#row_'+row_id+'').html(output);
   }

   $('#user_dialog').dialog('close');
  }
 });

 $(document).on('click', '.view_details', function(){
  var row_id = $(this).attr("id");
  var institute_workexp = $('#institute_workexp'+row_id+'').val();
   var position_workexp = $('#position_workexp'+row_id+'').val();
var startYear_workexp = $('#startYear_workexp'+row_id+'').val();
  var endYear_workexp = $('#endYear_workexp'+row_id+'').val();
  $('#institute_workexp').val(institute_workexp);
  $('#position_workexp').val(position_workexp);
  $('#startYear_workexp').val(startYear_workexp);
  $('#endYear_workexp').val(endYear_workexp);
  $('#save').text('Edit');
  $('#hidden_row_id').val(row_id);
  $('#user_dialog').dialog('option', 'title', 'Edit Data');
  $('#user_dialog').dialog('open');
 });

 $(document).on('click', '.remove_details', function(){
  var row_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove this row data?"))
  {
   $('#row_'+row_id+'').remove();
  }
  else
  {
   return false;
  }
 });

 $('#action_alert').dialog({
  autoOpen:false
 });

 $('#user_form').on('submit', function(event){
  event.preventDefault();
  var count_data = 0;
  $('.institute_workexp').each(function(){
   count_data = count_data + 1;
  });
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#user_data').find("tr:gt(0)").remove();
     $('#action_alert').html('<p>Data Inserted Successfully</p>');
     $('#action_alert').dialog('open');
    }
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });
 
});  
</script>