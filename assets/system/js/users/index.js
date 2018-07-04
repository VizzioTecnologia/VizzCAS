$(document).ready(function(){
	dt = $('#lista-usuarios').dataTable( {
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
			{
				"bSortable": false,
				"fnRender": function ( obj ) {

					var opt = obj.aData[3];
					
					var result = '<span class="label label-warning">'+opt+'</span>';

					return result;

	            }
	       	},
			{"bSortable": false}
		],
		"bProcessing": true,
		"bServerSide": false,
		"sAjaxSource": siteURL+"index.php/users/ajaxDataTable",
		"sServerMethod": "POST"
	});

	$(document).on('click','.btn-manage',function(e){

		var id = $(this).attr('data-id');

		location.href= siteURL+"index.php/users/manage/"+id;

		e.preventDefault();

	});

});
