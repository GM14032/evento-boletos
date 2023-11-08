$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    crear_dataTable();

});

function crear_dataTable(){
    $('#tablaEventos').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('obtener_eventos') }}",
            type: 'GET'
        },
        responsive: true,
        columns: [
            {data: 'id', name: 'id'},
            {data: null, render: function(data) {
                return `<img src="{{ asset('img_eventos/${data.id}.jpg') }}" style="border-radius: 50%; width: 50px; height: 50px;">`;
            }},
            {data: 'evento', name: 'evento'},
            {data: 'fecha', name: 'fecha'},
            {data: 'formato', name: 'formato'},
            //Renderizar botones edit y delete
            { data: null,
                render: function(data){
                    return `<a href="#" class="btn btn-danger btn-sm" onclick="eliminarProfesor()"><i class="mdi mdi-trash-can"></i></i>
                    </a>&nbsp;&nbsp;<a href="#" class="btn btn-warning btn-sm" onclick="editarEvento(${data.id}),'${data.evento}', '${data.fecha}', '${data.formato}'"><i class="mdi mdi-pencil"></i></i></a>`;
            } 
      }
        ],
        order: [[0, 'desc']],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
}

function editarEvento(id, evento, fecha, formato){
    $('#agregar_evento').modal('show');
    $('#textEvento').val(evento);
    $('#txtFechaRealizacion').val(fecha);
    $('#textEvento').val(id);
}