$(document).ready(function(){
	dt = $('#lista-participantes').dataTable( {
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
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false}
		],
		"bProcessing": true,
		"bServerSide": false,
		"sAjaxSource": siteURL+"index.php/subscribers/ajaxDataTableParticipants",
		"sServerMethod": "POST"
	});

	$(document).on('click','.btn-manage',function(e){

		var id = $(this).attr('data-id');

		location.href= siteURL+"index.php/subscribers/manage/2/"+id;

		e.preventDefault();
	});

    $(document).on('click','.btn-print',function(e){

        var id = $(this).attr('data-id');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/subscribers/ajaxPdf",
            data: {
                id: id
            },
            dataType: 'JSON'
        }).done(function(data) {

                $('#modal-loading').modal('hide');

                var file = siteURL+'files/subscribers/'+data.file;

                window.open(file,'_blank');
            });

        e.preventDefault();
    });

    $(document).on('click','.btn-delete',function(e){

		var id = $(this).attr('data-id');

        $('button.confirm').attr('data-id',id);

        $('#modal-delete').modal({
            keyboard:false,
            backdrop:'static'
        });

        e.preventDefault();
	});

    $('button.confirm').click(function(){

        $('#modal-delete').modal('hide');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        var id = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/subscribers/ajaxDelete",
            data: {
                id: id
            },
            dataType: 'JSON'
        }).done(function(data) {

                // Check 2 = Ok
                if(data.check == 2){
                    notification('Sucesso!','O participante foi excluído com sucesso');
                }else{
                    notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
                }
                $('#modal-loading').modal('hide');

        });
    });

});
