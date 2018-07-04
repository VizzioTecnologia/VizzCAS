<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Payments extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function index(){

		$data = array();

		$this->template->add_js(assets('system','js','payments/index.js'),false);
		$this->template->write_view('content', 'payments/index', $data);
		$this->template->render();

	}	

	public function view($id = null){

		$this->load->helper('text');

		$_p = new Payment_Model();
		$_p->pa_id = $id;
		$data['payment'] = $_p->getRow();

		$_pn = new PaymentNotifications_Model();
		$_pn->np_referencia = $data['payment']->pa_referencia;
		$data['notifications'] = $_pn->getRows();

		$this->template->add_js(assets('system','js','payments/view.js'),false);
		$this->template->write_view('content', 'payments/view', $data);
		$this->template->render();

	}

	public function ajaxDataTable(){

		$this->load->library('Datatables');

		$this->datatables->select('pa_id, pa_referencia, cg_nome, pa_valor, pa_data_criacao, pa_status, pa_tipo');

		$this->datatables->from('pagamento');

		$this->datatables->join('congressista', 'congressista.cg_id = pagamento.cg_id', 'left');

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-view tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Visualizar Histórico"><i class="fa fa-search"></i></button>&nbsp;<button class="btn btn-primary btn-xs btn-send-link tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Reenviar link de pagamento" data-tipo-id="$2"><i class="fa fa-envelope"></i></button>&nbsp;<button class="btn btn-warning btn-xs btn-change-status tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Trocar status do pagamento"><i class="fa fa-random"></i></button>', 'pa_id, pa_tipo');

		$result = $this->datatables->generate('json');

		echo $result;

	}

	public function ajaxSendPaymentLink(){
        $newValue = $this->input->post('value');
		
		$dados['pa_id'] = $this->input->post('id');

		if ($newValue) {
			$dados['valor'] = $newValue;
		}

		$data = http_build_query($dados);
		# Envia o post para o pagseguro
		$urlReenvio = $this->config->slash_item('base_url_congresso') . 'reenviar-link-pagamento/?' . $data;
		$curl = curl_init($urlReenvio);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		$rawResponse = curl_exec($curl);
		$retorno = json_decode($rawResponse);
		curl_close($curl);
		//Operação realizada com sucesso
		$check = 2;
		$checkMail = true;
	 	
		$xml= simplexml_load_string($xml);

		if(!$retorno){
			//Operação falhou
			$check = 1;
			$checkMail = false;
		}

		echo json_encode(array('check' => $check, 'link' => $retorno->link, 'checkEmail' => $checkMail));
	}

	public function check_in_range($start_date, $end_date, $date_from_user){

		// Convert to timestamp
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$user_ts = strtotime($date_from_user);

		// Check that user date is between start & end
		return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));

	}

	public function clearNumber($number) {

		$number = str_replace('-', '', $number);
		$number = str_replace('+', '', $number);
		$number = str_replace('.', '', $number);
		$number = str_replace('/', '', $number);
		$number = str_replace('(', '', $number);
		$number = str_replace(')', '', $number);
		$number = str_replace(' ', '', $number);
		return $number;

	}

    public function ajaxChangePaymentStatus(){

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $_pay = new Payment_Model();
        $_pay->pa_id = $id;
        $_pay->pa_status = $status;

        $check = $_pay->updateSpecifiedData();

        echo json_encode(array('check' => $check));

    }

}
