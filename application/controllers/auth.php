<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Auth extends Base{

	public function __construct(){
		parent::__construct();

		# initiate the php session
        $this->initSession();
	}

	public function index(){

        if($this->checkAuth()){
            redirect('dash/', 'refresh');   
        }else{
            redirect('auth/login/', 'refresh');   
        }
	}	

	/**
	*
	*/
	public function login(){

        $this->template->set_template('auth');
        $this->template->add_js(assets('system','js','auth/login.js'),false);
        $this->template->write_view('content', 'auth/login');
        $this->template->render();		
	}

	/**
	*
	*/
	public function ajaxLogin(){

		$_user = new User_Model();

		$_user->us_login = $this->input->post('login');
		$checkUser = $_user->getRow();

		if($checkUser != NULL){

			$checkPassword = $this->checkPassword($this->input->post('password'),$checkUser->us_password);

			if($checkPassword){

				$_SESSION[$this->getSessionHash()]['user'] = $checkUser;

				$result['check'] = 3;

			}else
				$result['check'] = 2;

		}else{
			$result['check'] = 1;
		}

		echo json_encode($result);
	}

	/**
	*
	*/
	public function checkPassword($userPassword,$hashPassword){

		# Load Crypt Library
		$this->load->library('my_password');

		return My_Password::check($userPassword, $hashPassword);
	}

    public function noPermission(){

        $data = array();

        $this->template->write_view('content', 'auth/nopermission', $data);
        $this->template->render();
    }   

    public function ajaxLogout(){
        session_destroy();
    }
    
}