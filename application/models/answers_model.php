<?php

require_once 'base_model.php';

/**
 * Usuario Model Class
 * Related class with the Usuario table
 */
class Answers_Model extends Base_Model {

    public function __construct() {
        parent::__construct('resposta');
    }

}
