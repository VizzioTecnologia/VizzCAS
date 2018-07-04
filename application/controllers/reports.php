<?php
# Include the base common controller
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR. 'base.php');

class Reports extends Base{

    public function __construct(){
        parent::__construct();
    }

    public function generate($type){

        $data = array();

        switch($type){
            case 1:

                $_cg = new Subscriber_Model();
                $data['values'] = $_cg->getDistinctAreas();

                $view = 'reports/participants';
                $js = 'participants';

                break;
            case 2:

                $view = 'reports/presenters';
                $js = 'presenters';

                break;
            case 3:

                $view = 'reports/jobs';
                $js = 'jobs';

                break;
            case 4:

                $_pay = new Payment_Model();
                $data['values'] = $_pay->getDistinctValues();

                $view = 'reports/payments';
                $js = 'payments';
                break;
        }

        $this->template->write_view('content', $view, $data);
        $this->template->add_js(assets('system','js','reports/'.$js.'.js'),false);
        $this->template->render();

    }

    public function generateCsv($path, $data){

        $this->load->helper('text');

        $fileName = time().'.csv';

        $path = FCPATH.'files/reports/'.$path.'/'.$fileName;

        $fp = fopen($path, 'a+');

        $cabecalho = '';

        foreach($data['columns'] as $field => $alias){
            $cabecalho .= utf8_decode($alias).";";
        }

        fwrite($fp, $cabecalho."\n");

        $lines = '';
        if(count($data['data']) > 0){

            foreach($data['data'] as $item){
                foreach($data['columns'] as $field => $alias){

                    if($field == "pa_data_criacao"){
                        $lines .= utf8_decode(dateIsoToBr($item->{$field})).";";
                    }elseif($field == "pa_status"){

                        $statusInfo = array();
                        $statusInfo[1] = "Aguardando Pagamento";
                        $statusInfo[2] = "Em análise";
                        $statusInfo[3] = "Paga";
                        $statusInfo[4] = "Disponível";
                        $statusInfo[5] = "Em disputa";
                        $statusInfo[6] = "Devolvida";
                        $statusInfo[7] = "Cancelada";
                        $statusInfo[8] = "Pagamento Manual";
                        $statusInfo[9] = "Isento";

                        $lines .= utf8_decode($statusInfo[$item->{$field}]).";";

                    }elseif($field == "ta_aprovacao"){

                        $aprovacao = array();
                        $aprovacao[1] = "Aguardando Aprovação";
                        $aprovacao[2] = "Aprovado";
                        $aprovacao[3] = "Reprovado";

                        if($item->{$field} == NULL){
                            $lines .= utf8_decode('Trabalho Não Enviado');
                        }else{
                            $lines .= utf8_decode($aprovacao[$item->{$field}]).";";
                        }

                    }elseif($field == "ta_status"){

                        $aprovacao = array();
                        $aprovacao[1] = "Enviado";
                        $aprovacao[2] = "Rascunho";

                        if($item->{$field} == NULL){
                            $lines .= utf8_decode('Trabalho Não Enviado');
                        }else{
                            $lines .= utf8_decode($aprovacao[$item->{$field}]).";";
                        }

                    }elseif($field == "ta_prioridade_apresentacao"){

                        $aprovacao = array();
                        $aprovacao[1] = "Comunicação Oral";
                        $aprovacao[2] = "Pôster";
                        $aprovacao[3] = "Indiferente";

                        $lines .= utf8_decode($aprovacao[$item->{$field}]).";";
                    }elseif($field == "cg_doc"){

                        $this->load->helper('doc');

                        $lines .= utf8_decode(numberToDoc($item->{$field}).';');
                    }elseif($field == "co_telefone_fixo"){

                        $this->load->helper('phone');

                        $lines .= utf8_decode(numberToPhone($item->{$field}).';');

                    }elseif($field == "cg_tratamento"){

                        $tratamento[1] = "Doutor";
                        $tratamento[2] = "Doutora";
                        $tratamento[3] = "Senhor";
                        $tratamento[4] = "Senhora";
                        $lines .= utf8_decode($tratamento[$item->{$field}].';');

                    }else{
                        $lines .= utf8_decode($item->{$field}).";";
                    }
                }
                $lines .= "\n";
            }

        }

        fwrite($fp, $lines);

        fclose($fp);

        $result['file'] = $fileName;
        $result['check'] = file_exists($path);

        echo json_encode($result);

    }

    public function export($type){

        $path = '';

        parse_str($_POST['form'], $post);

        switch($type){
            case 1:
                $data = $this->participantsData($post);

                $csv = $this->generateCsv('participants', $data);
                break;
            case 2:

                $data = $this->presentersData($post);

                $csv = $this->generateCsv('presenters', $data);

                break;
            case 3:
                $data = $this->jobsData($post);

                $csv = $this->generateCsv('jobs', $data);

                break;
            case 4:
                $data = $this->financialData($post);

                $csv = $this->generateCsv('financial', $data);

                break;
        }
    }

    public function jobsData($post){

        $cg = new Jobs_Model();

        $sql = "SELECT * FROM congressista INNER JOIN trabalho ON (congressista.cg_id = trabalho.cg_id) WHERE cg_tipo = 1";

        $count = 1;

        $sql_opt = '';

        # Nome
        if(isset($post['cg_nome']) && !empty($post['cg_nome'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome LIKE '%".$post['cg_nome']."%'";

            $count++;
        }

        # Número de Inscrição
        if(isset($post['cg_numero_inscricao']) && !empty($post['cg_numero_inscricao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_numero_inscricao = '".$post['cg_numero_inscricao']."'";

            $count++;
        }

        # Prioridade de Apresentação
        if(isset($post['ta_prioridade_apresentacao']) && !empty($post['ta_prioridade_apresentacao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " ta_prioridade_apresentacao = '".$post['ta_prioridade_apresentacao']."'";

            $count++;
        }

        # Status do Trabalho
        if(isset($post['ta_aprovacao']) && !empty($post['ta_aprovacao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " ta_aprovacao = '".$post['ta_aprovacao']."'";

            $count++;
        }

        if($count > 0){
            $sql .= $sql_opt;
        }

        $data = array(
            'columns' => array(
                'cg_nome' => "Nome do Inscrito",
                'cg_numero_inscricao' => "Número de Inscrição",
                'ta_prioridade_apresentacao' => "Tipo de comunicação",
                'ta_aprovacao' => "Status de Aprovação"
            ),
            'data' => $cg->runQuery($sql)
        );

        return $data;
    }

    public function financialData($post){

        $cg = new Subscriber_Model();

        $sql = 'SELECT * FROM congressista INNER JOIN pagamento ON (pagamento.cg_id = congressista.cg_id) INNER JOIN correspondencia ON (correspondencia.co_id = congressista.co_id)';

        $count = 0;

        $sql_opt = '';

        # Nome
        if(isset($post['cg_nome']) && !empty($post['cg_nome'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome LIKE '%".$post['cg_nome']."%'";

            $count++;
        }

        # Email
        if(isset($post['co_email']) && !empty($post['co_email'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " co_email = '".$post['cg_nome']."'";

            $count++;
        }

        # Status do Pagamento
        if(isset($post['pa_status']) && !empty($post['pa_status'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            if(in_array('ALL', $post['pa_status'])){
                $sql_opt .= " pa_status IS NOT NULL";
            }else{
                $ec = 1;
                $ect = count($post['pa_status']);

                foreach($post['pa_status'] as $status){

                    if($ec == $ect){
                        $sql_opt .= " pa_status = '".$status."'";
                    }else{
                        $sql_opt .= " pa_status = '".$status."' OR";
                    }

                    $ec++;
                }
            }

            $count++;
        }

        # Valor
        $pa_valor_init = isset($post['pa_valor_init']) && !empty($post['pa_valor_init']);
        $pa_valor_end = isset($post['pa_valor_end']) && !empty($post['pa_valor_end']);

        if($pa_valor_init && $pa_valor_end){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_valor BETWEEN ".$post['pa_valor_init']." AND ".$post['pa_valor_end'];

            $count++;

        }elseif($pa_valor_init && !$pa_valor_end){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_valor > ".$post['pa_valor_init'];

            $count++;
        }elseif($pa_valor_end && !$pa_valor_init){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_valor < ".$post['pa_valor_end'];

            $count++;
        }

        $date_init = isset($post['data_init']) && !empty($post['data_init']);
        $date_end = isset($post['data_end']) && !empty($post['data_end']);

        # Data de Pagamento
        if($date_init && $date_end){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_data_criacao BETWEEN '".$post['data_init']."' AND '".$post['data_end']."'";

            $count++;

        }elseif($date_init && !$date_end){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_data_criacao > '".$post['data_init']."'";

            $count++;
        }elseif($date_end && !$date_init){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " pa_data_criacao < '".$post['data_end']."'";

            $count++;
        }

        if($count > 0){
            $sql .= ' WHERE'.$sql_opt;
        }

        $data = array(
            'columns' => array(
                'cg_nome' => "Nome do Inscrito",
                'cg_numero_inscricao' => "Número de Inscrição",
                'co_email' => "Email",
                'pa_valor' => "Valor",
                'pa_data_criacao' => "Data do Pagamento",
                'pa_status' => "Status do Pagamento"
            ),
            'data' => $cg->runQuery($sql)
        );

        return $data;
    }

    public function make($type){

        parse_str($_POST['form'], $post);

        switch($type){
            case 1:

                $data = $this->participantsData($post);

                break;
            case 2:

                $data = $this->presentersData($post);

                break;
            case 3:
                $data = $this->jobsData($post);

                break;
            case 4:
                $data = $this->financialData($post);

                break;
        }

        $html = $this->load->view('reports/table', $data, true);

        echo $html;
    }

    public function participantsData($post){

        $cg = new Subscriber_Model();

        $sql = 'SELECT * FROM congressista INNER JOIN pagamento ON (pagamento.cg_id = congressista.cg_id) INNER JOIN correspondencia ON (correspondencia.co_id = congressista.co_id) WHERE cg_tipo = 2';

        $sql_opt = '';

        $count = 1;

        # Nome
        if(isset($post['cg_nome']) && !empty($post['cg_nome'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome LIKE '%".$post['cg_nome']."%'";

            $count++;
        }

        # Nome crachá
        if(isset($post['cg_nome_cracha']) && !empty($post['cg_nome_cracha'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome_cracha LIKE '%".$post['cg_nome_cracha']."%'";

            $count++;
        }

        # Número de Inscrição
        if(isset($post['cg_numero_inscricao']) && !empty($post['cg_numero_inscricao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_numero_inscricao = '".$post['cg_numero_inscricao']."'";

            $count++;
        }

        # Documento
        if(isset($post['cg_doc']) && !empty($post['cg_doc'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_doc = '".$post['cg_doc']."'";

            $count++;
        }

        # Email
        if(isset($post['co_email']) && !empty($post['co_email'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " co_email = '".$post['co_email']."'";

            $count++;
        }

        # Telefone Fixo
        if(isset($post['co_telefone']) && !empty($post['co_telefone'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " co_telefone = '".$post['co_telefone']."'";

            $count++;
        }

        # Estado
        if(isset($post['co_estado']) && !empty($post['co_estado'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            if(in_array('ALL', $post['co_estado'])){
                $sql_opt .= " co_estado IS NOT NULL";
            }else{
                $ec = 1;
                $ect = count($post['co_estado']);

                foreach($post['co_estado'] as $estado){

                    if($ec == $ect){
                        $sql_opt .= " co_estado = '".$estado."'";
                    }else{
                        $sql_opt .= " co_estado = '".$estado."' OR";
                    }

                    $ec++;
                }
            }

            $count++;
        }

        # Estado
        if(isset($post['cg_tratamento']) && !empty($post['cg_tratamento'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_tratamento = '".$post['cg_tratamento']."'";

            $count++;
        }

        # Estado
        if(isset($post['cg_area_profissional']) && !empty($post['cg_area_profissional'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $countArea = 1;

            foreach($post['cg_area_profissional'] as $area){

                if($countArea == count($post['cg_area_profissional'])){
                    $sql_opt .= " cg_area_profissional = '".$area."'";
                }else{
                    $sql_opt .= " cg_area_profissional = '".$area."' OR";
                }

                $countArea++;
            }

            $count++;
        }

        if($count > 0){
            $sql .= $sql_opt;
        }

        $data = array(
            'columns' => array(
                'cg_nome' => "Nome do Inscrito",
                'cg_numero_inscricao' => "Número de Inscrição",
                'cg_doc' => "Documento",
                'co_email' => "Email",
                'co_telefone_fixo' => "Telefone Fixo",
                'co_estado' => "Estado (UF)",
                'cg_tratamento' => "Tratamento",
                'cg_area_profissional' => "Área de Atuação"
            ),
            'data' => $cg->runQuery($sql)
        );

        return $data;
    }

    public function presentersData($post){

        $cg = new Subscriber_Model();

        $sql = 'SELECT
                *,
                (SELECT ta_status FROM trabalho WHERE trabalho.cg_id = congressista.cg_id) as ta_status,
                (SELECT ta_aprovacao FROM trabalho WHERE trabalho.cg_id = congressista.cg_id) as ta_aprovacao
                FROM congressista
                INNER JOIN correspondencia ON (correspondencia.co_id = congressista.co_id)
                WHERE cg_tipo  = 1';

        $sql_opt = '';

        $count = 1;

        # Nome
        if(isset($post['cg_nome']) && !empty($post['cg_nome'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome LIKE '%".$post['cg_nome']."%'";

            $count++;
        }

        # Nome crachá
        if(isset($post['cg_nome_cracha']) && !empty($post['cg_nome_cracha'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_nome_cracha LIKE '%".$post['cg_nome_cracha']."%'";

            $count++;
        }

        # Número de Inscrição
        if(isset($post['cg_numero_inscricao']) && !empty($post['cg_numero_inscricao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_numero_inscricao = '".$post['cg_numero_inscricao']."'";

            $count++;
        }

        # Documento
        if(isset($post['cg_doc']) && !empty($post['cg_doc'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " cg_doc = '".$post['cg_doc']."'";

            $count++;
        }

        # Email
        if(isset($post['co_email']) && !empty($post['co_email'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " co_email = '".$post['co_email']."'";

            $count++;
        }

        # Telefone Fixo
        if(isset($post['co_telefone']) && !empty($post['co_telefone'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " co_telefone = '".$post['co_telefone']."'";

            $count++;
        }

        # Estado
        if(isset($post['co_estado']) && !empty($post['co_estado'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            if(in_array('ALL', $post['co_estado'])){
                $sql_opt .= " co_estado IS NOT NULL";
            }else{
                $ec = 1;
                $ect = count($post['co_estado']);

                foreach($post['co_estado'] as $estado){

                    if($ec == $ect){
                        $sql_opt .= " co_estado = '".$estado."'";
                    }else{
                        $sql_opt .= " co_estado = '".$estado."' OR";
                    }

                    $ec++;
                }
            }

            $count++;
        }

        # Status do Trabalho
        if(isset($post['ta_status']) && !empty($post['ta_status'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            #die(var_dump($post['ta_status']));

            # Se o ta_status == NULL
            if($post['ta_status'] == "NULL"){
                $sql_opt .= " (SELECT ta_status FROM trabalho WHERE trabalho.cg_id = congressista.cg_id) IS NULL";
            }else{
                $sql_opt .= " (SELECT ta_status FROM trabalho WHERE trabalho.cg_id = congressista.cg_id) = ".$post['ta_status'];
            }


            $count++;
        }

        # Status de Aprovação
        if(isset($post['ta_aprovacao']) && !empty($post['ta_aprovacao'])){

            if($count > 0){
                $sql_opt .= " AND";
            }

            $sql_opt .= " (SELECT ta_aprovacao FROM trabalho WHERE trabalho.cg_id = congressista.cg_id) = '".$post['ta_aprovacao']."'";

            $count++;
        }

        if($count > 0){
            $sql .= $sql_opt;
        }

        $data = array(
            'columns' => array(
                'cg_nome' => "Nome do Inscrito",
                'cg_numero_inscricao' => "Número de Inscrição",
                'cg_doc' => "Documento",
                'co_email' => "Email",
                'co_telefone_fixo' => "Telefone Fixo",
                'co_estado' => "Estado (UF)",
                'cg_tratamento' => "Tratamento",
                'cg_area_profissional' => "Área de Atuação",
                'ta_status' => "Status de Envio de Trabalho",
                'ta_aprovacao' => 'Status de Aprovação do Trabalho'
            ),
            'data' => $cg->runQuery($sql)
        );

        return $data;
    }

    public function generateFile(){

    }
}