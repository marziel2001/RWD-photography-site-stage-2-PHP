<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="stylesheet" type="text/css" href="gallery.css">
	<link rel="icon" type="image/png" href="favicon-192x192.png" sizes="192x192">

	<script defer src="gallery.js"></script>
	<script src="main.js"></script>
	<title>
		Moje Hobby
	</title>
</head>

<body>
<div class="gContainer">

	<?php
	require_once "header.php";
	?>
	
	<main>

		<div id="switchColor"></div>
		<h1>Galeria zdjęć</h1>

		<noscript>
			<h6 style="padding: 1rem;">Ta strona używa JavaScript. Aby uzyskać pełną funkcjonalność włącz obsługę JavaScript w swojej przeglądarce.</h6>
		</noscript>
			
<?php
	require_once("generatorZdjec.php");
	include_once("zmieniarka.php");
?>
	</main>
	
<?php
	require_once "footer.php";
?>

</div>
</body>
</html>