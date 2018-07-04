$(document).ready(function(){

	// Função Aprovar
	$('.btn-1').click(function(){
		$('#type').html('aprovar');
		$('input[name="operation"]').val(2);

		$('#confirm').modal({
			keyboard:false,
			backdrop:'static'
		});
	});
	
	// Função Não Aprovar
	$('.btn-2').click(function(){
		$('#type').html('reprovar');
		$('input[name="operation"]').val(3);

		$('#confirm').modal({
			keyboard:false,
			backdrop:'static'
		});
	});

	$('button.confirm').click(function(){

		$('#confirm').modal('hide');

		$('#modal-loading').modal({
			keyboard:false,
			backdrop:'static'
		});

		var id = $('input[name="id"]').val();
		var status = $('input[name="operation"]').val();

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/jobs/ajaxChangeStatus",
			data: { 
				id: id,
				status: status
			},
			dataType: 'JSON'
		}).done(function(data) {

			if(data.check == true){

				notification('Aviso!','O trabalho foi '+data.texto+' com sucesso.');

			}else{

				notification('Aviso!','Algo aconteceu de errado, o trabalho não pôde ser '+data.texto+'.');

			}

			$('#modal-loading').modal('hide');
			
			$('.btn-1,.btn-2').attr('disabled',true);
		});		

	});

	// Função Imprimir
	$('.btn-3').click(function(){

		var option = $('input[name="option-print"]').is(':checked');

		$('#modal-loading').modal({
			keyboard:false,
			backdrop:'static'
		});

		var id = $('input[name="id"]').val();

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/jobs/ajaxPdf",
			data: { 
				id: id,
				option: option
			},
			dataType: 'JSON'
		}).done(function(data) {

			$('#modal-loading').modal('hide');

			var file = siteURL+'files/jobs/'+data.file;

			window.open(file,'_blank');
 		});
	});
});