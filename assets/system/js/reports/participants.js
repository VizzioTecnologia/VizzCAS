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
            url: siteURL+"index.php/reports/export/1",
            data: {
                form: form
            },
            dataType: 'JSON'
        }).done(function(data) {

            if(data.check == false){
                notification('Erro!','Algo aconteceu durante a criação do relatório/arquivo.');
            }else{
                var file = siteURL+'files/reports/participants/'+data.file;
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
            url: siteURL+"index.php/reports/make/1",
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

    $('#my_multi_select3').multiSelect({
        selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function (e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function () {
            //this.qs1.cache();
            //this.qs2.cache();
        },
        afterDeselect: function () {
            //this.qs1.cache();
            //this.qs2.cache();
        }
    });

});