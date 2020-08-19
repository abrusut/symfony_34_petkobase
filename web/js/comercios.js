
(function ($) {
    jQuery('#comerciosTable').addClass('state-loading');

        function initDataTable() {
            function removeAccents(data) {
                return data
                    .replace(/έ/g, 'ε')
                    .replace(/[ύϋΰ]/g, 'υ')
                    .replace(/ό/g, 'ο')
                    .replace(/ώ/g, 'ω')
                    .replace(/ά/g, 'α')
                    .replace(/[ίϊΐ]/g, 'ι')
                    .replace(/ή/g, 'η')
                    .replace(/\n/g, ' ')
                    .replace(/[áÁ]/g, 'a')
                    .replace(/[éÉ]/g, 'e')
                    .replace(/[íÍ]/g, 'i')
                    .replace(/[óÓ]/g, 'o')
                    .replace(/[úÚ]/g, 'u')
                    .replace(/ê/g, 'e')
                    .replace(/î/g, 'i')
                    .replace(/ô/g, 'o')
                    .replace(/è/g, 'e')
                    .replace(/ï/g, 'i')
                    .replace(/ü/g, 'u')
                    .replace(/ã/g, 'a')
                    .replace(/õ/g, 'o')
                    .replace(/ç/g, 'c')
                    .replace(/ì/g, 'i');
            }
            var searchType = jQuery.fn.DataTable.ext.type.search;
            searchType.string = function (data) {
                return !data ?
                    '' :
                    typeof data === 'string' ?
                        removeAccents(data) :
                        data;
            };
            searchType.html = function (data) {
                return !data ?
                    '' :
                    typeof data === 'string' ?
                        removeAccents(data.replace(/<.*?>/g, '')) :
                        data;
            };
            var tabla = jQuery("#comerciosTable").DataTable({
                "lengthChange": false,
                // "autoWidth": false,
                // "columnDefs": [
                //     { "targets": [5, 6, 7, 8], "visible": false }
                // ],
                "ordering": true,
                "order": [0, "asc"],
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'i>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-lg-12 d-flex justify-content-center'p>>",
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "_TOTAL_ resultados",
                    "sInfoEmpty": "No hay resultados",
                    //"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoFiltered": "",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "<<",
                        "sLast": ">>",
                        "sNext": ">",
                        "sPrevious": "<"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente",
                        "paginate": {
                            "first": 'Ir a la primera página',
                            "previous": 'Ir a la página anterior',
                            "next": 'Ir a la página siguiente',
                            "last": 'Ir a la última página'
                        }
                    }
                },
                initComplete: function () {
                    //Agrego localidades al combo de Localidades
                    var column = this.api().column(4);

                    column.data().unique().sort().each( function (d, j) {
                        $("#localidadTableFiltro").append('<option value="'+d+'">'+d+'</option>')
                    });
                }
            });
            jQuery(document).ready(function () {
                // Remove accented character from search input as well
                jQuery('#comerciosTableSearch').keyup(function () {
                    tabla
                        .search(
                            jQuery.fn.DataTable.ext.type.search.string(this.value)
                        )
                        .draw()
                });

                jQuery('#localidadTableFiltro').on( 'change', function () {
                    val = $(this).val();

                    // Asocio el combo de localidades a la columna de localidades para el filtrado
                    tabla.column(4)
                        .search(
                            jQuery.fn.DataTable.ext.type.search.string(this.value)
                        )
                        .draw();
                } );
            });

            //Elimino input del filtro de busqueda del datatable
            jQuery("#comerciosTable_filter").parent().parent().remove();
        }

        initDataTable();
})(jQuery);