$(document).ready(function(){

    $('.btn-hide-filters').click(function(){

        $('.filters').slideToggle(500, function(){
            if($('.filters').is(':hidden')){
                $('.btn-hide-filters').html('Mostrar os Filtros');

                $('.btn-generate').attr('disabled',true);
                $('.btn-export').attr('disabled',true);

            }else{
                $('.btn-hide-filters').html('Esconder os Filtros');

                $('.btn-generate').attr('disabled',false);
                $('.btn-export').attr('disabled',false);
            }
        });

    });

    $('.btn-export').click(function(){

        var form = $('form#generateReport').serialize();

        if(form == ""){
            notification('Erro!','Para gerar o relatório é necessário preencher algum filtro!');
            return false;
        }

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/reports/export/4",
            data: {
                form: form
            },
            dataType: 'JSON'
        }).done(function(data) {

            if(data.check == false){
                notification('Erro!','Algo aconteceu durante a criação do relatório/arquivo.');
            }else{
                var file = siteURL+'files/reports/financial/'+data.file;
                window.open(file,'_blank');
            }

            $('#modal-loading').modal('hide');
        });

        e.preventDefault();
    });

    $('form#generateReport').submit(function(e){

        var form = $(this).serialize();

        if(form == ""){
            notification('Erro!','Para gerar o relatório é necessário preencher algum filtro!.');
            return false;
        }

        $('#modal-loading').modal({
            keyboard:false,
            backdrop:'static'
        });

        $.ajax({
            type: "POST",
            url: siteURL+"index.php/reports/make/4",
            data: {
                form: form
            },
            dataType: 'html'
        }).done(function(data) {

            $('.html').html(data).slideDown(800);

            $('#modal-loading').modal('hide');
        });

        e.preventDefault();
    });

    $('#my_multi_select').multiSelect();

});