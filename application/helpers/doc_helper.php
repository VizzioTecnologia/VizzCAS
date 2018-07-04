<?php
function clearDoc($doc){

    $array = array('.','-');
    $array_2 = array('','');

    return str_replace($array, $array_2, $doc);
}

function numberToDoc($number){

    $n_1 = substr($number, 0, 3);
    $n_2 = substr($number, 3, 3);
    $n_3 = substr($number, 6, 3);
    $n_4 = substr($number, 9,2);

    return $n_1.".".$n_2.".".$n_3."-".$n_4;
}
function numberToCep($number){

    $n_1 = substr($number, 0, 2);
    $n_2 = substr($number, 2, 3);
    $n_3 = substr($number, 5, 3);

    return $n_1.".".$n_2."-".$n_3;
}