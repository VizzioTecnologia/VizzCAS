$(document).ready(function(){

    $('form#subscriber').submit(function(e){

        var form = $(this).serialize();

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/subscribers/ajaxUpdate",
            data: {
                form: form
            },
            dataType: 'JSON'
        }).done(function(data) {
            // Check 2 = Ok
            if(data.check){

                notification('Sucesso!','Atualização realizada com sucesso.');
            }else{
                notification('Erro!','Algum erro ocorreu durante a solicitação. Contate o administrador do sistema para saber mais informações.');
            }

            $('#modal-loading').modal('hide');
         });

        e.preventDefault();
    });

});