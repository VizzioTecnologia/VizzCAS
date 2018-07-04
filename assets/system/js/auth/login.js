$(document).ready(function() {
	$('form.form-signin').submit(function(){

		$('input').attr('disabled',true);
		$('.btn-login').attr('disabled',true).html('Aguarde...');

		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();

		if(username == "" && password == ""){

			message('#message','alert-warning','Ops!','Digite um login e senha.');
			$('.btn-login').attr('disabled',false).html('Entrar');
			$('input').attr('disabled',false);
			return false;
		}		

		if(username == ""){

			message('#message','alert-warning','Ops!','Digite um login válido.');
			$('.btn-login').attr('disabled',false).html('Entrar');
			$('input').attr('disabled',false);
			return false;
		}

		if(password == ""){

			message('#message','alert-warning','Ops!','Digite uma senha válida.');
			$('.btn-login').attr('disabled',false).html('Entrar');
			$('input').attr('disabled',false);
			return false;
		}

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/auth/ajaxLogin",
			data: { 
				login: username,
				password: password
			},
			dataType: 'JSON'
		}).done(function(data) {

			switch(data.check){
				case 1:

					$('.btn-login').attr('disabled',false).html('Entrar');
					$('input').attr('disabled',false);
					// Login não foi encontrado
					message('#message','alert-danger','Erro!','O usuário fornecido não foi encontrado.');
					$('input[name="username"]').focus();
				break;
				case 2:

					$('.btn-login').attr('disabled',false).html('Entrar');
					$('input').attr('disabled',false);
					// Senha não confere
					$('input[name="password"]').focus();
					message('#message','alert-danger','Erro!','A senha não confere.');
				break;
				case 3:

					// True
					message('#message','alert-success','Sucesso!','Logado com sucesso. Aguarde enquanto lhe redirecionamos...');
					setTimeout(function(){
						location.href = siteURL+'index.php/dash';
					},3000);
				break;
				default:

					$('.btn-login').attr('disabled',false).html('Entrar');
					$('input').attr('disabled',false);
					// Algum outro erro
					message('#message','alert-danger','Erro!','Algum erro aconteceu durante a requisição. Contate o suporte.');
					break;
				}		

			});
		return false;
	});
});