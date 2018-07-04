$(document).ready(function(){
	dt = $('#lista-duvidas').dataTable( {
		"bStateSave": true,
		"aaSorting": [[ 0, "desc" ]],
		"oLanguage": { 
			"sProcessing": "Processando...", 
			"sLengthMenu": "Mostrar _MENU_ registros", 
			"sZeroRecords": "Não foram encontrados resultados", 
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros", 
			"sInfoEmpty": "Mostrando de 0 até 0 de 0 registros", 
			"sInfoFiltered": "", 
			"sInfoPostFix": "", 
			"sSearch": "Buscar:", 
			"sUrl": "", 
			"oPaginate": { 
				"sFirst": "Primeiro", 
				"sPrevious": "Anterior", 
				"sNext": "Seguinte", 
				"sLast": "Último" 
			} 
		},
		"aoColumns": [
			{"bSortable": true},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{
				"bSortable": false,
				"fnRender": function ( obj ) {

					var date = obj.aData[4];
					if(date != null){

						date = date.split(' ');

						var hour = date[1];

						date = date[0].split('-');

						date = date[2]+"/"+date[1]+"/"+date[0];
					}

	                return date+" às "+hour;
	            }
	       	},
			{
				"bSortable": true,
				"fnRender": function ( obj ) {

					var status = obj.aData[5];
					
					var id = obj.aData[0];

					if(status == 1){
						var result = '<span class="label label-warning" data-id="'+id+'" data-status="'+status+'">Aguardando resposta</span>';
					}else{
						var result = '<span class="label label-success" data-id="'+id+'" data-status="'+status+'">Respondido</span>';
					}

					return result;

	            }
	       	},
			{"bSortable": false}
		],
		"bProcessing": true,
		"bServerSide": false,
		"sAjaxSource": siteURL+"index.php/faleconosco/ajaxDataTable",
		"sServerMethod": "POST"
	});

	$(document).on('click','.btn-view',function(e){

		var id = $(this).attr('data-id');

		location.href= siteURL+"index.php/faleconosco/view/"+id;

		e.preventDefault();
	});

	$(document).on('click','.btn-delete',function(e){

		var id = $(this).attr('data-id');

		$('button.confirm-eliminate').attr('data-id',id);

		$('#modal-eliminate').modal({
			keyboard:false,
			backdrop:'static'
		});	

		e.preventDefault();
	});

	$(document).on('click','.btn-answer',function(e){

		var id = $(this).attr('data-id');
		var status = $('span[data-id="'+id+'"]').attr('data-status');

		$('#modal-loading').modal({
			keyboard:false,
			backdrop:'static'
		});

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/faleconosco/ajaxChangeStatus",
			data: { 
				id: id,
				status: status
			},
			dataType: 'JSON'
		}).done(function(data) {

			if(data.check == true){

				dt.fnReloadAjax();

				notification('Aviso!','A conversa foi marcada como '+data.texto+'.');

			}else{

				notification('Aviso!','Algo aconteceu de errado, o status da conversa não pôde ser alterado.');

			}

			$('#modal-loading').modal('hide');
			
		});		

		e.preventDefault();
	});

	$('button.confirm-eliminate').click(function(e){

		var id = $(this).attr('data-id');

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/faleconosco/ajaxEliminate",
			data: { 
				id: id
			},
			dataType: 'JSON'
		}).done(function(data) {

			if(data.check == true){

				dt.fnReloadAjax();

				notification('Aviso!','O cliente foi excluído com sucesso.');

			}else{

				notification('Aviso!','Algo aconteceu de errado, o cliente não pôde ser excluído.');

			}

			$('#modal-eliminate').modal('hide');
		});	

		e.preventDefault();
	});

});
