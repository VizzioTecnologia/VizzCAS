$.validator.setDefaults({
    messages: {
    	required: "Este campo é obrigatório."
    }
});

$(document).ready(function(){

	$('.btn-save').click(function(){
		$("#form-user").submit();
	});

	$('.btn-cancel').click(function(e){
			
		
	
		location.href= siteURL+"index.php/users/";

		e.preventDefault();
	});

	$("#form-user").validate({
		messages: {
			us_name: {
				required: "Este campo é obrigatório."
			},		
			us_login: {
				required: "Este campo é obrigatório."
			},
			us_password: {
				required: "Este campo é obrigatório."
			},			
			ut_id: {
				required: "Este campo é obrigatório."
			}
		},
		submitHandler:function(){

			var form = $('#form-user').serializeArray();
			var id = $('input[name="us_id"]').val();

			$('input:not([name="us_id"]),select,button').attr('disabled',true);
			$('button[type="submit"]').html('Aguarde...');

			$.ajax({
				type: "POST",
				url: siteURL+"index.php/users/ajaxManage",
				data: { 
					form: form,
					id: id
				},
				dataType: 'JSON'
			}).done(function(data) {

				if(data.check == true){
					$('input[name="us_id"]').val(data.id);
					message('#message','alert-success','Sucesso','O registro foi salvo.');
				}
				if(data.check == false){
					message('#message','alert-danger','Erro!','Algo deu errado durante a solicitação. Contate o administrador do sistema para mais informações.');
				}
				if(data.check == 2){
					message('#message','alert-warning','Ops!','O login que você forneceu já está cadastrado no sistema');
				}

				$('input:not([name="us_id"]),select,button').attr('disabled',false);
				$('button[type="submit"]').html('Salvar');	
			});

			return false;
		}
	});
});