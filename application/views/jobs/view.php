<div class="row">

	<?php 
		if($job->ta_aprovacao != 1){
			$texto = array(2 => 'aprovado', 3 => 'reprovado');
	?>
	<div class='col-lg-12'>
		<h3>Este trabalho já foi <?php echo $texto[$job->ta_aprovacao] ?></h3>
	</div>
	<?php } ?>

	<div class="col-lg-4">
		<input type="hidden" name="id" value="<?php echo $job->ta_id; ?>">
		<section class="panel">
			<header class="panel-heading">
				Título
			</header>
			<div class="panel-body">
				<?php echo $job->ta_titulo; ?>
			</div>
		</section>	

		<section class="panel">
			<header class="panel-heading">
				Autor e Co-Autores
			</header>
			<div class="panel-body">
				<h4>Autor</h4>
				<?php echo $job->cg_nome; ?>
				<h4>Co-Autores</h4>
				<?php
					if(count($secAuthors) > 0){

						foreach($secAuthors as $sec){
							echo $sec['ca_nome']."<br>";
						}

					}
				?>
			</div>
		</section>	
		<section class="panel">
			<div class="panel-body">				
				<button type="button" class="btn btn-shadow btn-default btn-3">Imprimir Trabalho</button>

				<div class="hideAuthorInfos" style="display:inline;margin-top:10px; float:right;">
					<input type="checkbox" name="option-print" value="1"> <label style="display: inline;font-weight: normal">Esconder dados do autor da Impressão</label>
				</div>

			</div>
		</section>
	</div>

	<div class="col-lg-8">

		<section class="panel">
			<header class="panel-heading">
				Resumo
			</header>
			<div class="panel-body">
				<h4>
					<?php echo $job->ta_texto; ?>
				</h4>
				<?php
					$opt = ($job->ta_aprovacao != 1) ? "disabled" : "";
				?>
				<button type="button" class="btn btn-shadow btn-success btn-1" <?php echo $opt ?>>Aprovar</button>
				<button type="button" class="btn btn-shadow btn-danger btn-2" <?php echo $opt ?>>Reprovar</button>
			</div>
		</section>
	</div>
</div>

<!-- Confirmação envio link -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirmação</h4>
			</div>
			<div class="modal-body">
				Tem certeza que deseja <span id="type"></span> este trabalho?
				<input type="hidden" name="operation">
			</div>
			<div class="modal-footer">
				<button class="btn btn-success confirm" type="button">Sim</button>
				<button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Não</button>
			</div>
		</div>
	</div>
</div>