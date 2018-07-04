<?php
if($_SESSION[$hash]['user']->ut_id != 3):
?>
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol red">
				<i class="fa fa-users"></i>
			</div>
			<div class="value">
				<h1 class="count">
					<?php echo $countParticipantes; ?>
				</h1>
				<p>Total de Participantes</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol terques">
				<i class="fa fa-users"></i>
			</div>
			<div class="value">
				<h1 class=" count2">
					<?php echo $countApresentadores; ?>
				</h1>
				<p>Total de Apresentadores</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol yellow">
				<i class="fa fa-dollar"></i>
			</div>
			<div class="value">
				<h1 class=" count3">
					0
				</h1>
				<p>Total Arrecadado</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol yellow">
				<i class="fa fa-dollar"></i>
			</div>
			<div class="value">
				<h1 class="count7">
					0
				</h1>
				<p>Total Arrecadado Disponível</p>
			</div>
		</section>
	</div>

</div>
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol red">
				<i class="fa fa-users"></i>
			</div>
			<div class="value">
				<h1 class="count8">
					0
				</h1>
				<p>Total de Participantes que já Pagaram</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol blue">
				<i class="fa fa-file-text"></i>
			</div>
			<div class="value">
				<h1 class=" count4">
					0
				</h1>
				<p>Total de Trabalhos</p>
			</div>
		</section>
	</div>

	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol blue">
				<i class="fa fa-file-text"></i>
			</div>
			<div class="value">
				<h1 class=" count5">
					0
				</h1>
				<p>Total de Trabalhos Aprovados</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol blue">
				<i class="fa fa-file-text"></i>
			</div>
			<div class="value">
				<h1 class=" count6">
					0
				</h1>
				<p>Total de Trabalhos Reprovados</p>
			</div>
		</section>
	</div>
	
</div>
<script>
var countApresentadores = <?php echo $countApresentadores; ?>;
var countParticipantes = <?php echo $countParticipantes; ?>;
var countPayment = <?php echo $countPayment; ?>;
var countJobs = <?php echo $countJobs; ?>;
var countJobsAccepted = <?php echo $countJobsAccepted; ?>;
var countJobsDenied = <?php echo $countJobsDenied; ?>; 
var countPaymentDone = <?php echo $countPaymentDone; ?>; 
var countParticipantsPayed = <?php echo $countParticipantsPayed; ?>;
</script>
<?php else: ?>
    <div class="row state-overview"><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
<?php endif; ?>