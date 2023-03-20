<?php
	
	require "dbconnect.php";
	
	if(isset($_POST['uploadPhoto'])){
		
		define('folder', 'images/originals/');
		define('maxRozmiarZdj', 1048576);
		
		$error='';

		$zdjecie=$_FILES['zdjecie'];
		$tytul=$_POST['tytul'];
		$autor=$_POST['autor'];
		$znakWodny=$_POST['znakWodny'];

		$nazwaZdj=$zdjecie['name'];
		$nowaNazwa=time()."-".$nazwaZdj;
		$docelLokalizacja=folder.$nowaNazwa;

		if(empty($_POST['znakWodny'])){ 
			$error = "nie podano znaku wodnego";
		} else {
			
			$dbconnection=get_db();
			//print_r($dbconnection);

			if ($zdjecie['error']==0) {

				$mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $zdjecie['tmp_name']);
	
				if($zdjecie['size']<=maxRozmiarZdj){
					$poprawnyRozmiar=true; 
				}else $poprawnyRozmiar=false;

				if(($mimeType==='image/jpeg')||($mimeType==='image/png')){	
					$poprawnyFormat=true;
				}else $poprawnyFormat=false;
	
				if(!$poprawnyRozmiar&&!$poprawnyFormat){
					$error = "Plik przekracza maksymalny rozmiar 1MB oraz ma niepoprawny format.";
				}else if(!$poprawnyRozmiar){
					$error = "Plik przekracza maksymalny rozmiar 1MB.";
				}else if(!$poprawnyFormat){
					$error = "Plik ma niepoprawny format";
				}else if(!move_uploaded_file( $zdjecie['tmp_name'], $docelLokalizacja)){
					$error = "błąd przenoszenia";
				}else {
	
					//tworzymy miniaturke
					$plik=file_get_contents($docelLokalizacja);
					$orygZdjecie=imagecreatefromstring($plik);
					$szerOryg=imagesx($orygZdjecie);
					$wysOryg=imagesy($orygZdjecie);
					$szerMin=200;
					$wysMin=125;
					$min=imagecreatetruecolor($szerMin,$wysMin);
					imagecopyresampled($min,$orygZdjecie,0,0,0,0,$szerMin,$wysMin,$szerOryg,$wysOryg);
	
					if($mimeType==='image/jpeg'){
						imagejpeg($min,"images/thumbnails/$nowaNazwa");
					} else if($mimeType==='image/png'){
						imagepng($min,"images/thumbnails/$nowaNazwa");
					}
					
					imagedestroy($orygZdjecie);
					imagedestroy($min);
					
					//tworzymy watermark na oryginal zdjecia
					$watermarked = imagecreatetruecolor($szerOryg, $wysOryg);
	
					if($mimeType==='image/jpeg'){
						$nowaWarstwa = imagecreatefromjpeg($docelLokalizacja);
					} else if($mimeType==='image/png'){
						$nowaWarstwa = imagecreatefrompng($docelLokalizacja);
					}
					
					imagecopyresampled($watermarked, $nowaWarstwa, 0, 0, 0, 0, $szerOryg, $wysOryg, $szerOryg, $wysOryg);
					$tekst = $znakWodny;
					$kolor = imagecolorallocate($watermarked, 255,20,21);
					$font = "font/Lucian.ttf";
					imagettftext($watermarked, 80, 30, 200, 400, $kolor, $font, $tekst);
					
					if($mimeType==='image/jpeg'){
						imagejpeg($watermarked,"images/watermarked/$nowaNazwa");
					} else if($mimeType==='image/png'){
						imagepng($watermarked,"images/watermarked/$nowaNazwa");
					}
	
					imagedestroy($nowaWarstwa);
					imagedestroy($watermarked);
	
					//=========================================header("Location: gallery.php");
					die;
				}
			} else $error = "wystąpiły błędy w przesyłaniu zdjęcia";
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
			<h1>
				Przeslij zdjęcie
			</h1>
			<noscript>
					<h6 style="padding: 1rem;">
						Ta strona używa JavaScript. Aby uzyskać pełną funkcjonalność włącz obsługę JavaScript w swojej przeglądarce.
					</h6>
			</noscript>
			
			<div class="addFormWrapper"> 
				<form class="addForm" enctype="multipart/form-data" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
					
				<label for="uploadFileButton">Dodaj zdjęcie</label>
					<input type="file" name="zdjecie" id="uploadFileButton"><br/>

					<label for="znakWodny">Znak wodny: </label>
					<input id="watermarkInput" type="text" name="znakWodny" ><br />

					<label for="tytul">tytuł</label>
					<input type="text" name="tytul" id="tytul"><br />

					<label for="autor">autor</label>
					<input type="text" name="autor" id="autor"><br />

					<input type="submit" name="uploadPhoto" value="Prześlij zdjęcie!">
					 
					<?php
						if(!empty($error)){
							echo '<p style="color: gold;">'.$error.'</p>';
						}
					?>

				</form>

			</div>
				
		</main>

<?php
	require_once "footer.php";
?>

</div>
	
</body>
</html>