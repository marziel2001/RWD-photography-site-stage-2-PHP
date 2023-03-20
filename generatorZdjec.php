<div class="gridGall">
	
<?php

		$zdjecNaStrone=3;
	
	if (!isset ($_GET['strona']) ) {  
		$strona = 0;  
	} else {  
		$strona = $_GET['strona'];  
	} 

		$zdjecia = scandir('images/originals/');	// wczytujemy sobie liste pozycji w katalogu originals
		$iloscZdj = count($zdjecia)-2;	// odliczamy . i .. od sumy
		$start=$zdjecNaStrone*($strona)+2; // pomijamy . i .. dlatego +2
		
		for($i=$start;$i<($start+$zdjecNaStrone);$i++){	// iterujemy po ilosci zdjec na 1 strone
			if($i<($iloscZdj+2)){ 	// tutaj powodujemy ze nie rysuje nam wiecej zdjec niz jest
?>
			<div class="wrapper">
			<div class="imgContainer">
<?php 
				echo '<a href="images/watermarked/'.$zdjecia[$i].'">';
				echo '<img src="images/thumbnails/'.$zdjecia[$i].'" alt="zdjecie_w_galerii" />' ;					
?>
			</a>
			</div>
			</div>
<?php } } ?>

</div>