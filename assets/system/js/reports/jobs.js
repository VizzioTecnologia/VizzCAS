$(document).ready(function(){

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
            url: siteURL+"index.php/reports/export/3",
            data: {
                form: form
            },
            dataType: 'JSON'
        }).done(function(data) {

            if(data.check == false){
                notification('Erro!','Algo aconteceu durante a criação do relatório/arquivo.');
            }else{
                var file = siteURL+'files/reports/jobs/'+data.file;
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
            url: siteURL+"index.php/reports/make/3",
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

});