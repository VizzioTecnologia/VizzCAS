<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class FaleConosco extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		
		$data = array();

		$this->template->add_js(assets('system','js','faleconosco/index.js'),false);
		$this->template->write_view('content', 'faleconosco/index', $data);
		$this->template->render();
	}

	public function ajaxDataTable(){

		$this->load->library('Datatables');

		$this->datatables->select('du_id, du_nome, du_email, du_assunto, du_data_hora, du_status');

		$this->datatables->from('duvida');

		#$this->datatables->order_by("du_data_hora", "desc");

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-view tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Visualizar Conversa"><i class="fa fa-search"></i></button>&nbsp;<button class="btn btn-success btn-xs btn-answer tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Mudar status da conversa"><i class="fa fa-exchange"></i></button>&nbsp;<button class="btn btn-danger btn-xs btn-delete tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Deletar Conversa"><i class="fa fa-trash-o"></i></button>', 'du_id');

		$this->datatables->add_column('hour', '$1', 'du_data_hora');

		$result = $this->datatables->generate('json');

		echo $result;

	}

	public function view($id = null){

		$this->load->helper('text');

		$question = new Questions_Model();
		$question->du_id = $id;

		$data['initQuestion'] = $question->getRow();

		#
		$ans = new Answers_Model();
		$ans->du_id = $id;
		$ans->join('user', 'us_id');
		$data['answers'] = $ans->getRows();

		#
		$_ci = &get_instance();
		$data['url'] = $_ci->config->slash_item('base_url');


		$this->template->add_js(assets('system','js','faleconosco/view.js'),false);
		$this->template->write_view('content', 'faleconosco/view', $data);
		$this->template->render();
	}

	public function ajaxSaveAnswer(){

		$this->load->helper('text');

		$du_id = $this->input->post('id');

		$type = $this->input->post('type');

		# Update Status of Question
		$_que = new Questions_Model();
		$_que->du_id = $du_id;
		$_que->du_status = 2;
		$_que->updateSpecifiedData();

		$du = $_que->getRow();

		# Save Answer
		$_ans = new Answers_Model();
		$_ans->re_mensagem = htmlentities($this->input->post('answer'));
		$_ans->us_id = $_SESSION[$this->getSessionHash()]['user']->us_id;
		$_ans->du_id = $du_id;
		$_ans->re_data_hora = date('Y-m-d H:i:s');
		$_ans->re_tipo = 1;
		
		if($type == 1){

			# Send Email
			$this->load->library('My_PHPMailer');
			
			$mail = new PHPMailer;
			$mail->SMTPDebug = false;
	        $mail->Charset = 'UTF-8';
	        $mail->isSMTP();
	        $mail->Host = '';
	        $mail->SMTPAuth = true;
	        $mail->Username = '';
	        $mail->Password = '';
	        $mail->Port = 587;
			$mail->SMTPSecure = 'tls';

	        $mail->From = '';
	        $mail->FromName = '';
	        $mail->addAddress($du->du_email, $du->du_nome);

	        $mail->isHTML(true);

	        $dados = array('mensagem' => "Sua dúvida foi respondida pela Comissão Organizadora. Para visualizar acesse o link abaixo.", 'titulo' => "Dúvida respondida", 'link' => 'http://congresso.equoterapia.org.br/fale-conosco/historico/?ref='.md5($du->du_id),'nome' => $du->du_nome);

	        $mail->Subject = utf8_decode("Dúvida respondida");
	        $mail->Body = $this->load->view('faleconosco/email',$dados,true);

	        if (!$mail->send()) {
	            $checkMail =  false;
	        } else {
	            $checkMail = true;
	        }			

	        # Mensagem normal
	        $_ans->re_historico = 1;

		}else{

			# Coloca a mensagem como histórico
			$_ans->re_historico = 2;

			$checkMail = false;
		}

		$check = $_ans->insertData();

		$result = array('type' => $_ans->re_historico,'name' => $_SESSION[$this->getSessionHash()]['user']->us_name, 'message' => $_ans->re_mensagem, 'date' => dateIsoToBr($_ans->re_data_hora), 'check' => $check, 'checkMail' => $checkMail);
		echo json_encode($result);

	}

	public function ajaxEliminate(){

		$id = $this->input->post('id');

		$_ans = new Answers_Model();
		$_ans->du_id = $id;
		$_ans->eliminate();

		$_que = new Questions_Model();
		$_que->du_id = $id;		
		$check = $_que->eliminate();


		echo json_encode(array('check' => $check));
	}	

	public function ajaxChangeStatus(){

		$id = $this->input->post('id');
		$statusAtual = $this->input->post('status');

		$status = ($statusAtual == 1) ? 2 : 1;
		$texto = ($statusAtual == 1) ? "Respondida" : "Aguardando Resposta ";

		$_que = new Questions_Model();
		$_que->du_id = $id;
		$_que->du_status = $status;
		$check = $_que->updateSpecifiedData();

		echo json_encode(array('check' => $check, 'texto' => $texto));
	}


}
