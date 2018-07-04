<?php
$prioridade = array( 1 => 'Comunicação Oral', 2 => 'Pôster', 3 => 'Indiferente');

$count = count($jobs);
$i = 0;

foreach($jobs as $job):
?>

<div class="header">
    <span style='font-size:12.0pt;line-height:115%'>DADOS PESSOAIS</span>
</div>

<?php 

if($hideAuthorInfos == 'false'){
?>

<table width="100%">
    <tr>
        <td class="inscricao">INSCRIÇÃO: <?php echo $job->cg_numero_inscricao ?></td>
        <td>AUTOR: <?php echo $job->cg_nome; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            CO-AUTORES:
            <br>
            <br>
            <?php 
            foreach($coautores as $ca){
                echo $ca['ca_nome']."<br>";
            }
            ?>
        </td>
    </tr>
</table>

<?php  
}else{
?>

<table width="100%">
    <tr>
        <td class="inscricao">INSCRIÇÃO: <?php echo $job->cg_numero_inscricao ?></td>
    </tr>
</table>

<?php
}
?>

<table width="100%">
    <tr>
        <td>TITULO: <?php echo $job->ta_titulo ?></td>
    </tr>
    <tr>
        <td>
            RESUMO:
            <br>
            <br>
            <?php echo $job->ta_texto ?>
        </td>
    </tr>
    <tr>
        <td>PRIORIDADE DO AUTOR: <?php echo $prioridade[$job->ta_prioridade_apresentacao] ?></td>
    </tr>
</table>

<div class="header">
    <span style='font-size:12.0pt;line-height:115%'>RESULTADO DA ANÁLISE</span>
</div>

<table width="100%">
    <tr>
        <td>NÃO INDICADO: </td>
        <td>INDICADO: </td>
        <td>COMUNICAÇÃO: </td>
        <td>PÔSTER: </td>
    </tr>
    <tr>
        <td colspan="4">
            OBSERVAÇÃO:
            <br><br><br><br><br><br>
        </td>
    </tr>
    <tr>
        <td>
           DATA:
        </td>
        <td colspan="3" class="assinatura">
            ASSINATURA:
        </td>
    </tr>
</table>

<?php
$i++;

if($i < $count){
    echo "<pagebreak />";
}
endforeach;
?>