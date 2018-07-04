<div class="row">
    <form role="form" id="subscriber">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Informações Básicas
                </header>

                <div class="panel-body">

                    <input type="hidden" name="cg_id" value="<?php echo $subscriber->cg_id; ?>">
                    <input type="hidden" name="cg_tipo" value="<?php echo $subscriber->cg_tipo; ?>">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_nome" value="<?php echo $subscriber->cg_nome; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Número de Inscrição</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="cg_numero_inscricao" readonly value="<?php echo $subscriber->cg_numero_inscricao; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Documento</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_doc" value="<?php echo $subscriber->cg_doc; ?>" data-mask="999.999.999-99">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Data de Nascimento</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_data_nascimento" value="<?php echo $subscriber->cg_data_nascimento; ?>" data-mask="99/99/9999">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Sexo</label>
                        <select id="sexo" name="cg_sexo" class="form-control">
                            <option <?php echo ($subscriber->cg_sexo == 1)? "selected" : ""; ?> value="1">Masculino</option>
                            <option <?php echo ($subscriber->cg_sexo == 2)? "selected" : ""; ?> value="2">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Nacionalidade</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_nacionalidade" value="<?php echo $subscriber->cg_nacionalidade; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Área Profissional</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_area_profissional" value="<?php echo $subscriber->cg_area_profissional; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Instituição</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_instituicao" value="<?php echo $subscriber->cg_instituicao; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Tratamento</label>
                        <select id="tratamento" name="cg_tratamento" class="form-control">
                            <option <?php echo ($subscriber->cg_tratamento == 1)? "selected" : ""; ?> value="1">Doutor</option>
                            <option <?php echo ($subscriber->cg_tratamento == 2)? "selected" : ""; ?> value="2">Doutora</option>
                            <option <?php echo ($subscriber->cg_tratamento == 3)? "selected" : ""; ?> value="3">Senhor</option>
                            <option <?php echo ($subscriber->cg_tratamento == 4)? "selected" : ""; ?> value="4">Senhora</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Nome no Crachá</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cg_nome_cracha" value="<?php echo $subscriber->cg_nome_cracha; ?>">
                    </div>

                    <?php if($subscriber->cg_tipo == 1){
                    ?>
                        <div class="form-group">
                            <label for="exampleInputFile">Formação</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="cg_formacao" value="<?php echo $subscriber->cg_formacao; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Especialização</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="cg_especializacao" value="<?php echo $subscriber->cg_especializacao; ?>">
                        </div>
                    <?php
                    }?>

                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Informações de Contato
                </header>
                <div class="panel-body">
                    <input type="hidden" name="co_id" value="<?php echo $contact->co_id; ?>">
                    <div class="form-group">
                        <label for="inputEmail1">Estado</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_estado" value="<?php echo $contact->co_estado; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword1">Cidade</label>
                        <input type="text" class="form-control" id="inputPassword1" name="co_cidade" value="<?php echo $contact->co_cidade; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Bairro</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_bairro" value="<?php echo $contact->co_bairro; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Endereço</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_endereco" value="<?php echo $contact->co_endereco; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">CEP</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_cep" value="<?php echo $contact->co_cep; ?>" data-mask="99.999-999">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Email</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_email" value="<?php echo $contact->co_email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" >Telefone Fixo</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_telefone_fixo" value="<?php echo $contact->co_telefone_fixo; ?>" data-mask="+99 (99) 9999-9999">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1">Telefone Celular</label>
                        <input type="text" class="form-control" id="inputEmail1" name="co_telefone_celular" value="<?php echo $contact->co_telefone_celular; ?>" data-mask="+99 (99) 9999-9999?9">
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-body">
                    <button type="submit" class="btn btn-success btn-update">Salvar</button>
                    <button type="button" class="btn btn-default btn-back" onclick="history.back();">Voltar</button>
                </div>
            </section>

        </div>
    </form>
</div>