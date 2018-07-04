<li class="count">
	<span data-count="<?php echo $total_questions; ?>">Fale Conosco</span>
	<ul>
		<?php
			foreach($last_five as $item){
		?>
			<li class="unread">
				<a href="#" data-modal>
					<h4><?php echo $item->du_nome; ?></h4>
					<p><?php echo $item->du_assunto; ?></p>
				</a>
			</li>

		<?php
		}
		?>
		<li>
			<a href="#" data-modal>
				<h4>Ver todos</h4>
				<p>Clique aqui</p>
			</a>
		</li>
	</ul>
</li>