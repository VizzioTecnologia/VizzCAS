$(document).ready(function(){

	$('.btn-send-answer').click(function(){

		var answer = $("textarea[name='answer']").val();
		var id = $("input[name='du_id']").val();

		// 1 - Gravar / 2 - Gravar como histórico
		var type = $(this).attr('data-type');

		if(answer == ""){

		}else{

			$('.btn-send-answer').attr('disabled',true);
			$('.btn-send-answer[data-type="'+type+'"]').html('Aguarde...');
			$("textarea[name='answer']").attr('disabled',true);

			$.ajax({
				type: "POST",
				url: siteURL+"index.php/faleconosco/ajaxSaveAnswer/",
				data: { answer: answer, id: id, type: type},
				dataType: "JSON"
			})
			.done(function(data) {
				if(data.check){

					var result = ['Resposta criada e enviada com sucesso', 'Histórico criado com sucesso'];
					var resultHTML = ['','[HISTÓRICO]']


					message('#message','alert-success','Sucesso!',result[data.type-1]);


					var html = '<div class="msg-time-chat"><a class="message-img" href="#"><img alt="" src="'+siteURL+'assets/system/img/fc-comissao-organizadora.jpg" class="avatar"></a><div class="message-body msg-out"><span class="arrow"></span><div class="text"><p class="attribution"> <a href="#">'+resultHTML[data.type-1]+'[Comissão Organizadora]'+data.name+'</a>em '+data.date+'</p><p>'+data.message+'</p></div></div></div>';

					$('.timeline-messages').append(html);

				}else
					message('#message','alert-danger','Erro!','Algo ocorreu durante a requisição. Contate o administrador do sistema para mais detalhes!');

				$('.btn-send-answer').attr('disabled',false);
				$('.btn-send-answer[data-type="1"]').html('Enviar');
				$('.btn-send-answer[data-type="2"]').html('Gravar como Histórico');
				$("textarea[name='answer']").attr('disabled',false).val("");
			});

		}

	});

});