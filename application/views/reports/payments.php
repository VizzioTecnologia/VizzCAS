<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Gerar Relatório de Pagamento</header>
            <div class="panel-body">
                <div class="col-lg-4">
                    <form role="form" id="generateReport" method="POST">
                        <div class="filters">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome</label>
                                <input type="text" class="form-control" name="cg_nome" placeholder="Filtre pelo nome do inscrito (Participante ou Apresentador)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" class="form-control" name="co_email" placeholder="Filtre pelo email do inscrito (Participante ou Apresentador)">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">Situação do Pagamento</label>
                                <div class="form-group">
                                    <select name="pa_status[]" class="multi-select" multiple id="my_multi_select" style="position: absolute; left: -9999px;">
                                        <!--<option value="ALL">Todos</option>-->
                                        <optgroup label="Status do Pagseguro">
                                            <option value="1">Aguardando Pagamento</option>
                                            <option value="2">Em análise</option>
                                            <option value="3">Paga</option>
                                            <option value="4">Disponível</option>
                                            <option value="5">Em disputa</option>
                                            <option value="6">Devolvida</option>
                                            <option value="7">Cancelada</option>
                                        </optgroup>
                                        <optgroup label="Status do Sistema">
                                            <option value="8">Pagamento Manual</option>
                                            <option value="9">Isento</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <?php
                            $v = '';
                            foreach($values as $value){
                                $v .= "<option value='".$value->pa_valor."'>".$value->pa_valor."</option>";
                            }
                            ?>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Valor</label>
                                <select class="form-control" name="pa_valor_init">
                                    <option value="">Valor Inicial</option>
                                    <?php echo $v; ?>
                                </select>
                                <br>
                                <select class="form-control" name="pa_valor_end">
                                    <option value="">Valor Final</option>
                                    <?php echo $v; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Data de Pagamento</label>
                                <input type="date" class="form-control" name="data_init" placeholder="Data Inicial">
                                <br>
                                <input type="date" class="form-control" name="data_end" placeholder="Data Final">
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 50px;">
                            <button type="submit" class="btn btn-info btn-generate">Gerar Relatório</button>
                            <button type="button" class="btn btn-info btn-export">Exportar em Excel</button>
                            <!--<button type="button" class="btn btn-default btn-hide-filters">Esconder os Filtros</button>-->
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