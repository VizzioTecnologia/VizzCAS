<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Gerar Relatório de Trabalhos</header>
            <div class="panel-body">
                <div class="col-lg-4">
                    <form role="form" id="generateReport" method="POST">
                        <div class="filters">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome</label>
                                <input type="text" class="form-control" name="cg_nome" placeholder="Filtre pelo nome do inscrito (Participante ou Apresentador)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Número de inscrição</label>
                                <input type="email" class="form-control" name="cg_numero_inscricao" placeholder="Filtre pelo número de inscrição">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Tipo de comunicação</label>
                                <div class="form-group">
                                    <select class="form-control" name="ta_prioridade_apresentacao">
                                        <option value="">Selecione</option>
                                        <option value="1">Comunicação Oral</option>
                                        <option value="2">Pôster</option>
                                        <option value="3">Indiferente</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Status de Aprovação</label>
                                <select class="form-control" name="ta_aprovacao">
                                    <option value="">Selecione</option>
                                    <option value="1">Aguardando Aprovação</option>
                                    <option value="2">Aprovado</option>
                                    <option value="3">Reprovado</option>
                                </select>
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