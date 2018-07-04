<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading">
			Conversa com <?php echo $initQuestion->du_nome;?>
		</header>
		<div class="panel-body">
			<div class="timeline-messages">

				<!-- Comment -->
				<div class="msg-time-chat">
					<a class="message-img" href="#"><img alt="" src="<?php echo $url; ?>assets/system/img/fc-usuario.jpg" class="avatar"></a>
					<div class="message-body msg-in">
						<span class="arrow"></span>
						<div class="text">
							<p class="attribution"><a href="#"><?php echo $initQuestion->du_nome; ?></a>em <?php echo dateIsoToBr($initQuestion->du_data_hora); ?></p>
							<h5><?php echo $initQuestion->du_assunto; ?></h5>
							<p><?php echo $initQuestion->du_mensagem; ?></p>
						</div>
					</div>
				</div>
				
				<?php 
					foreach($answers as $answer){

						if($answer->re_tipo == 1){
						?>

						<div class="msg-time-chat">
							<a class="message-img" href="#"><img alt="" src="<?php echo $url; ?>assets/system/img/fc-comissao-organizadora.jpg" class="avatar"></a>
							<div class="message-body msg-out">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"> <a href="#"><?php echo ($answer->re_historico == 2) ? "[HISTÓRICO] " : ""; ?> [Comissão Organizadora]</a><?php echo $answer->us_name; ?> em <?php echo dateIsoToBr($answer->re_data_hora); ?></p>
									<p><?php echo $answer->re_mensagem; ?></p>
								</div>
							</div>
						</div>

						<?php
						}else{
						?>
						<div class="msg-time-chat">
							<a class="message-img" href="#"><img alt="" src="<?php echo $url; ?>assets/system/img/fc-usuario.jpg" class="avatar"></a>
							<div class="message-body msg-in">
								<span class="arrow"></span>
								<div class="text">
									<p class="attribution"> <a href="#"><?php echo $initQuestion->du_nome; ?></a>em <?php echo dateIsoToBr($answer->re_data_hora); ?></p>
									<p><?php echo $answer->re_mensagem; ?></p>
								</div>
							</div>
						</div>
						<?php
						}

					}
					?>
			</div>
			<div class="chat-form">
				<div class="input-cont ">
					<input type="hidden" name="du_id" value="<?php echo $initQuestion->du_id; ?>">
					<textarea class="form-control col-lg-12" name='answer' placeholder="Digite sua mensagem"></textarea>
				</div>
				<div class="form-group">
					<div class="pull-right chat-features">
						<a href="javascript:;" class="btn btn-info btn-send-answer" data-type="1">Enviar</a>
						<a href="javascript:;" class="btn btn-info btn-send-answer" data-type="2">Gravar como Histórico</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="panel">
		<div id="message"></div>
	</section>
</div>