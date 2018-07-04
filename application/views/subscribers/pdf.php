<meta charset="utf-8">

<div class="header">
    <span style='font-size:12.0pt;line-height:115%'>DADOS PESSOAIS</span>
</div>

<table width="100%">
    <tr>
        <td colspan="2" class="inscricao">NOME: <?php echo $subs->cg_nome;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">NOME NO CRACHÁ: <?php echo $subs->cg_nome_cracha;?></td>
    </tr>
    <tr>
        <td class="inscricao">NÚMERO DE INSCRIÇÃO: <?php echo $subs->cg_numero_inscricao;?></td>
        <td class="inscricao">DOC: <?php echo $subs->cg_doc;?></td>

    </tr>
    <tr>
        <td class="inscricao">DATA DE NASCIMENTO: <?php echo $subs->cg_data_nascimento;?></td>
        <td class="inscricao">SEXO: <?php echo $subs->cg_sexo;?></td>
    </tr>
    <tr>
        <td class="inscricao">NACIONALIDADE: <?php echo $subs->cg_nacionalidade;?></td>
        <td class="inscricao">TRATAMENTO: <?php echo $subs->cg_tratamento;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">ÁREA PROFISSIONAL: <?php echo $subs->cg_area_profissional;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">INSTITUIÇÃO: <?php echo $subs->cg_instituicao;?></td>
    </tr>
    <?php if($subs->cg_tipo == 1): ?>
    <tr>
        <td colspan="2" class="inscricao">FORMAÇÃO: <?php echo $subs->cg_formacao;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">ESPECIALIZAÇÃO: <?php echo $subs->cg_especializacao;?></td>
    </tr>
    <?php endif; ?>
</table>

<div class="header">
    <span style='font-size:12.0pt;line-height:115%'>DADOS DE CONTATO</span>
</div>

<table width="100%">
    <tr>
        <td class="inscricao">ESTADO: <?php echo $subs->co_estado;?></td>
        <td class="inscricao">CIDADE: <?php echo $subs->co_cidade;?></td>
    </tr>
    <tr>
        <td class="inscricao">BAIRRO: <?php echo $subs->co_bairro;?></td>
        <td class="inscricao">CEP: <?php echo $subs->co_cep;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">ENDEREÇO: <?php echo $subs->co_endereco;?></td>
    </tr>
    <tr>
        <td colspan="2" class="inscricao">EMAIL: <?php echo $subs->co_email;?></td>
    </tr>
    <tr>
        <td class="inscricao">TELEFONE FIXO: <?php echo $subs->co_telefone_fixo;?></td>
        <td class="inscricao">TELEFONE CELULAR: <?php echo $subs->co_telefone_celular;?></td>
    </tr>
</table>