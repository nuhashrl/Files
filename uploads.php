<?php
session_start();
$errors = array();

echo '<pre>';
var_dump($_FILES["syllabus"]);
echo '</pre>';


// if (!empty($_SESSION['usertype'])) {
	include "./connection/dbconn.php";
	include "./fileProcess.php";

	$idSubject = $_POST["idSubject"];
	echo "<br>".$idSubject;
	// validate value post --search for semses
	$sqlSemester = "SELECT * FROM subject WHERE idsubject = '" . $_POST['idSubject'] . "'";

	$qrySubject = mysqli_query($dbconn, $sqlSemester);
	$rSemester = mysqli_fetch_assoc($qrySubject);

	$smtSes = $rSemester['semester_id']; // $smtSes = $rSemester['SEMESTER_ID']; 
	$iduser = $_SESSION['userid'];
	
	$allowFileDoc = ['doc', 'pdf'];

	$syllabusFileDir = fileProcess($_FILES["syllabus"], $allowFileDoc, 'uploads/');
	var_dump($syllabusFileDir);
	if(!$syllabusFileDir[0]){echo "cannot upload";}
	// extract file directory
	else{
		// update table subject
		$sqlUpdate = "UPDATE subject SET syllabus = '".$syllabusFileDir[1]."', material = '".$materialFileDir[1]."' WHERE idsubject = '$idSubject'";
		if(mysqli_query($dbconn, $sqlUpdate)){
			echo 'success update';
		}else{
			echo 'failed to upload';
		}
	}

/* 
	$idportfolio = "";
	//search portfolio id
	$sqlPortfolio = "SELECT idportfolio FROM portfolio a JOIN semester b ON a.SEMESTER_ID=b.SEMESTER_ID JOIN systemuser c ON c.idsystemuser= a.idportfolio WHERE a.SEMESTER_ID  = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
	$qryPortfolio = mysqli_query($dbconn, $sqlPortfolio);
	// echo $sqlPortfolio;
	if (mysqli_num_rows($qryPortfolio) > 0) {
		#dapatkan data
		$res = mysqli_fetch_assoc($qryPortfolio);
		$idportfolio = $res['idportfolio'];
		echo $idportfolio;
	} else {
		#kalau portfolio x wujud lagi
		#kene buat satu portfolio baru
		$sqlInsertPort = "INSERT INTO portfolio(system_idsystemuser, SEMESTER_ID)
            VALUES($iduser, $smtSes)";
		if (!mysqli_query($dbconn, $sqlInsertPort)) {
			array_push($errors, mysqli_error($dbconn));
		}
		$sqlPortfolio = "SELECT idportfolio FROM portfolio WHERE SEMESTER_ID = '$smtSes' AND systemuser_idsystemuser = '$iduser'";
		$qryPortfolio = mysqli_query($dbconn, $sqlPortfolio);

		if (mysqli_num_rows($qryPortfolio) > 0) {
			#dapatkan data
			$res = mysqli_fetch_assoc($qryPortfolio);
			$idportfolio = $res['idportfolio'];
		} else {
			array_push($errors, "ERROR: NO DATA");
		} 
	}*/
/* 
	$qryPortfolio = mysqli_query($dbconn, $sqlPortfolio);
	$test = true; */



// }
