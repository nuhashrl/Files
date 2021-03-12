<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>USER LOGIN</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="css/index.css">
	<link rel="icon" href="img/uitm.ico">
	
</head>

<body>
<div class="container my-container">
	<form name="userlogin" method="post" action="./dummyLogin0.php" class="slide-in-top">
		<div class="container">
		<center>
		        <img src="img/uitm2.png" style="max-width:45%" class="slide-in-top">
		</center>
		<br>
		        <h1 class="slide-in-top"><center>USER LOGIN</center></h1>
		<br>
			
                <center><input type="text" class="form-control text-center slide-in-top login1" placeholder="STAFF ID" name="username" required="required" maxlength=""></center>

		<br>
                <center><input type="password" class="form-control text-center slide-in-top login1" placeholder="PASSWORD" name="password" required="required"></center>
         <br>
			
		        <center><button type="submit" class="btn but1 btn-block slide-in-top animated" name='submit' value="submit">LOGIN</button></center>	
                <center><p>forgot password?</p></center>	
		<br><br>
		</div>
	</form>
</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
</body>
</html>