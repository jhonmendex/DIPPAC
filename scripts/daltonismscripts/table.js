jQuery.fn.dataTableExt.oSort['format-date-asc'] = function (a, b) {
    var x = (a == "-") ? 0 : a.replace("-", "").replace("-", "");
    var y = (b == "-") ? 0 : b.replace("-", "").replace("-", "");
    return (x - y);
};

jQuery.fn.dataTableExt.oSort['format-date-desc'] = function (a, b) {
    var x = (a == "-") ? 0 : a.replace("-", "").replace("-", "");
    var y = (b == "-") ? 0 : b.replace("-", "").replace("-", "");
    return (y - x);
};
var oTable;

$(document).ready(function () {
    $(".various3").fancybox({
        'width': 1100,
        'height': 380,
        'autoScale': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'type': 'iframe',
        'hideOnOverlayClick': false
    });
    $(".various2").fancybox({
        'width': 600,
        'height': 190,
        'autoScale': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'type': 'iframe',
        'hideOnOverlayClick': false
    });
    $(".various4").fancybox({
        'width': 1100,
        'height': 450,
        'autoScale': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'type': 'iframe',
        'hideOnOverlayClick': false
    });
    $('img').css("border", "0");
    oTable = $('#mytable').dataTable({
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).addClass("class1");
            $('td:eq(0)', nRow).addClass('init2');
            $('td:eq(1)', nRow).addClass('item2');
            $('td:eq(2)', nRow).addClass('item2');
            $('td:eq(3)', nRow).addClass('item2');
            $('td:eq(4)', nRow).addClass('item2');
            $('td:eq(5)', nRow).addClass('item2');
            $('td:eq(6)', nRow).addClass('item2');
            $('td:eq(7)', nRow).addClass('item2');
            $('td:eq(8)', nRow).addClass('item2');
            $('td:eq(9)', nRow).addClass('item2');
            $('td:eq(10)', nRow).addClass('item2');

            $('td:eq(5)', nRow).css({
                'text-align': 'center',
                'width': '20px'
            });
            $('td:eq(7)', nRow).css({
                'text-align': 'center',
                'width': '20px'
            });
            $('td:eq(8)', nRow).css({
                'text-align': 'center',
                'width': '20px'
            });
        },
        "aLengthMenu": [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "Todos"]
        ],
        "iDisplayLength": 10,
        "oLanguage": {
            "sEmptyTable": "No existen datos disponibles",
            "sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando desde 0 hasta 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sLoadingRecords": "Cargando...",
            "sProcessing": "Procesando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "No se encontraron resultados",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": activar para Ordenar Ascendentemente",
                "sSortDescending": ": activar para Ordendar Descendentemente"
            }
        },
        "sPaginationType": "full_numbers",
        "oSearch": {
            "bSmart": false
        },
        "aaSorting": [
            [6, "desc"]
        ],
        "aoColumns": [
            null,
            {
                "bSortable": false
            },
            null,
            {
                "bSortable": false
            },
            {
                "bSortable": false
            },
            {
                "bSortable": false
            },
            {
                "sType": "format-date",
                "bSearchable": false
            },
            {
                "bSortable": false,
                "bSearchable": false
            },
            {
                "bSortable": false,
                "bSearchable": false
            }
        ]
    }).columnFilter({
        aoColumns: [{
            type: "text"
        },
        {
            type: "text"
        },
        {
            type: "number"
        },
        {
            type: "number"
        },
        {
            type: "number"
        },
            null,
            null,
            null
        ]
    });
    $('#perfilfilter .filter_column .select_filter').change(function () {
        // oTable.fnFilter( "^\\s*" + $('#perfilfilter .filter_column .select_filter').val() + "\\s*$", 4, true);                          
        oTable.fnFilter("^" + $('#perfilfilter .filter_column .select_filter').val().replace("%20", " ") + "$", 4, true);
        $("#perfilfilter .filter_column .select_filter option[value='']").remove();
    });
    // $('#estadofilter .filter_column .select_filter').change(function(){                                     
    //   oTable.fnFilter( "^" + $('#estadofilter .filter_column .select_filter').val() + "$", 5, true);  
    //  $("#estadofilter .filter_column .select_filter option[value='']").remove();
    //});
    $(".callback").fancybox({
        'autoDimensions': false,
        'width': 400,
        'height': 130,
        'autoScale': false,
        'overlayOpacity': 0.1,
        'transitionIn': 'elastic',
        'transitionOut': 'fade',
        'speedIn': 500,
        'hideOnOverlayClick': false,
        'overlayColor': '#000',
        'showCloseButton': false,
        'padding': 0,
        'margin': 0
    });
    $(".callback2").fancybox({
        'autoDimensions': false,
        'width': 400,
        'height': 130,
        'autoScale': false,
        'overlayOpacity': 0.1,
        'transitionIn': 'elastic',
        'transitionOut': 'fade',
        'speedIn': 500,
        'hideOnOverlayClick': false,
        'overlayColor': '#000',
        'showCloseButton': false,
        'padding': 0,
        'margin': 0
    });

});