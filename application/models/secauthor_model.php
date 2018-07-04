<?php

require_once 'base_model.php';

/**
 * Model Class
 * Related class with the 
 */
class SecAuthor_Model extends Base_Model {

	private $name = "trabalho_co_autor";

    public function __construct() {
        parent::__construct($this->name);
    }
    
    public function getSecAuthorsByJobId($id){

    	$_sql = "SELECT * FROM ".$this->name." INNER JOIN co_autor ON co_autor.ca_id = ".$this->name.".ca_id WHERE ta_id = ".$id;

    	return $this->db->query($_sql)->result_array();

    }

    public function deleteSecAuthorsAndRelationshipsByJobId($id){

    	$data = $this->getSecAuthorsByJobId($id);

    	if(count($data) > 0){
	    	foreach($data as $line){

	    		$this->deleteRelationship($line['tc_id']);

	    		$this->deleteSecAuthor($line['ca_id']);
	    	}	
    	}
    }
    public function deleteSecAuthor($id){

    	$sql = "DELETE FROM co_autor WHERE ca_id = ".$id;

    	return $this->db->query($sql);
    }

    public function deleteRelationship($id){

    	$sql = "DELETE FROM {$this->name} WHERE tc_id = ".$id;

    	return $this->db->query($sql);
    }

}
