<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading">
			Gerenciamento de usuários
		</header>
		<div class="panel-body">
			<form class="form-inline" role="form" id="form-user">
				<div class="form-group col-lg-1">
					<input type="text" class="form-control" name="us_id" placeholder="ID" value="<?php echo $user->us_id; ?>" disabled>
				</div>	
				<div class="form-group col-lg-3">
					<input type="text" class="form-control" name="us_name" placeholder="Nome do usuário" value="<?php echo $user->us_name; ?>" required>
				</div>				
				<div class="form-group col-lg-2">
					<input type="text" class="form-control" name="us_login" placeholder="Usuário" value="<?php echo $user->us_login; ?>" required>
				</div>
				<div class="form-group col-lg-2">
					<input type="password" class="form-control" name="us_password" placeholder="Senha" value="<?php echo $user->us_password; ?>" required>
				</div>
				<div class="form-group col-lg-2">
					<select class="form-control" name="ut_id" required>
						<option selected disabled>Tipo de usuário</option>
						<?php
							foreach($ut as $row){

								if($user->ut_id){
									if($user->ut_id == $row->ut_id)
										echo '<option value="'.$row->ut_id.'" selected>'.$row->ut_name.'</option>';									
								}else
									echo '<option value="'.$row->ut_id.'">'.$row->ut_name.'</option>';	
							}
						?>
					</select>
				</div>

				<button type="button" class="btn btn-success btn-save">Salvar</button>
				<button type="button" class="btn btn-danger btn-cancel">Cancelar</button>
			</form>

		</div>
	</section>
	<section class="panel">
		<div id="message"></div>
	</section>
</div>