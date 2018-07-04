<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class Subscriber_Model extends Base_Model {

    public function __construct() {
        parent::__construct('congressista');
    }

    public function getDistinctAreas(){

        $sql = "SELECT DISTINCT cg_area_profissional FROM congressista";

        return $this->runQuery($sql);

    }
}
