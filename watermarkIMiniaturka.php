<?php

//tworzy miniaturki zdjec

	if($mimeType==='image/jpeg'){
		$oryginal = imagecreatefromjpeg($docelLokalizacja);	//tworzymy uchwyt na oryginal zdjecia z lokalizacji po operacji move
	} else if($mimeType==='image/png'){							// zaleznie od tego czy to jpeg czy png
		$oryginal = imagecreatefrompng($docelLokalizacja);
	}

	$szerMiniatury=200;
	$wysMiniatury=125;

	$szerOryg=imagesx($oryginal);
	$wysOryg=imagesy($oryginal);

	$miniaturka=imagecreatetruecolor($szerMiniatury,$wysMiniatury);
	imagecopyresampled($miniaturka,$oryginal,0,0,0,0,$szerMiniatury,$wysMiniatury,$szerOryg,$wysOryg);

	if($mimeType==='image/jpeg'){
		imagejpeg($miniaturka,"images/thumbnails/$nowaNazwa");
	} else if($mimeType==='image/png'){
		imagepng($miniaturka,"images/thumbnails/$nowaNazwa");
	}

	imagedestroy($miniaturka);

//tworzymy watermark na oryginal zdjecia

	$watermarked = imagecreatetruecolor($szerOryg, $wysOryg);	//tworzymy roboczy (pusty, czarny) obraz o rozmiarze oryginalu w 8 bitach na kanał czyli 16 milionów kolorów

	imagecopyresampled($watermarked, $oryginal, 0, 0, 0, 0, $szerOryg, $wysOryg, $szerOryg, $wysOryg);	// kopiuje nam oryginal zdjecia na nową bitmape (bez zmiany rozmiaru czy czegokolwiek)
	
	$tekst = $znakWodny;																				
	$czcionka = "font/Lucian.ttf";						
	$kolor = imagecolorallocate($watermarked, 199,201,202);	 // to tak nie do konca zrozumiale, przypisuje kolor dla tekstu ale po co mu na wejscie kopia zdjecie? chyba przypisuje do pliku informacje ze bedzie obecny taki kolor w pliku 

	imagettftext($watermarked, 100, 20, 400, 500, $kolor, $czcionka, $tekst);	// wpisuje tekst z czcionką na nasz nowy obraz
	
	if($mimeType==='image/jpeg'){
		imagejpeg($watermarked,"images/watermarked/$nowaNazwa");	// nastepuje zapis zaleznie od typu pliku
	} else if($mimeType==='image/png'){
		imagepng($watermarked,"images/watermarked/$nowaNazwa");
	}

	imagedestroy($oryginal);	// zwalniamy pamiec
	imagedestroy($watermarked);