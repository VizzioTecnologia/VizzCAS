<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Lista de Participantes</header>
			<div class="panel-body">
				<div class="adv-table">
					<table id="lista-apresentadores" class="display table table-striped">
						<thead>
							<tr>
								<th width="8%">ID</th>
								<th width="8%">Nº Inscrição</th>
								<th width="">Nome</th>
								<th width="10%">Documento</th>
								<th width="10%">Telefone Fixo</th>
								<th width="12%">Telefone Celular</th>
								<th width="">Email</th>
								<th width=""></th>																							
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
								<th width="">Número de Inscrição</th>
								<th width="">Nome</th>
								<th width="">Documento</th>
								<th width="">Telefone Fixo</th>
								<th width="">Telefone Celular</th>
								<th width="">Email</th>
								<th width=""></th>		
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>


<!-- Exclusão do participante -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmação</h4>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este participante?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Não</button>
                <button class="btn btn-success confirm" type="button">Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- Enviar novo valor de pagamento -->
<div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmação</h4>
            </div>
            <div class="modal-body">
                Tem certeza que deseja criar um link de pagamento para este apresentador?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Não</button>
                <button class="btn btn-success confirm-link" type="button">Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- Enviar novo valor de pagamento -->
<div class="modal fade" id="modal-check-email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmação de EMAIL</h4>
            </div>
            <div class="modal-body">
                Deseja enviar o link de pagamento para o apresentador?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger without-email" type="button">Não</button>
                <button class="btn btn-success with-email" type="button">Sim</button>
            </div>
        </div>
    </div>
</div>