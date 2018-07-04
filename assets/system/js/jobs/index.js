$(document).ready(function(){
	dt = $('#lista-trabalhos').dataTable( {
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
			{"bSortable": true},
			{"bSortable": false},
			{
				"bSortable": false,
				"fnRender": function ( obj ) {

					var prioridade = [];
					prioridade[1] = "Comunicação Oral";
					prioridade[2] = "Pôster";
					prioridade[3] = "Indiferente";

					/*
					1 - Comunicação Oral
					2 - Pôster
					3 - Indiferente
					*/

					var opt = obj.aData[3];
					
					var result = '<span class="label label-warning">'+prioridade[opt]+'</span>';

					return result;

	            }
	       	},
			{
				"bSortable": true,
				"fnRender": function ( obj ) {

					var status = ["Aguardando Aprovação","Aprovado","Reprovado"];

					var opt = obj.aData[4];
					
					if(opt == 1)
						var cl = "label-warning";
					if(opt == 2)
						var cl = "label-success";
					if(opt == 3)
						var cl = "label-danger";

					var result = '<span class="label '+cl+'">'+status[opt-1]+'</span>';

					return result;

	            }
	       	},
			{"bSortable": false}
		],
		"bProcessing": true,
		"bServerSide": false,
		"sAjaxSource": siteURL+"index.php/jobs/ajaxDataTable",
		"sServerMethod": "POST"
	});

	$(document).on('click','.btn-view',function(e){

		var id = $(this).attr('data-id');

		location.href= siteURL+"index.php/jobs/view/"+id;

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

	$('button.confirm-eliminate').click(function(e){

		var id = $(this).attr('data-id');

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/jobs/ajaxEliminate",
			data: { 
				id: id
			},
			dataType: 'JSON'
		}).done(function(data) {

			if(data.check == true){

				dt.fnReloadAjax();

				notification('Aviso!','Trabalho foi eliminado com sucesso!.');

			}else{

				notification('Aviso!','Algo ocorreu durante a requisição. Tente novamente mais tarde.');

			}

			$('#modal-eliminate').modal('hide');
		});	

		e.preventDefault();
	});


});
