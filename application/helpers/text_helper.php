<?php
function dateIsoToBr($date){
	$ex = explode(' ',$date);
	$in = explode('-',$ex[0]);
	$hr = explode(':',$ex[1]);

	return $in[2].'/'.$in[1].'/'.$in[0].' às '.$hr[0].':'.$hr[1];
}

function sanitizeFileName($string){

	$string = str_replace(' ', '_', $string);

	$acentos = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç" 
, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" ); 
	$letras = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c" 
, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" ); 

	$string = str_replace($acentos, $letras, $string);

	$string = strtolower($string);

	return $string;
}