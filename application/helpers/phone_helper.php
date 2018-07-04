<?php
function numberToPhone($number){

    $ddd = substr($number, 0, 2);

    $p_1 = substr($number, 2, 4);

    $p_2 = str_replace($ddd.$p_1, '', $number);

    return "+55 (".$ddd.") ".$p_1."-".$p_2;

}
function phoneToNumber($phone){

    $array_1 = array('+55','(',')',' ','-');
    $array_2 = array('','','','','');

    return str_replace($array_1, $array_2, $phone);
}