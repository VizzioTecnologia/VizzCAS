<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">

			<header class="panel-heading">
				Histórico de pagamento
				<span class="tools pull-right">
				</span>
			</header>

			<div class="panel-body profile-activity">
				
				<div class="activity terques">
					<span>
						<i class="fa fa-shopping-cart"></i>
					</span>
					<div class="activity-desk">
						<div class="panel">
							<div class="panel-body">
								<div class="arrow"></div>
								<i class=" fa fa-clock-o"></i>
								<h4><?php echo dateIsoToBr($payment->pa_data_criacao); ?></h4>
								<p>Link de pagamento do Pagseguro foi gerado</p>
							</div>
						</div>
					</div>
				</div>

				<?php
					$colors = array('purple', 'terques', 'blue', 'green');

					$statusInfo[1] = "Aguardando Pagamento";
					$statusInfo[2] = "Em análise";
					$statusInfo[3] = "Paga";
					$statusInfo[4] = "Disponível";
					$statusInfo[5] = "Em disputa";
					$statusInfo[6] = "Devolvida";
					$statusInfo[7] = "Cancelada";

					$alt = 0;
					if(count($notifications) > 0){
						foreach($notifications as $not){

						$colorRand = rand(0,3);
					?>

							<div class="activity <?php echo ($alt ==0)? "alt" : ""; ?> <?php echo $colors[$colorRand]; ?>">
								<span>
									<i class="fa fa-shopping-cart"></i>
								</span>
								<div class="activity-desk">
									<div class="panel">
										<div class="panel-body">
											<div class="arrow-alt"></div>
											<i class=" fa fa-clock-o"></i>
											<h4><?php echo dateIsoToBr($not->np_data_hora); ?></h4>
											<p>O Pagseguro alterou o status do pagamento automaticamente para: <?php echo $statusInfo[$not->np_status]; ?> </p>
										</div>
									</div>
								</div>
							</div>

					<?php
							if($alt == 0){
								$alt++;
							}else{
								$alt = 0;
							}
						}
					}
				?>
			</div>
		</section>
	</div>
</div>