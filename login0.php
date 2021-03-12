<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("./connection/dbconn.php");

$user_name = trim($_POST['username']);
$pass      = trim($_POST['password']);

// To protect MySQL injection (more detail about MySQL injection)
/*$user_name = stripslashes($user_name);
$pass = stripslashes($pass);
$user_name = mysql_real_escape_string($user_name);
$pass = mysql_real_escape_string($pass);*/

/*
	date added: 20 January 2014
	description: authentication using i-Staff Portal using SOAPClient
*/

	if($user_name == "admin" && $pass == "admin")
	{
			$_SESSION['username'] = $user_name;
			$_SESSION['level'] = 99;
			$_SESSION['role'] = 'admin';
			header("Location: admin/dashboard.php");
	}
	else
	{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "444",
			  CURLOPT_URL => "https://integrasi.uitm.edu.my:444/stars/login/json/".$user_name,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "{\n\t\"password\": \"".$pass."\"\n}",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "postman-token: a5f640ca-aedf-6572-f4ef-b6ae06cad9eb",
			    "token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiY2xhc3Nib29raW5nIn0._dTe9KRNSHSBMybfC4Gs6Brv6vO2HxQ8CWp9lOtI0hk"),
			     ));

			   $response = curl_exec($curl);
			   $err = curl_error($curl);

			   curl_close($curl);

			   $json = json_decode($response, TRUE);

				 if($json['status'] == "true")
				{
					$sql = "SELECT * FROM systemuser WHERE user_user_id = '".$_POST['username']."'";
					$query=mysqli_query($dbconn,$sql) or die ("Error: ". mysqli_error($dbconn));
                    $row = mysqli_num_rows($query);
                    $r = mysqli_fetch_assoc($query);
					if($row > 0)
					{	
                        $sqlS = "SELECT * FROM jengka.user WHERE USER_ID='".$user_name."'";
						$qryS = mysqli_query($dbconn, $sqlS) or die(mysqli_error($dbconn));
						$rS = mysqli_fetch_assoc($qryS);
						$_SESSION['userid'] = $r['idsystemuser'];
                        $_SESSION['staffid'] = $rS['USER_ID'];
                        $_SESSION['username'] = $rS['USER_NAME'];
                        $_SESSION['usertype'] = $r['sysacc_idsysaccess'];
                        header("location: ./dashboard.php");
					}
                  else
                    {
						echo "<script language='javascript'>window.alert('You Are Not Yet Registered Yet'); window.location.href='index.php';</script>";
				    }
				}
			   else
			    {
					echo "<script language='javascript'>window.alert('Mismatched Username/Password. Please use registered login account for UiTM Portal i-Staff.'); window.location.href='login.php';</script>";
			    }

		}
mysqli_close($dbconn);
?>