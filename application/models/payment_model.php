<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class Payment_Model extends Base_Model {

    public function __construct() {
        parent::__construct('pagamento');
    }

    public function getTotalMoney(){

    	$total = 0;

    	$rows = $this->getRows();

    	foreach($rows as $line){

            if($line->pa_status != 8)
    		    $total += $line->pa_valor;
    	}

    	return $total;
    }

    public function getTotalDone(){

        $total = 0;

        $this->condition('pa_status = 3', 'or');
        $this->condition('pa_status = 4', 'or');
        $this->condition('pa_status = 8', 'or');
        $rows = $this->getRows();

        foreach($rows as $line){

            $total += $line->pa_valor;

        }

        return $total;
    }

    public function getDistinctValues(){
        return $this->runQuery('SELECT distinct pa_valor FROM pagamento');
    }
}
