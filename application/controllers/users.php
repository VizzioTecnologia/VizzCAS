<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Users extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function index(){

		$data = array();

		$this->template->add_js(assets('system','js','users/index.js'),false);
		$this->template->write_view('content', 'users/index', $data);
		$this->template->render();

	}

	public function ajaxDataTable(){

		$this->load->library('Datatables');

		$this->datatables->select('us_id, us_login, us_name, ut_name');

		$this->datatables->from('user');

		$this->datatables->join('user_type', 'user_type.ut_id = user.ut_id', 'left');

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-manage tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Editar Usuário"><i class="fa fa-pencil"></i></button>&nbsp;<button class="btn btn-danger btn-xs btn-delete tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Deletar Usuário"><i class="fa fa-trash-o"></i></button>', 'us_id');

		$result = $this->datatables->generate('json');

		echo $result;

	}

	public function manage($id = null){

		$ut = new UserType_Model();
		$data['ut'] = $ut->getRows();

		$us = new User_Model();
		if($id){	
			$us->us_id = $id;
			$data['user'] = $us->getRow();
			$data['user']->us_password = "keep";
		}else{
			$data['user'] = $us;
		}

		$this->template->add_js(assets('system','js','users/manage.js'),false);
		$this->template->write_view('content', 'users/manage', $data);
		$this->template->render();	

	}
	public function ajaxManage(){

		$this->load->library('my_password');

		$form = $this->input->post('form');
		$id = $this->input->post('id');

		$us = new User_Model();
		$checkUser = clone($us);

		#
		$us->extractAndSet($form);

		if($id){

			$us->us_id = $id;

			if($us->us_password == "keep"){
				$us->us_password = NULL;
			}else{
				$us->us_password = My_Password::hash($us->us_password);
			}
			$result = array('check' => $us->updateSpecifiedData());
		}else{

			$checkUser->us_login = $us->us_login;

			$check = $checkUser->getRow();

			if($check != NULL){
				$result = array('check' => 2);
			}else{
				$us->us_password = My_Password::hash($us->us_password);
				$result = array('check' => $us->insertData(), 'id' => $us->lastInsertedRow());
			}
		}

		echo json_encode($result);
	}
}