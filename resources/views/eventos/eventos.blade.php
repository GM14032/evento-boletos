@extends('layouts.master')
@section('title')
    Gestionar Eventos
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Gestionar Eventos
        @endslot
        @slot('title')
            Eventos
        @endslot
    @endcomponent
    @php
        $user = Auth::user();
    @endphp
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" onclick="abrirModalAgregarEvento()"><i class="mdi mdi-plus"></i> Evento</button>
                </div>
                <div class="card-body">
                    <table class="display table table-bordered" id="tablaEventos">
                        <thead>
                            <tr>
                                <th class="">ID_EVENTO</th>
                                <th>IMAGEN</th>
                                <th>EVENTO</th>
                                <th>FECHA REALIZACION</th>
                                <th>FORMATO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div><!-- end row -->


    <!-- MODAL PARA AGREGAR O EDITAR EVENTOS -->
    <div class="modal fade" id="agregar_evento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">DETALLE EVENTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtEvento">Evento</label>
                    <input type="text" class="form-control" id="txtEvento">
                    <input type="hidden" name="txtId" name="txtId">
                </div>
                <div class="form-group mt-2">
                    <label for="txtFechaRealizacion">Fecha Realizacion</label>
                    <input type="date" class="form-control" id="txtFechaRealizacion">
                </div>
                <div class="form-group mt-2">
                    <label for="txtImagen">Imagen</label>
                    <input type="file" class="form-control" id="txtImagen" placeholder="Seleccione un formato">
                </div>
                <div class="form-group mt-2" hidden>
                    <label for="sltEstado">Estado</label>
                    <select class="form-control" id="sltEstado" placeholder="Seleccione un estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="sltFormato">Formato</label>
                    <select class="form-control" id="sltFormato" placeholder="Seleccione un formato" onchange="mostrarZonas()"></select>
                </div>

                <div class="row" id="detalleFormato">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="mdi mdi-close"></i>Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarEvento()"><i class="mdi mdi-check"></i>Guardar</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <!-- <script src="{{ URL::asset('build/js/eventos.js') }}"></script> -->
    <script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    crear_dataTable();
    cargarFormatos();

    var tabla = $('#tablaEventos').DataTable();

    $(window).on('resize', function() {
        tabla.columns.adjust().draw();
    });
});
var operacion = "";
var arreglo_zonas = [];
var id_evento = 0;
var tablaEventos = null;

function crear_dataTable(){
    tablaEventos = $('#tablaEventos').DataTable({
        processing: true,
        serverSide: false,
        scrollY: true,
        responsive: true,
        scrollCollapse: true,
        ajax: {
            url: "{{ url('obtener_eventos') }}",
            type: 'POST',
        },
        columns: [
            {data: 'id'},
            {data: 'ruta_imagen'},
            {data: 'evento'},
            {data: 'fecha'},
            {data: 'formato'},
            {data: 'action'}
        ],
        columnDefs: [
            { "className": "dt-center", "targets": "_all" },
            { "targets": 0, "visible": false }
        ],
        order: [[0, 'desc']],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_",
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
        },
        createdRow: function(row, data, dataIndex) {
            // Renderizar la imagen en la celda correspondiente
            var imgSrc = "{{ asset('storage/img_eventos') }}/" + data.ruta_imagen;
            var imgHtml = '<img src="' + imgSrc + '" style="border-radius: 50%; width: 50px; height: 50px;">';
            $('td:eq(0)', row).html(imgHtml);
        }
    });
}

function abrirModalAgregarEvento(){
    operacion = "agregar";
    $("#sltFormato").prop('disabled', false);
    $("#agregar_evento").modal('show');
    $("#sltFormato").val("");
    $("#detalleFormato").html("");
    $("#txtId").val("");
    $("#txtImagen").val("");
    $("#txtFechaRealizacion").val("");
    $("#txtEvento").val("");
    $("#sltEstado").val(1);
    $("#sltEstado").prop('disabled', true);
}

function guardarEvento(){
    let formData = new FormData();
    let arreglo_datos_zonas = [];

    //Validacion de campos
    if ($("#txtEvento").val()==""){
        $("#txtEvento").focus();
        mensajeError("Erorr", "Debe ingresar el nombre del evento");
        return;
    }
    if($("#txtFechaRealizacion").val() == ""){
        $("#txtFechaRealizacion").focus();
        mensajeError("Erorr", "Debe seleccionar una fecha");
        return;
    }
    if($("#sltEstado").val() == ""){
        $("#sltEstado").focus();
        mensajeError("Erorr", "Debe seleccionar un estado");
        return;
    }
    if($("#sltFormato").val() == ""){
        $("#sltFormato").focus();
        mensajeError("Erorr", "Debe seleccionar un formato");
        return;
    }

    //Ingresar campos a formData
    formData.append('id', id_evento);
    formData.append('imagen', document.getElementById('txtImagen').files[0]);
    formData.append('formato', $("#sltFormato").val());
    formData.append('fecha', $("#txtFechaRealizacion").val());
    formData.append('evento', $("#txtEvento").val());
    formData.append('estado', $("#sltEstado").val());
    formData.append('operacion', operacion);


    //Validar cuales son las zonas a ingresar
    for (let i = 0; i < arreglo_zonas.length; i++) {
        let precio = $('#'+arreglo_zonas[i]).val();
        if(precio>0){
            arreglo_datos_zonas.push({
                id_zona: arreglo_zonas[i],
                precio: $('#'+arreglo_zonas[i]).val(),
            });
        }
    }

    //Validar que al menos haya ingresado el precio a una zona cuando se crea el evento
    if(operacion == "agregar"){
        if(arreglo_datos_zonas.length == 0){
            mensajeError("Erorr", "Debe introducir el precio de al menos una zona");
            return;
        }
    }

    formData.append('zonas', JSON.stringify(arreglo_datos_zonas));
    // formData.append('id_formato', $("#sltFormato").val());

    $.ajax({
        type: "POST",
        url: "{{ url('guardar_evento') }}",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            console.log('Success:', data);
            $("#agregar_evento").modal('hide');
            $("#txtId").val("");
            $("#txtImagen").val("");
            $("#txtFechaRealizacion").val("");
            $("#txtEvento").val("");
            $("#sltFormato").val("");

            //Mensaje de exito
            mensajeExito("Éxito", "Se ha guardado el evento");
            //Esperar 2 segundos para actualizar la tabla
            setTimeout(function(){
                tablaEventos.clear().draw();
                tablaEventos.ajax.reload();
            }, 500);

        },
        error: function(data){
            mensajeError("Error", "Ocurrió un error al intentar guardar los datos");
        }
    });
}

function editarEvento(id,evento,fecha,id_formato){
    id_evento = id;
    console.log(id + " " + evento + " " + fecha + " " + id_formato + " ");
    operacion = "actualizar";
    $("#agregar_evento").modal('show');
    $("#detalleFormato").html("");
    //$("#txtId").val(id_evento);
    $("#txtImagen").val("");
    $("#txtFechaRealizacion").val(fecha);
    $("#txtEvento").val(evento);
    $("#sltFormato").val(id_formato);
    mostrarZonas();
}

function cargarFormatos(){
    var opciones_formatos = "";
    $.ajax({
        type: "POST",
        url: "{{ url('cargar_formatos') }}",
        dataType: 'json',
        success: function(data){
            console.log(data);
            opciones_formatos = "<option value=''>Seleccione un formato</option>";
            for (var i = 0; i < data.length; i++) {
                opciones_formatos += "<option value='" + data[i].id + "'>" + data[i].nombre + "</option>";
            }
            $("#sltFormato").html(opciones_formatos);
            $("#sltFormato").val("");
        }
    })
}

function mostrarZonas(){
    if(operacion == "agregar"){
        mostrarZonasFormatoAGuardar();
    }else{
        mostrarZonasFormatoAEditar();
    }
}

function mostrarZonasFormatoAGuardar(){
    arreglo_zonas = [];
    let id_formato_seleccionado = $("#sltFormato").val();
    $("#detalleFormato").html("");
    $.ajax({
        type: "POST",
        url: "{{ url('mostrar_zonas_formato') }}",
        data: {
            id_formato: id_formato_seleccionado,
        },
        dataType: 'json',
        success: function(data){
            console.log('Success:', data);
            let tabla_zonas = "";
            tabla_zonas += `<table class="table table-bordered mt-2 text-center">
            <thead>
                <tr class="bg-primary text-white text-center">
                    <th>Zona</th><th>Precio</th></tr></thead><tbody>`;
            if(data.length == 0){
                tabla_zonas += `<tr>
                    <td colspan="2">No se encontraron registros</td>
                </tr>`;
            }else{
                for(var i = 0; i < data.length; i++){
                    arreglo_zonas.push(data[i].idz);
                    tabla_zonas += `<tr>
                        <td>${data[i].nombre}</td>
                        <td>
                            <input type="number" class="form-control" id="${data[i].idz}" min="0.1">
                            <input type="hidden" class="form-control" id="${data[i].idz}_zona_formato" value="${data[i].idz}">
                        </td>
                    </tr>`;
                }
                tabla_zonas += `</tbody></table>`;
            }
            $("#detalleFormato").html(tabla_zonas);
        }
    });
}

function mostrarZonasFormatoAEditar(){
    arreglo_zonas = [];
    let contador_agregar = 0;
    let id_formato_seleccionado = $("#sltFormato").val();
    $("#detalleFormato").html("");
    $.ajax({
        type: "POST",
        url: "{{ url('mostrar_zonas_agregadas') }}",
        data: {
            id_formato: id_formato_seleccionado,
            id_evento : id_evento
        },
        dataType: 'json',
        success: function(data){
            console.log('Success:', data);
            let tabla_zonas = "";
            tabla_zonas += `<table class="table table-bordered mt-2 text-center">
            <thead>
                <tr class="bg-primary text-white text-center">
                    <th>Zona</th><th>Precio</th><th>Acción</th></tr></thead><tbody>`;
            if(data.length == 0){
                $("#sltFormato").prop('disabled', false);
                $("#sltFormato").val("");
                tabla_zonas += `<tr>
                    <td colspan="2">No se encontraron registros</td>
                </tr>`;
            }else{
                $("#sltFormato").prop('disabled', true);
                for(var i = 0; i < data.length; i++){
                    arreglo_zonas.push(data[i].idz);
                    tabla_zonas += `<tr>
                        <td>${data[i].nombre}</td>
                        <td>`;

                    if(data[i].precio > 0){
                        tabla_zonas += `<input type="number" class="form-control" id="${data[i].idz}" readonly disabled placeholder='${data[i].precio}' min="0.1">`;
                        contador_agregar++;
                    }else{
                        tabla_zonas += `<input type="number" class="form-control" id="${data[i].idz}" min="0.1">
                        <input type="hidden" class="form-control" id="${data[i].idz}_zona_formato" value="${data[i].idzf}">`;
                    }
                    tabla_zonas += `</td>`;
                    if(data[i].precio > 0){
                        tabla_zonas += `<td><button class="btn btn-danger btn-sm" title="Eliminar Zona" onclick="EliminarZona(${data[i].id_evento_zona})"><i class="mdi mdi-minus"></i></button></td>`;
                    }else{
                        tabla_zonas += `<td></td>`;
                    }
                    tabla_zonas += `</tr>`;
                }
                if(contador_agregar == 0){
                    $("#sltFormato").prop('disabled', false);
                }
                tabla_zonas += `</tbody></table>`;
            }
            $("#detalleFormato").html(tabla_zonas);
        }
    });
}

function deshabilitarEvento(id){
    Swal.fire({
        title: '¿Desea deshabilitar el evento?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'bg-danger',
            cancelButton: 'bg-secondary'
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ url('deshabilitar_evento') }}",
                data: {
                    id_evento: id
                },
                dataType: 'json',
                success: function(data){
                    console.log('Success:', data);
                    mensajeExito("Éxito", "Se realizaron los cambios");
                    tablaEventos.clear().draw();
                    tablaEventos.ajax.reload();
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            console.log('Cancelado');
        }
    });
}

function EliminarZona(id){
    $.ajax({
        type: "POST",
        url: "{{ url('eliminar_evento_zona') }}",
        data: {
            id_evento_zona: id
        },
        dataType: 'json',
        success: function(data){
            console.log('Success:', data);
            mensajeExito("Éxito", "Se realizaron los cambios");
            mostrarZonasFormatoAEditar();
        }
    });
}

function mensajeError(titulo, texto){
    Swal.fire({
        title: '¡' + titulo + '!',
        text: texto,
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000, // Duración en milisegundos
        customClass: {
            title: 'toast-error-title',
            popup: 'toast-error-popup',
            icon: 'toast-error-icon'
        }
    });
}

function mensajeExito(titulo, texto){
    Swal.fire({
        title: '¡'+titulo+'!',
        text: texto,
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000 // Duración en milisegundos
    });
}

function reservaciones(idEventos){
    //abrir una nueva pestana
    window.open("eventos.detalleEvento?id=" + idEventos, "_blank");
}
</script>
@endsection
