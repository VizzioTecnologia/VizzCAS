<?php
function dateIsoToBrSimple($date){

	$in = explode('-',$date);

	return $in[2].'/'.$in[1].'/'.$in[0];

}

function dateBrToIso($date){

    $in = explode('/',$date);

    if(count($in) == 3){
        return $in[2].'-'.$in[1].'-'.$in[0];
    }else
        return $date;

}