<?php
$cabecalho = '';
$lines = '';

foreach($columns as $field => $alias){
    $cabecalho .= "<th>$alias</th>";
}

foreach($data as $item){

    $lines .= "<tr>";
    foreach($columns as $field => $alias){

        if($field == "pa_status"){

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

            $lines .= '<td>'.$statusInfo[$item->{$field}].'</td>';

        }elseif($field == "ta_aprovacao"){

            $aprovacao = array();
            $aprovacao[1] = "Aguardando Aprovação";
            $aprovacao[2] = "Aprovado";
            $aprovacao[3] = "Reprovado";

            if($item->{$field} == NULL){
                $lines .= '<td> Trabalho Não Enviado</td>';
            }else{
                $lines .= '<td>'.$aprovacao[$item->{$field}].'</td>';
            }

        }elseif($field == "ta_status"){

            $aprovacao = array();
            $aprovacao[1] = "Enviado";
            $aprovacao[2] = "Rascunho";

            if($item->{$field} == NULL){
                $lines .= '<td> Trabalho Não Enviado</td>';
            }else{
                $lines .= '<td>'.$aprovacao[$item->{$field}].'</td>';
            }

        }elseif($field == "ta_prioridade_apresentacao"){

            $aprovacao = array();
            $aprovacao[1] = "Comunicação Oral";
            $aprovacao[2] = "Pôster";
            $aprovacao[3] = "Indiferente";

            $lines .= '<td>'.$aprovacao[$item->{$field}].'</td>';
        }elseif($field == "cg_doc"){

            $this->load->helper('doc');

            $lines .= '<td>'.numberToDoc($item->{$field}).'</td>';

        }elseif($field == "co_telefone_fixo"){

            $this->load->helper('phone');

            $lines .= '<td>'.numberToPhone($item->{$field}).'</td>';

        }elseif($field == "cg_tratamento"){

            $tratamento[1] = "Doutor";
            $tratamento[2] = "Doutora";
            $tratamento[3] = "Senhor";
            $tratamento[4] = "Senhora";

            $lines .= '<td>'.$tratamento[$item->{$field}].'</td>';
        }else{
            $lines .= '<td>'.$item->{$field}.'</td>';
        }


    }
    $lines .= "</tr>";
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <?php echo $cabecalho; ?>
        </tr>
    </thead>
    <tbody>
    <?php echo $lines; ?>
    </tbody>
</table>