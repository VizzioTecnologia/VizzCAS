<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class PaymentNotifications_Model extends Base_Model {

    public function __construct() {
        parent::__construct('notificacoes_pagamento');
    }
}
