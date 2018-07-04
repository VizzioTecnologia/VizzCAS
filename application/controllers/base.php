<?php
class Base extends CI_Controller{

	private $_fileExceptionPages;

	private $_filePermissionNodes;

	private $_haveUserTypes = true;

    private $_sessionHash;

	public function __construct(){

		$this->_fileExceptionPages = APPPATH.'config/exception_pages.php';
		$this->_filePermissionNodes = APPPATH . 'config/permission_nodes.php';

		# md5 of system's name
		$this->_sessionHash = "b319c80f8ef1ab14342c8e73d59399e3";

		parent::__construct();

		if($this->checkIsNotExceptionPage()){
            $this->getQuestions();
            $this->initSession();
            $this->checkAuth();
            $this->checkPermission();

		}
        #die(var_dump($_SESSION));
        #session_destroy();
	}

    public function getSessionHash(){
        return $this->_sessionHash;
    }

    /**
     * Function responsible for checking if the current page is an exception or not
     * @return true|false
     */
    public function checkIsNotExceptionPage() {

    	if(file_exists($this->_fileExceptionPages)){

	        include($this->_fileExceptionPages);

	        $access = $this->router->fetch_class() . '/' . $this->router->fetch_method();

	        return in_array($access, $exceptionList) ? false : true;

    	}else{
    		show_error('O Arquivo de configura&ccedil;&atilde;o n&atilde;o foi encontrado. Por favor contate o desenvolvedor do sistema utilizando o e-mail a seguir: ' . EMAIL_SUPPORT, 404);
    	}
    }

    /**
     * Function responsbile for initiate the php session
     */
    public function initSession() {
        if (!isset($_SESSION))
            session_start();
    }

    /**
     * Function responsible for checking if user is logged in or not
     * @return true|false
     */
    public function checkAuth() {
        if (!isset($_SESSION[$this->_sessionHash]['user'])) {
            $_SESSION[$this->_sessionHash]['url'] = current_url();
            redirect(site_url() . '/auth/login/', 'refresh');
            return false;
        }else{
            return true;
        }
    }

    /**
     * Function responsible for checking permissions for each page accessed by the user
     * @return true|false
     */
    public function checkPermission() {

    	if($this->_haveUserTypes)
	    	if(file_exists($this->_filePermissionNodes)){

	    		include($this->_filePermissionNodes);

	            $permission_1 = $this->router->fetch_class() . '/' . $this->router->fetch_method();
                $permission_2 = $this->router->fetch_class() . '/*';

	            $userType = $_SESSION[$this->_sessionHash]['user']->ut_id;

	            if(!in_array($permission_1, $permissions[$userType]) && !in_array($permission_2, $permissions[$userType])){
	            	redirect(site_url() . '/auth/noPermission/', 'refresh');
	            }

	    	}else{
	    		show_error('O Arquivo de permiss&otilde;es n&atilde;o foi encontrado. Por favor contate o desenvolvedor do sistema utilizando o e-mail a seguir: ' . EMAIL_SUPPORT, 404);
	    	}       
    }

    public function getQuestions(){

        $_questions = new Questions_Model();
        $_questions->du_status = 1;
        $total = $_questions->getTotal();

        $_questions->limit(5);
        $_questions->order('du_id DESC');
        $lastFive = $_questions->getRows();

        $data = array('total_questions' => $total, 'last_five' => $lastFive);

        $this->template->write_view('questions', 'template/questions', $data);

    }
}