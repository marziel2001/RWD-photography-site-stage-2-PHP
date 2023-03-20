<?php
session_start();
if(isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true){
	header("Location:index.php");   //sprawdza czy nie jesteśmy już zalogowani
}


	require "dbconnect.php";

	$nick = '';
	$haslo = '';
	$haslo2 = '';
	$email = '';

	if(isset($_POST['rejestruj']))
	{
		$nick = $_POST['nick'];
		$haslo = $_POST['haslo'];
		$haslo2 = $_POST['haslo2'];
		$email = $_POST['email'];

		$valid=true;
		if(empty($nick)){
			$nickMess = "nie podano loginu";
			$valid=false;
		}
		if(empty($haslo)){
			$passMess = "nie podano hasła";
			$valid=false;
		}
		if(empty($haslo2)){
			$pass2Mess = "nie potwierdzono hasła";
			$valid=false;
		}
		if(empty($email)){
			$emailMess = "nie podano adresu email";
			$valid=false;
		}
		if($valid) {

			if($haslo===$haslo2){

				$hash = password_hash($haslo,PASSWORD_DEFAULT);
				
				$dbc=get_db();

				$newUser = [
					'nick' => $nick,
					'haslo' => $hash,
					'email' => $email
				];

				$ile = $dbc->uzytkownicy->count(['nick'=>$nick]);

				if($ile==0){
					$send = $dbc->uzytkownicy->insertOne($newUser);
					header('Location: index.php');
				}else{
					$error = "istnieje juz uzytkownik o podanym loginie!";
				}
			}else {
				$error = "hasla się nie zgadzają";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="stylesheet" type="text/css" href="gallery.css">
	<link rel="icon" type="image/png" href="favicon-192x192.png" sizes="192x192">

	<script src="main.js"></script>
	<title>
		Moje Hobby
	</title>
</head>

<body>
<div class="gridContainer">

	<?php
	require_once "header.php";
	?>
	
	<main>

		<div id="switchColor"></div>
		<h1>Zarejestruj się</h1>
			
	<div class="loginWrapper">
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">

		<label>Wprowadz login: </label>
		<input type="text" name="nick" value="<?php echo $nick; ?>">
		
		<?php if(!empty($nickMess)){
			echo '<span style="color: red;" class="formMess">'.$nickMess.'</span>';
		} ?><br />

		<label>Wprowadz hasło: </label>
		<input type="password" name="haslo" value="<?php echo $haslo; ?>">

		<?php if(!empty($passMess)){
			echo '<span style="color: red;" class="formMess">'.$passMess.'</span>';	
		} ?><br />

		<label>Powtórz hasło: </label>
		<input type="password" name="haslo2" value="<?php echo $haslo2; ?>">
		
		<?php if(!empty($pass2Mess)){
			echo '<span style="color: red;" class="formMess">'.$pass2Mess.'</span>';
		} ?><br />

		<label>Wprowadz email: </label>
		<input type="text" name="email" value="<?php echo $email; ?>">
		
		<?php if(!empty($emailMess)){
			echo '<span style="color: red;" class="formMess">'.$emailMess.'</span>';
		} ?><br />

		<input type="submit" name="rejestruj" id="rejestruj" value="Zarejestruj się!"/>

		<?php if(!empty($error)){
			echo '<span style="color: red;" class="formMess">'.$error.'</span>';
		} ?>

	</form>
	</div>
	

	</main>
	
<?php
	require_once "footer.php";
?>

</div>
</body>
</html>