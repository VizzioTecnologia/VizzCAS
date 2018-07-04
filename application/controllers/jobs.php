<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Jobs extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function index(){

		$data = array();

		$this->template->add_js(assets('system','js','jobs/index.js'),false);
		$this->template->write_view('content', 'jobs/index', $data);
		$this->template->render();

	}

	public function ajaxPdf(){

		$this->load->helper('text');
		$this->load->library('mpdf/mpdf');

		$_job = new Jobs_Model();
		$_job->ta_id = $this->input->post('id');
		$_job->join('congressista','cg_id');
		$dados['jobs'] = $_job->getRows();

		$_ca = new SecAuthor_Model();

		$dados['coautores'] = $_ca->getSecAuthorsByJobId($_job->ta_id);
		$dados['hideAuthorInfos'] = $this->input->post('option');		

		$html = $this->load->view('jobs/pdf',$dados,true);

		$stylesheet = file_get_contents(FCPATH.'assets/system/css/pdf.css');

		$mpdf= new mPDF();
		$mpdf->WriteHTML($stylesheet,1);
		
		$mpdf->WriteHTML($html);

		if(count($dados['jobs']) == 1){
			$fileName = sanitizeFileName($dados['jobs'][0]->cg_nome).'_'.time().'.pdf';
			// trabalho_fulana_de_tal_timestamp	
		}else{
			// relatorio_trabalhos_dia_mes_ano_timestamp
		}

		$pathFile = FCPATH.'files/jobs/'.$fileName;

		$mpdf->Output($pathFile);

		$data['file'] = $fileName;

		echo json_encode($data);
	}

	public function ajaxDataTable(){

		$this->load->library('Datatables');

		$this->datatables->select('ta_id, cg_numero_inscricao, ta_titulo, ta_prioridade_apresentacao, ta_aprovacao');

		$this->datatables->from('trabalho');

		$this->datatables->where('ta_status != 2');

		$this->datatables->join('congressista', 'congressista.cg_id = trabalho.cg_id', 'left');

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-view tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Visualizar Trabalho"><i class="fa fa-search"></i></button>&nbsp;<button class="btn btn-danger btn-xs btn-delete tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Deletar Trabalho"><i class="fa fa-trash-o"></i></button>', 'ta_id');

		$result = $this->datatables->generate('json');

		echo $result;

	}

	public function view($id = null){

		$job = new Jobs_Model();
		$job->ta_id = $id;
		$job->join('congressista','cg_id');
		$data['job'] = $job->getRow();

		$secAuthor = new SecAuthor_Model();

		$data['secAuthors'] = $secAuthor->getSecAuthorsByJobId($id);

		$this->template->add_js(assets('system','js','jobs/view.js'),false);
		$this->template->write_view('content', 'jobs/view', $data);
		$this->template->render();	

	}

	public function ajaxChangeStatus(){

		$texto = array(2 => 'aprovado', 3 => 'reprovado');

		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$tb = new Jobs_Model();

		$data['texto'] = $texto[$status];

		$data['check'] = $tb->changeStatus($id, $status);

		$tb->ta_id = $id;
		$job = $tb->getRow();

		if($status == 2){

			$cg = new Congressman_Model();
			$cg->cg_id = $job->cg_id;
			$cg->join('correspondencia','co_id');
			$user = $cg->getRow();

			$this->load->library('My_Email');

			$mail = new My_Email();

			$dados = array(
				'titulo' => 'Parabéns! Seu trabalho foi aprovado!',
				'nome' => $user->cg_nome,
				'mensagem' => 'Informamos que seu trabalho foi selecionado para apresentação no VI Congresso Brasileiro de Equoterapia.'
				);

			$infos = array(
				'fromName' => 'VI Congresso Brasileiro de Equoterapia',
				'to' => $user->co_email,
				'toName' => $user->cg_nome,
				'subject' => utf8_decode('Parabéns! Seu trabalho foi aprovado!'),
				'body' => $this->load->view('jobs/emailJobAccepted',$dados,true)
				);

			$data['email'] = $mail->sendEmail($infos);
		}
		echo json_encode($data);
	}

	public function ajaxEliminate(){

		$id = $this->input->post('id');
		# Co autor
		# Excluir n:m coautor trabalhos

		$interTb = new SecAuthor_Model();
		$interTb->deleteSecAuthorsAndRelationshipsByJobId($id);

		$tb = new Jobs_Model();
		$tb->ta_id = $id;
		$data['check'] = $tb->eliminate();

		echo json_encode($data);
	}
}