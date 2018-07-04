<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Gerar Relatório de Apresentadores</header>
            <div class="panel-body">
                <div class="col-lg-4">
                    <form role="form" id="generateReport" method="POST">
                        <div class="filters">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Número de inscrição</label>
                                <input type="email" class="form-control" name="cg_numero_inscricao" placeholder="Filtre pelo número de inscrição">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome</label>
                                <input type="text" class="form-control" name="cg_nome" placeholder="Filtre pelo nome do inscrito (Apresentador)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome para crachá</label>
                                <input type="text" class="form-control" name="cg_nome_cracha" placeholder="Filtre pelo nome do crachá do inscrito (Apresentador)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Documento</label>
                                <input type="email" class="form-control" name="cg_doc" placeholder="Filtre pelo documentos (Somente Números)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" class="form-control" name="co_email" placeholder="Filtre pelo email">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Telefone Fixo</label>
                                <input type="email" class="form-control" name="co_telefone" placeholder="Filtre pelo telefone (Somente Números)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">UF</label>
                                <select name="co_estado[]" class="multi-select" multiple id="my_multi_select" style="position: absolute; left: -9999px;">
                                    <option value="ALL">Todos</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AM">AM</option>
                                    <option value="AP">AP</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MG">MG</option>
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="PR">PR</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="RS">RS</option>
                                    <option value="SC">SC</option>
                                    <option value="SE">SE</option>
                                    <option value="SP">SP</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Situação de Envio do Trabalho</label>
                                <div class="form-group">
                                    <select class="form-control" name="ta_status">
                                        <option value="">Selecione</option>
                                        <option value="NULL">Não Enviado</option>
                                        <option value="2">Rascunho</option>
                                        <option value="1">Enviado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status de Aprovação do Trabalho</label>
                                <div class="form-group">
                                    <select name="ta_aprovacao" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="1">Aguardando Aprovação</option>
                                        <option value="2">Aprovado</option>
                                        <option value="3">Reprovado</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group" style="margin-top: 50px;">
                                <button type="submit" class="btn btn-info btn-generate">Gerar Relatório</button>
                                <button type="button" class="btn btn-info btn-export">Exportar em Excel</button>
                                <!--<button type="button" class="btn btn-default btn-hide-filters">Esconder os Filtros</button>-->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>

                <div class="col-lg-12 html" style="display:none">

                </div>
            </div>
        </section>
    </div>
</div>