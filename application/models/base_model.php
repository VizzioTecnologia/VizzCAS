<?php

require_once dirname(__FILE__) . '/../../system/core/Model.php';

class Base_Model extends CI_Model {

    public $__dm;
    public $__fieldType;
    
    public function __construct($table = null) {

        parent::__construct();

        $this->__dm['table'] = $table ? $table : strtolower(get_class($this));

        $this->generateTableStructure();
    }

    /**
     * Generate Table Structure
     * 
     * Get all fields of a specified table and put the fields in PHP Object
     * Check if any field is primary key and save on a separated variable
     *
     * @return null
     */
    private function generateTableStructure() {

        $_ci = &get_instance();

        $fields = $_ci->db->field_data($this->__dm['table']);

        foreach ($fields as $field => $attr) {

            if ($attr->primary_key)
                $this->__dm['primary'] = $attr->name;

            $this->{$attr->name} = NULL;
            $this->__fieldType[$attr->name] = $attr->type;
        }
    }

    /**
     *
     *
     *
     */
    public function getRows() {

        $obj = clone($this);
        unset($obj->__fieldType);
        
        $obj->_query();

        $this->db->from($obj->__dm['table']);
        return $this->db->get()->result();
    }

    /**
     *
     *
     *
     */
    public function getRow() {

        $obj = clone($this);
        unset($obj->__fieldType);
        
        $obj->_query();

        $this->db->from($obj->__dm['table']);
        $result = $this->db->get()->result();

        return (count($result) > 0) ? $result[0] : NULL;
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function runQuery($sql){

        $retorno = $this->db->query($sql);

        return $retorno->result();
    }

    /**
     *
     *
     *
     */
    public function getTotal() {

        $select = $this->db->ar_select;
        $this->db->ar_select = array('count(*) as total');
        $retorno = $this->getRows();
        $this->db->ar_select = $select;

        return $retorno[0]->total;
    }

    /**
     *
     *
     *
     */
    public function initTransaction() {
        $this->db->trans_start();
    }

    /**
     *
     *
     *
     */
    public function endTransaction() {
        $this->db->trans_complete();
    }

    /**
     *
     *
     *
     */
    public function extractAndSet(array $data) {

        $this->load->helper('text');
        
        foreach ($data as $fieldInformations) {

            if ($fieldInformations['value'] != "") {

                $name = $fieldInformations['name'];
                
                if($this->__fieldType[$name] == 'VARCHAR'){

                    $fieldValue = clearAccent($fieldInformations['value']);
                    
                    $this->{$name} = strtoupper($fieldValue);
                    
                }else{
                    $this->{$name} = $fieldInformations['value'];
                }    
            }
        }
    }

    /**
     *
     */
    public function extractAndSetSimple(array $data) {

        $this->load->helper('text');

        foreach ($data as $name => $value) {

            if ($value != "" && $value != NULL) {

                if(array_key_exists($name, $this)){
                    if($this->__fieldType[$name] == 'VARCHAR'){

                        $fieldValue = clearAccent($value);

                        $this->{$name} = strtoupper($fieldValue);

                    }else{
                        $this->{$name} = $value;
                    }
                }

            }
        }
    }

    /**
     *
     *
     *
     */
    public function insertData() {

        $_object = clone($this);

        unset($_object->__dm);
        unset($_object->__fieldType);
        
        return $this->db->insert($this->__dm['table'], $_object);
        
    }

    /**
     *
     *
     *
     */
    public function eliminate(){
        $_object = clone($this);
        unset($_object->__dm);
        unset($_object->__fieldType);

        $canEliminate = false;

        $vars = get_object_vars($_object);
        foreach ($vars as $field => $value) {
            if ($value) {
                $this->db->where($field, $value);
                $canEliminate = true;
            }
        }

        if($canEliminate)
            $this->db->delete($this->__dm['table']);

        return $canEliminate;
    }

    /**
     *
     *
     *
     */
    public function condition($where, $operator = 'and') {
        
        $operator = strtolower($operator);

        if ($operator == 'or')
            $this->db->or_where($where);
        else
            $this->db->where($where);
    }

    /**
     *
     *
     *
     */
    public function updateSpecifiedData(){

        $_object = clone($this);
        unset($_object->__dm);
        unset($_object->__fieldType);

        $this->db->where($this->__dm['primary'], $_object->{$this->__dm['primary']});

        $vars = get_object_vars($_object);
        foreach ($vars as $position => $value) {
            if (!isset($value))
                unset($_object->$position);
        }

        if (count(get_object_vars($_object)) > 0)
            return $this->db->update($this->__dm['table'], $_object);        
    }

    /**
     *
     *
     *
     */
    public function lastQuery(){
        return $this->db->last_query();
    }

    /**
     *
     *
     *
     */
    public function limit($limit, $start = 0){
        $this->db->limit($limit, $start);
    }

    /**
     *
     *
     *
     */
    public function order($order){
        $this->db->order_by($order);
    }

    /**
     *
     *
     *
     */
    public function lastInsertedRow(){
        return $this->db->insert_id();
    }

    /**
     * alterar: Altera conforme todos os atributos do objeto (deve existir chave primary) 
     */
    public function alterar() {

        $obj = clone($this);
        unset($obj->__dm);

        $this->db->where($this->__dm['primary'], $obj->{$this->__dm['primary']});

        $vars = get_object_vars($obj);

        if (count(get_object_vars($obj)) > 0)
            $this->db->update($this->__dm['table'], $obj);
    }

    /**
     * alterarEspecifico: altera somente os atributos que foram especificado utilizando a chave
     * 					  primary definida
     */

    public function alterarEspecificado() {
        $obj = clone($this);
        unset($obj->__dm);

        $this->db->where($this->__dm['primary'], $obj->{$this->__dm['primary']});

        $vars = get_object_vars($obj);
        foreach ($vars as $posicao => $valor) {
            if (!isset($valor))
                unset($obj->$posicao);
        }

        if (count(get_object_vars($obj)) > 0)
            $this->db->update($this->__dm['table'], $obj);
    }

    /**
     * excluir: Exclui conforme definido no objeto
     */
    public function excluir() {
        $obj = clone($this);
        unset($obj->__dm);

        $pode_excluir = false;

        $vars = get_object_vars($obj);
        foreach ($vars as $campo => $valor) {
            if ($valor) {
                $this->db->where($campo, $valor);
                $pode_excluir = true;
            }
        }

        if ($pode_excluir)
            $this->db->delete($this->__dm['table']);
    }

    public function condicao($where, $operador = 'and') {
        $operador = strtolower($operador);

        if ($operador == 'or') {
            $this->db->or_where($where);
        } else {
            $this->db->where($where);
        }
    }

    public function limite($limite, $inicio = 0) {
        $this->db->limit($limite, $inicio);
    }

    private function _query() {
        $obj = clone($this);
        unset($obj->__dm);

        $vars = get_object_vars($obj);
        foreach ($vars as $campo => $valor) {
            if (isset($valor) && $valor != '%') {
                if (preg_match('/%/', $valor)) {
                    $valor = str_replace('%', '', $valor);
                    $this->db->like($this->__dm['table'] . '.' . $campo, $valor);
                } else
                $this->db->where($this->__dm['table'] . '.' . $campo, $valor);
            }
        }
    }

    public function join($table, $campo) {
        $this->db->join($table, "$table.$campo = {$this->__dm['table']}.$campo", 'left');
    }

    /**
     * @return ArrayOfObject
     */
    public function recuperar() {
        $this->_query();

        $this->db->from($this->__dm['table']);
        return $this->db->get()->result();
    }

    public function setFrom($de) {

        $tipo = gettype($de);

        switch ($tipo) {

            case 'array':
            foreach ($this as $campo => $valor)
                if (isset($de[$campo]) && $de[$campo])
                    $this->$campo = $de[$campo];
                break;

                case 'object':
                foreach ($this as $campo => $valor)
                    if (isset($de->$campo) && $de->$campo)
                        $this->$campo = $de->$campo;
                    break;
                }
            }
        }
