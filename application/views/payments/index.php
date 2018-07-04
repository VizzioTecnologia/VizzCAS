<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Lista de Pagamentos</header>
			<div class="panel-body">
				<div class="adv-table">
					<table id="lista-pagamentos" class="display table table-striped">
						<thead>
							<tr>
								<th width="">ID</th>
								<th width="8%">Referência</th>
								<th width="">Congressista</th>
								<th width="">Valor</th>
								<th width="15%">Data/Hora</th>
								<th width="">Status</th>
								<th width="13%">Tipo de Pagamento</th>																							
								<th width="8%"></th>																							
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="5" class="dataTables_empty">Carregando dados do servidor</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th width="">ID</th>
								<th width="">Referência</th>
								<th width="">Congressista</th>
								<th width="">Valor</th>
								<th width="">Data/Hora</th>
								<th width="">Status</th>
								<th width="">Tipo de Pagamento</th>																							
								<th width=""></th>			
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- Enviar novo valor de pagamento -->
<div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Alteração de Valor</h4>
			</div>
			<div class="modal-body">
                <div class="form-group col-lg-6">
                    <input type="text" class="form-control" name="new_value" placeholder="Digite o novo valor a ser pago" data-mask="999.99">
                </div>
                <br>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-warning confirm" type="button">Enviar com novo valor</button>
				<button class="btn btn-success confirm-default-value" type="button">Enviar com o valor original</button>
			</div>
		</div>
	</div>
</div>

<!-- Troca de Status -->
<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alteração de Status</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Novo Status</label>
                    <div class="col-lg-7">
                        <select class="form-control m-bot15" name="new-status">
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
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-success confirm-new-status" type="button">Mudar o status do pagamento</button>
            </div>
        </div>
    </div>
</div>