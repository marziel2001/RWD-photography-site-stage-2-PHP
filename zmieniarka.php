<div class="zmieniarkaStron">
	<?php
		$strony = $iloscZdj/$zdjecNaStrone;
		for($i=0;$i<$strony;$i++){
			echo '<a ';
			if($strona==$i){
				echo 'class="gallActivePage" ';
			}
			echo 'href="';
			echo htmlentities($_SERVER["PHP_SELF"]);
			echo '?strona='.$i.'">'.($i+1).'</a>';
		}
	?>
</div> 