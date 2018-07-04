<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Dash extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function index(){

        $data['hash'] = $this->getSessionHash();

		# Realiza a contagem dos participantes
		$_con = new Congressman_Model();
		$_con->cg_tipo = 2;
		$data['countParticipantes'] = $_con->getTotal();
		$data['countParticipantsPayed'] = $_con->getTotalPayed();

		# Realiza a contagem dos apresentadores
		$_con->cg_tipo = 1;
		$data['countApresentadores'] = $_con->getTotal();

		# Realiza a contagem do total arrecadado
		$_pay = new Payment_Model();
		$data['countPayment'] = $_pay->getTotalMoney();
		$data['countPaymentDone'] = $_pay->getTotalDone();

		# Realiza a contagem do total de trabalhos
		$_jobs = new Jobs_Model();
		$data['countJobs'] = $_jobs->getTotal();
		$data['countJobsAccepted'] = $_jobs->getTotalAccepted();
		$data['countJobsDenied'] = $_jobs->getTotalDenied();

        $this->template->add_js(assets('system','js','dash/index.js'),false);
        $this->template->write_view('content', 'dash/index', $data);
        $this->template->render();
	}
}