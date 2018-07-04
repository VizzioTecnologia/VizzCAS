<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class Jobs_Model extends Base_Model {

    public function __construct() {
        parent::__construct('trabalho');
    }
    
    public function changeStatus($id, $status){

    	$this->ta_id = $id;
    	$this->ta_aprovacao = $status;
    	return $this->updateSpecifiedData();

    }

    public function getTotalAccepted(){
    	$this->ta_aprovacao = 2;

    	return $this->getTotal();
    }

    public function getTotalDenied(){
    	$this->ta_aprovacao = 3;

    	return $this->getTotal();
    }
}
