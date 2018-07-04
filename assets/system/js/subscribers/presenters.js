$(document).ready(function(){
	dt = $('#lista-apresentadores').dataTable( {
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
		"sAjaxSource": siteURL+"index.php/subscribers/ajaxDataTablePresenters",
		"sServerMethod": "POST"
	});

    $(document).on('click','.btn-manage',function(e){

        var id = $(this).attr('data-id');

        location.href= siteURL+"index.php/subscribers/manage/1/"+id;

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
                if(data.check){
                    dt.fnReloadAjax();

                    notification('Sucesso!','O participante foi excluído com sucesso');
                }else{
                    notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
                }

                $('#modal-loading').modal('hide');

            });
    });

    $('button.confirm-link').click(function(){

        $('#modal-link').modal('hide');

        $('#modal-check-email').modal('show');
    });

    $('button.with-email').click(function(){

        $('#modal-check-email').modal('hide');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        var id = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/subscribers/ajaxCreatePayment",
            data: {
                id: id,
                email: true
            },
            dataType: 'JSON'
        }).done(function(data) {

            // Check 2 = Ok
            if(data.check){
                dt.fnReloadAjax();

                notification('Sucesso!','Link de pagamento criado e enviado com sucesso!');
            }else{
                notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
            }

            $('#modal-loading').modal('hide');

        });
    });
    $('button.without-email').click(function(){

        $('#modal-check-email').modal('hide');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        var id = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/subscribers/ajaxCreatePayment",
            data: {
                id: id,
                email: false
            },
            dataType: 'JSON'
        }).done(function(data) {

                // Check 2 = Ok
                if(data.check){
                    dt.fnReloadAjax();

                    notification('Sucesso!','Link de pagamento criado com sucesso!');
                }else{
                    notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
                }

                $('#modal-loading').modal('hide');

            });
    });

    $(document).on('click','.btn-send-link',function(e){

        var id = $(this).attr('data-id');

        $('button.confirm-link').attr('data-id',id);

        $('#modal-link').modal({
            keyboard:false,
            backdrop:'static'
        });

        e.preventDefault();
    });
});
