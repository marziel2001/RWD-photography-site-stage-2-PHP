<?php
session_start();

if(isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true){
	header("Location:index.php");   //ukrywamy formularz logowania dla zalogowanego użytkownika
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
		<h1>Zaloguj się </h1>

		<noscript>
			<h6 style="padding: 1rem;">Ta strona używa JavaScript. Aby uzyskać pełną funkcjonalność włącz obsługę JavaScript w swojej przeglądarce.</h6>
		</noscript>
			
    <div class="loginWrapper">
        

        <form method="post" action="zaloguj.php">	<!-- tu nam wywołuje skrypt logujący -->
        <label for="nick">Login: </label><br>
		<input type="text" name="nick" id="nick"><br>
        <label for="haslo">Hasło: </label><br><input type="password" name="haslo" id="haslo"><br>
        <input type="submit" name="loguj" value="Zaloguj">
		<?php
		if(!empty($_SESSION['error'])){
			echo '<span style="color: red;" class="formMess">'.$_SESSION['error'].'</span>';
			unset($_SESSION['error']);
		} ?>
        </form>
        <a href="rejestracja.php">Nie masz konta? <br>Zarejestruj się już teraz!</a>
		
		
		
    </div>

	</main>
	
<?php
	require_once "footer.php";
?>

</div>
</body>
</html>