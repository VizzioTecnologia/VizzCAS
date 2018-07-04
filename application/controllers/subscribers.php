<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Subscribers extends Base{

	public function __construct(){
		parent::__construct();
	}

	public function participants(){

		$data = array();

		$this->template->add_js(assets('system','js','subscribers/participants.js'),false);
		$this->template->write_view('content', 'subscribers/participants', $data);
		$this->template->render();

	}	

	public function presenters(){

		$data = array();

		$this->template->add_js(assets('system','js','subscribers/presenters.js'),false);
		$this->template->write_view('content', 'subscribers/presenters', $data);
		$this->template->render();

	}

	public function ajaxDataTableParticipants(){

		$this->load->library('Datatables');

		$this->datatables->select('cg_id, cg_numero_inscricao, cg_nome, cg_doc, co_telefone_fixo, co_telefone_celular, co_email');

		$this->datatables->from('congressista');

		$this->datatables->where('cg_tipo = 2');

		$this->datatables->join('correspondencia', 'congressista.co_id = correspondencia.co_id', 'left');

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-manage tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Gerenciar Cadastro"><i class="fa fa-pencil"></i></button>&nbsp;<button class="btn btn-danger btn-xs btn-delete tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Excluir Cadastro"><i class="fa fa-trash-o"></i></button>&nbsp;<button class="btn btn-primary btn-xs btn-print tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Cadastro"><i class="fa fa-print"></i></button>', 'cg_id');

		$result = $this->datatables->generate('json');

		echo $result;

	}	

	public function ajaxDataTablePresenters(){

		$this->load->library('Datatables');

		$this->datatables->select('cg_id, cg_numero_inscricao, cg_nome, cg_doc, co_telefone_fixo, co_telefone_celular, co_email');

		$this->datatables->from('congressista');

		$this->datatables->where('cg_tipo = 1');

		$this->datatables->join('correspondencia', 'congressista.co_id = correspondencia.co_id', 'left');

		$this->datatables->add_column('edit', '<button class="btn btn-primary btn-xs btn-manage tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Gerenciar Cadastro"><i class="fa fa-pencil"></i></button>&nbsp;<button class="btn btn-danger btn-xs btn-delete tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Excluir Cadastro"><i class="fa fa-trash-o"></i></button>&nbsp;<button class="btn btn-primary btn-xs btn-print tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Cadastro"><i class="fa fa-print"></i></button>&nbsp;<button class="btn btn-primary btn-xs btn-send-link tooltips" data-id="$1" data-placement="top" data-toggle="tooltip" data-original-title="Criar link de pagamento"><i class="fa fa-envelope"></i></button>', 'cg_id');

		$result = $this->datatables->generate('json');

		echo $result;

	}

    public function ajaxPdf(){

        $this->load->helper('text');
        $this->load->helper('date');
        $this->load->helper('doc');
        $this->load->helper('phone');
        $this->load->library('mpdf/mpdf');

        $_cg = new Subscriber_Model();
        $_cg->cg_id = $this->input->post('id');
        $_cg->join('correspondencia','co_id');
        $dados['subs'] = $_cg->getRow();

        $sexo = array(1 => "MASCULINO", 2 => "FEMININO");

        $tratamento = array(1 => "DOUTOR", 2 => "DOUTORA", 3 => "SENHOR", 4 => "SENHORA");

        $dados['subs']->cg_sexo = $sexo[$dados['subs']->cg_sexo];
        $dados['subs']->cg_tratamento = $tratamento[$dados['subs']->cg_tratamento];
        $dados['subs']->co_telefone_fixo = numberToPhone($dados['subs']->co_telefone_fixo);
        $dados['subs']->co_telefone_celular = numberToPhone($dados['subs']->co_telefone_celular);
        $dados['subs']->co_cep = numberToCep($dados['subs']->co_cep);
        $dados['subs']->cg_data_nascimento = dateIsoToBrSimple($dados['subs']->cg_data_nascimento);
        $dados['subs']->cg_doc = numberToDoc($dados['subs']->cg_doc);

        $html = $this->load->view('subscribers/pdf', $dados, true);

        $stylesheet = file_get_contents(FCPATH.'assets/system/css/pdf.css');

        $mpdf= new mPDF();
        $mpdf->WriteHTML($stylesheet,1);

        $mpdf->WriteHTML($html);

        if(count($dados['subs']) == 1){
            $fileName = sanitizeFileName($dados['subs']->cg_nome).'_'.time().'.pdf';
            // trabalho_fulana_de_tal_timestamp
        }else{
            // relatorio_trabalhos_dia_mes_ano_timestamp
        }

        $pathFile = FCPATH.'files/subscribers/'.$fileName;

        $mpdf->Output($pathFile);

        $data['file'] = $fileName;

        echo json_encode($data);
    }

	public function manage($type = null, $id = null){

		$data = array();

        $_sub = new Subscriber_Model();
        $_sub->cg_id = $id;
        $data['subscriber'] = $_sub->getRow();

        $this->load->helper('date');
        $this->load->helper('doc');
        $data['subscriber']->cg_data_nascimento = dateIsoToBrSimple($data['subscriber']->cg_data_nascimento);
        $data['subscriber']->cg_doc = numberToDoc($data['subscriber']->cg_doc);

        $_co = new Contact_Model();
        $_co->co_id = $data['subscriber']->co_id;
        $data['contact'] = $_co->getRow();

        $this->load->helper('phone');
        $data['contact']->co_telefone_fixo = numberToPhone($data['contact']->co_telefone_fixo);
        $data['contact']->co_telefone_celular = numberToPhone($data['contact']->co_telefone_celular);
        $data['contact']->co_cep = numberToCep($data['contact']->co_cep);

	    $this->template->write_view('content', 'subscribers/manage', $data);
		$this->template->add_js(assets('system','js','subscribers/manage.js'),false);
		$this->template->render();

	}

    public function ajaxUpdate(){

        $form = array();

        $tmp = $this->input->post('form');

        parse_str($tmp, $form);

        $_cg = new Subscriber_Model();
        $_cg->extractAndSetSimple($form);

        $this->load->helper('doc');
        # Doc
        $_cg->cg_doc = clearDoc($_cg->cg_doc);

        $this->load->helper('date');
        # Data Nascimento
        $_cg->cg_data_nascimento = dateBrToIso($_cg->cg_data_nascimento);

        $checkCg = $_cg->updateSpecifiedData();

        $_co = new Contact_Model();
        $_co->extractAndSetSimple($form);

        # Cep
        $_co->co_cep = clearDoc($_co->co_cep);

        # Telefone Celular
        # Telefone Fixo
        $this->load->helper('phone');
        $_co->co_telefone_fixo = phoneToNumber($_co->co_telefone_fixo);
        $_co->co_telefone_celular = phoneToNumber($_co->co_telefone_celular);

        $checkCo = $_co->updateSpecifiedData();

        if($checkCg && $checkCo){
            $result['check'] = true;
        }else{
            $result['check'] = false;
        }

        echo json_encode($result);

    }

    public function ajaxDelete(){

        $id = $this->input->post('id');

        $_u = new Subscriber_Model();
        $_u->cg_id = $id;
        $user = $_u->getRow();

        $co_id = $_u->co_id;

        # 1 - Apresentadores
        # 2 - Participantes
        if($user->cg_tipo == 1){

            $_job = new Jobs_Model();
            $_job->cg_id = $user->cg_id;
            $job = $_job->getRow();

            if($job != NULL){
                # Excluir os co autores e relacionamentos
                $_sec = new SecAuthor_Model();
                $_sec->deleteSecAuthorsAndRelationshipsByJobId($job->ta_id);

                # Excluir o trabalho
                $_job->eliminate();
            }

            # Excluir o usuário
            $_u->eliminate();

            # Excluir a correspondencia
            $_co = new Contact_Model();
            $_co->co_id = $co_id;
            $_co->eliminate();

        }else{

            # Elimina o pagamento e os logs
            $_pay = new Payment_Model();
            $_pay->cg_id = $id;
            $_pay->eliminate();

            # Elimina o usuário
            $_u->eliminate();

            # Excluir a correspondencia
            $_co = new Contact_Model();
            $_co->co_id = $co_id;
            $_co->eliminate();

        }

        echo json_encode(array('check' => true));
    }

    public function ajaxCreatePayment(){

        $this->load->helper('date');

        $sendEmail = $this->input->post('email');

        $cg_id = $this->input->post('id');
        $newValue = "300.00";

        $cg = new Subscriber_Model();
        $cg->cg_id = $cg_id;
        $_info = $cg->getRow();

        $contact = new Contact_Model();
        $contact->co_id = $_info->co_id;
        $_con = $contact->getRow();

        $url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

        # Informações da Conta do Pagseguro do vendedor
        $data['email'] = '';
        $data['token'] = '';

        # Pagseguro
        # Moeda utilizada
        $data['currency'] = 'BRL';

        # Item a ser vendido
        $data['itemId1'] = 4;
        $data['itemDescription1'] = utf8_decode('Inscrição Especial do Participante para o VI Congresso Brasileiro de Equoterapia');

        $data['itemAmount1'] = $newValue;

        $data['itemQuantity1'] = '1';
        $data['itemWeight1'] = '0';

        # Referência
        $data['reference'] = $_info->cg_numero_inscricao;
        $data['maxAge'] = 604800;

        # Informações do cliente que está comprando
        $telefone = $this->clearNumber($_con->co_telefone_celular);

        $data['senderName'] = $_info->cg_nome;
        $data['senderAreaCode'] = substr($telefone,0,2);
        $data['senderPhone'] = substr($telefone,2,9);
        $data['senderEmail'] = $_con->co_email;
        $data['senderCPF'] = $_info->cg_doc;
        $data['senderBornDate'] = dateIsoToBrSimple($_info->cg_data_nascimento);


        $data['shippingType'] = '3';
        $data['shippingAddressStreet'] = '';
        $data['shippingAddressNumber'] = '';
        $data['shippingAddressComplement'] = '';
        $data['shippingAddressDistrict'] = '';
        $data['shippingAddressPostalCode'] = $this->clearNumber($_con->co_cep);
        $data['shippingAddressCity'] = '';
        $data['shippingAddressState'] = '';
        $data['shippingAddressCountry'] = '';

        # Url que o pagseguro envia de volta o usuário após a compra
        # $data['redirectURL'] = get_bloginfo('site_url').'/obrigado-por-participar-do-congresso';

        $data = http_build_query($data);

        # Envia o post para o pagseguro
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $xml= curl_exec($curl);

        $check = 2;

        if($xml == 'Unauthorized'){

            $check = 0;

            # Insira seu código de prevenção a erros
            #die(var_dump('xml não autorizado'));
            #header('Location: erro.php?tipo=autenticacao');
            #exit;//Mantenha essa linha
        }

        curl_close($curl);

        $xml= simplexml_load_string($xml);

        if(count($xml -> error) > 0){

            die(var_dump($xml->error));
            #Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.
            $check = 1;
            $checkMail = false;
            #header('Location: erro.php?tipo=dadosInvalidos');
            //exit;
        }

        $link_pagseguro = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code;

        if($check == 2){

            $_np = new Payment_Model();
            $_np->pa_tipo = 4;

            $_np->pa_valor = $newValue;
            $_np->pa_status = 1;
            $_np->pa_data_criacao = date('Y-m-d H:i:s');
            $_np->pa_data_pagamento = "0000-00-00 00:00:00";
            $_np->pa_referencia	= $_info->cg_numero_inscricao;
            $_np->cg_id = $_info->cg_id;

            # Inclui o pagamento novo
            $_np->insertData();

            if($sendEmail == "true"){
                # Send Email
                $this->load->library('My_PHPMailer');

                $mail = new PHPMailer;

                $mail->Charset = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = '';
                $mail->SMTPAuth = true;
                $mail->Username = '';
                $mail->Password = '';
                $mail->Port = 587;

                $mail->From = '';
                $mail->FromName = '';
                $mail->addAddress($_con->co_email, $_info->cg_nome);

                $mail->isHTML(true);

                $dados = array('mensagem' => "Seu link de pagamento foi gerado. Para realizar o pagamento, clique no link abaixo.", 'titulo' => "Link de Pagamento", 'link' => $link_pagseguro,'nome' => $_info->cg_nome);

                $mail->Subject = utf8_decode("Novo link de pagamento");
                $mail->Body = $this->load->view('payments/email', $dados, true);

                if (!$mail->send()) {
                    $checkMail =  false;
                } else {
                    $checkMail = true;
                }
            }else{
                $checkMail = false;
            }
        }

        echo json_encode(array('check' => $check, 'link' => $link_pagseguro, 'checkEmail' => $checkMail));

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
}
