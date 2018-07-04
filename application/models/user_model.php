<?php

require_once 'base_model.php';

/**
 * Usuario Model Class
 * Related class with the Usuario table
 */
class User_Model extends Base_Model {

    public function __construct() {
        parent::__construct('user');
    }

}
