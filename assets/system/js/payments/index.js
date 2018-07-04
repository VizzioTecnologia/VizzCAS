$(document).ready(function(){
	dt = $('#lista-pagamentos').dataTable( {
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
		{"bSortable": true},
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

				var statusInfo = [];
				statusInfo[1] = "Aguardando Pagamento";
				statusInfo[2] = "Em análise";
				statusInfo[3] = "Paga";
				statusInfo[4] = "Disponível";
				statusInfo[5] = "Em disputa";
				statusInfo[6] = "Devolvida";
				statusInfo[7] = "Cancelada";
				statusInfo[8] = "Pagamento Manual";
				statusInfo[9] = "Isento";

					/*
					1	Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.	 WAITING_PAYMENT
					2	Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.	 IN_ANALYSIS
					3	Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.	 PAID
					4	Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.	 AVAILABLE
					5	Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.	 IN_DISPUTE
					6	Devolvida: o valor da transação foi devolvido para o comprador.	 REFUNDED
					7	Cancelada: a transação foi cancelada sem ter sido finalizada.
					*/

					var status = obj.aData[5];
					
					var result = '<span class="label label-warning">'+statusInfo[status]+'</span>';
					
					return result;

				}
			},
			{
				"bSortable": true,
				"fnRender": function ( obj ) {

					var tipo = obj.aData[6];
					
					if(tipo == 1){
						var result = '<span class="label label-info">Filiado</span>';
					}
					if(tipo == 2){
						var result = '<span class="label label-info">Agregado</span>';
					}
					if(tipo == 3){
						var result = '<span class="label label-info">Individual</span>';
					}
                    if(tipo == 4){
                        var result = '<span class="label label-info">Postulante</span>';
                    }
                    if(tipo == 5){
                        var result = '<span class="label label-info">Estrangeiro</span>';
                    }
					
					return result;
				}
			},
			{
				"bSortable": false,
				"fnRender": function ( obj ) {
					var objHTML = $('<div>'+obj.aData[7]+'</div>');
					//remove link quando for agregado
					objHTML.find('[data-tipo-id=5]').remove();

					return objHTML.html();
				}
			}
			],
			"bProcessing": true,
			"bServerSide": false,
			"sAjaxSource": siteURL+"index.php/payments/ajaxDataTable",
			"sServerMethod": "POST"
		});

	$(document).on('click','.btn-view',function(e){

		var id = $(this).attr('data-id');

			location.href= siteURL+"index.php/payments/view/"+id;

			e.preventDefault();
	});

	$(document).on('click','.btn-send-link',function(e){

		var id = $(this).attr('data-id');

		$('button.confirm').attr('data-id',id);
		$('button.confirm-default-value').attr('data-id',id);

		$('#modal-link').modal({
			keyboard:false,
			backdrop:'static'
		});

		e.preventDefault();
	});

	$('button.confirm-default-value').click(function(){

		$('#modal-link').modal('hide');

		$('#modal-loading').modal({
			keyboard:false,
			backdrop:'static'
		});

		var id = $(this).attr('data-id');

		$.ajax({
			type: "POST",
			url: siteURL+"index.php/payments/ajaxSendPaymentLink",
			data: { 
				id: id
			},
			dataType: 'JSON'
		}).done(function(data) {

			// Check 2 = Ok
			if(data.check == 2){
				dt.fnReloadAjax();
				
				notification('Sucesso!','O link de pagamento foi reenviado com sucesso.');
			}else{
				notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
			}

			$('#modal-loading').modal('hide');

		});		

	});

    $('button.confirm').click(function(){

        var value = $('input[name="new_value"]').val();

        if(value == ""){
            notification('Erro!','O campo de novo valor deve ser preenchido.');
            return false;
        }

        $('#modal-link').modal('hide');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        var id = $(this).attr('data-id');


        $.ajax({
            type: "POST",
            url: siteURL+"index.php/payments/ajaxSendPaymentLink",
            data: {
                id: id,
                value : value
            },
            dataType: 'JSON'
        }).done(function(data) {

                // Check 2 = Ok
                if(data.check == 2){
                    dt.fnReloadAjax();

                    notification('Sucesso!','O link de pagamento foi reenviado com sucesso.');
                }else{
                    notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
                }

                $('#modal-loading').modal('hide');

        });
    });

    $(document).on('click','button.btn-change-status',function(e){

        var id = $(this).attr('data-id');

        $('button.confirm-new-status').attr('data-id',id);

        $('#modal-status').modal({
            keyboard:false,
            backdrop:'static'
        });

        e.preventDefault();
    });

    $('button.confirm-new-status').click(function(){

        $('#modal-status').modal('hide');

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        var id = $(this).attr('data-id');
        var status = $('select[name="new-status"]').val();

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/payments/ajaxChangePaymentStatus",
            data: {
                id: id,
                status: status
            },
            dataType: 'JSON'
        }).done(function(data) {

                // Check 2 = Ok
                if(data.check){
                    dt.fnReloadAjax();

                    notification('Sucesso!','O status do pagamento foi mudado com sucesso.');
                }else{
                    notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
                }

                $('#modal-loading').modal('hide');

            });

    });

});
