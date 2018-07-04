<?php

require_once 'base_model.php';

/**
 * Usuario Model Class
 * Related class with the Usuario table
 */
class Questions_Model extends Base_Model {

    public function __construct() {
        parent::__construct('duvida');
    }

}
