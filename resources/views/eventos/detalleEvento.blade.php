<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visualizacion de Eventos</title>
    <script src="{{ URL::asset('build/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('build/css/bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('build/css/app.min.css') }}"  rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ URL::asset('build/css/custom.min.css') }}"  rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="build/libs/sweetalert2/sweetalert2.min.css">

    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        .escenario {
            height: 50px;
            vertical-align: middle;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .platinum-es {
            margin-top: 40px;
            height: 230px;
            margin-right: 2%;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .vip {
            height: 230px;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .platinum-os {
            margin-top: 40px;
            height: 230px;
            margin-left: 2%;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .tribuna-es{
            margin-top: 20px;
            height: 230px;
            margin-left: 2%;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .tribuna-os{
            margin-top: 20px;
            height: 230px;
            margin-left: 2%;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .general{
            margin-top: 20px;
            height: 230px;
            margin-left: 2%;
            align-content: center;
            justify-content: center;
            vertical-align: middle;
            align-items: center;
            font-size: 180% !important;
            border-radius: 10px;
            border: 1px solid #000;
        }
        .asiento{
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <div class="" style="width: 100% !important">
        <h1 id="nombreEvento" class="text-center"></h1>
        <p class="text-center">
            <i class="mdi mdi-seat asiento text-success"></i> Disponible&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="mdi mdi-seat asiento text-danger"></i> Leido&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="mdi mdi-seat asiento text-secondary"></i> Reservado&nbsp;&nbsp;&nbsp;&nbsp;
        </p>
    </div>
    <input type="hidden" name="txtId" id="txtId" value="<?php echo $_GET['id']; ?>">

    <div class="container">
        <div class="row" style="align-items: center;justify-content: center">
            <div class="col-md-3 escenario">
                <h2 style="align-items: center">Escenario</h2>
            </div>
        </div>

        <div class="row" style="align-items: center;justify-content: center">
            <div class="platinum-es text-center" style="width: 32% !important">
                <p>Platinum Este</p>
            </div>
            <div class="vip text-center" style="width: 32% !important">
                <p>Vip</p>
            </div>
            <div class="platinum-os text-center" style="width: 32% !important">
                <p>Platinum Oeste</p>
            </div>
        </div>

        <div class="row" style="align-items: center;justify-content: center">
            <div class="tribuna-es text-center" style="width: 46% !important">
                <p>Tribuna Este</p>
            </div>
            <div class="tribuna-os text-center" style="width: 46% !important">
                <p>Tribuna Oeste</p>
            </div>
        </div>

        <div class="row">
            <div style="width:15% !important"></div>
            <div class="general text-center" style="width:70% !important">
                <p>General</p>
            </div>
            <div style="width:15% !important"></div>
        </div>
    </div>

</body>
</html>


<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        ObtenerNombreEvento();
        cargarValorInput();
        cargarAsientosVip();
        cargarAsientosPlatinumEs();
        cargarAsientosPlatinumOs();
        cargarAsientosTribunaEs();
        cargarAsientosTribunaOs();
        cargarAsientosGeneral();

        setInterval(function() {
            obtenerEstadoAsientos();
        }, 5000);

    });

    var id=null;

    function cargarValorInput() {
        var id = $("#txtId").val();
    }

    function cargarAsientosVip(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%5==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }

                }
                $(".vip").append(asientos);
            }
        });
    }

    function cargarAsientosPlatinumEs(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 4,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%5==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }

                }
                $(".platinum-es").append(asientos);
            }
        });
    }

    function cargarAsientosPlatinumOs(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 5,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%5==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }
                }
                $(".platinum-os").append(asientos);
            }
        });
    }

    function cargarAsientosTribunaEs(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 2,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%10==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }

                }
                $(".tribuna-es").append(asientos);
            }
        });
    }

    function cargarAsientosTribunaOs(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 3,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%10==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }

                }
                $(".tribuna-os").append(asientos);
            }
        });
    }

    function cargarAsientosGeneral(){
        let asientos = '';

        $.ajax({
            type: "POST",
            url: "{{ url('cargar_asientos_vip') }}",
            data: {
                id_zona: 6,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(i%20==0 && i!=0){
                        asientos+=`<br>
                        <i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }else{
                        asientos+=`<i class="mdi mdi-seat asiento text-success" id="${data[i].numero}"></i>`;
                    }

                }
                $(".general").append(asientos);
            }
        });
    }

    function ObtenerNombreEvento(){
        let id = $("#txtId").val();
        $.ajax({
            type: "POST",
            url: "{{ url('obtener_nombre_evento') }}",
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                // console.log(data.evento);
                $("#nombreEvento").html(data.evento);
            }
        });
    }

    function obtenerEstadoAsientos(){
        $.ajax({
            type: "POST",
            url: "{{ url('obtener_estados_asientos') }}",
            data: {
                id_evento: $("#txtId").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data){
                for(let i = 0; i < data.length; i++){
                    if(data[i].reservado == 1){
                        $(`#${data[i].numero}`).removeClass('text-danger');
                        $(`#${data[i].numero}`).removeClass('text-success');
                        $(`#${data[i].numero}`).addClass('text-secondary');
                    }else if(data[i].leido == 1){
                        $(`#${data[i].numero}`).removeClass('text-secondary');
                        $(`#${data[i].numero}`).removeClass('text-success');
                        $(`#${data[i].numero}`).addClass('text-danger');
                    }else{
                        $(`#${data[i].numero}`).removeClass('text-secondary');
                        $(`#${data[i].numero}`).removeClass('text-danger');
                        $(`#${data[i].numero}`).addClass('text-success');
                    }
                }
            }
        });
    }

</script>
