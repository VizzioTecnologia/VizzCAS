<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class Congressman_Model extends Base_Model {

    public function __construct() {
        parent::__construct('congressista');
    }

    public function getTotalPayed(){

    	$this->join('pagamento', 'cg_id');
    	$this->condition('pagamento.pa_status IN (3,4)');

    	return $this->getTotal();
    }
}
