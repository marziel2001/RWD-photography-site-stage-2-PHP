<?php
session_start();
if(isset($_POST['usun'])&&isset($_POST['usuniete'])){
	
	foreach($_POST['usuniete'] as $id => $value){	// iterujemy przez zmienione zdjecia w tablicy $_POST
			$_SESSION['zapamietane'][$id]=false;
	}
	header('location: '.$_SERVER["PHP_SELF"].'');
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
		<h1>Zapisane zdjęcia</h1>

		
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ><!-- formularz usuwajacy zdjecia -->
			<div class="gridGall">
				<?php
				require_once "dbconnect.php";
				$dbc=get_db();	// uchwyt połączenia z bazą danych
			
				$zdjecia = $dbc->zdjecia->find();	// wczytujemy sobie liste wszystkich pozycji z kolekcji zdjęć
			
				if(isset($_SESSION['zapamietane'])&&(!empty($_SESSION['zapamietane']))) {
					foreach($zdjecia as $zdjecie){
						foreach($_SESSION['zapamietane'] as $bookmarked => $value){
							if($zdjecie['_id']==$bookmarked){
								if($value==true){
									echo '<div class="wrapper"><div class="imgContainer">';
									echo '<a href="images/watermarked/'.$zdjecie['nazwa'].'">';
									echo '<img src="images/thumbnails/'.$zdjecie['nazwa'].'" alt="zdjecie_w_galerii" /></a></div>';
									echo '<div class="photoText"><span>Tytuł zdjęcia: '.$zdjecie['tytul'].'</span>';
									echo "<span>Autor zdjęcia: ".$zdjecie['autor']."</span>";
									echo '<input class="checkPhoto" type="checkbox" name="usuniete['.$zdjecie['_id'].']" value="true"></div></div>';
								}
							}
						} 
					}
				} else {
					echo '<span class="noResults">Nie ma żadnych zapisanych zdjęć.</span>';
				}	
				?>
			</div>	
		<label class="addToCart" for="deleteFromCart">usuń</label>
		<input class="addToCart" id="deleteFromCart" type="submit" name="usun" value="usun"/></form>

	</main>
	
<?php
	require_once "footer.php";
?>

</div>
</body>
</html>