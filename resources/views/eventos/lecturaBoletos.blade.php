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
            Lectura de Eventos
        @endslot
    @endcomponent
    @php
        $user = Auth::user();
    @endphp
    <div class="row justify-content-center mt-5">
    <div class="col-sm-4 shadow p-3">
      <h5 class="text-center">Escanear codigo QR</h5>
      <div class="row text-center">
        <a id="btn-scan-qr" href="#">
          <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg" class="img-fluid text-center" width="175">
        </a>
        <canvas hidden="" id="qr-canvas" class="img-fluid"></canvas>
        </div>
        <div class="row mx-5 my-3">
        <button class="btn btn-success btn-sm rounded-3 mb-2" onclick="encenderCamara()">Encender camara</button>
        <button class="btn btn-danger btn-sm rounded-3" onclick="cerrarCamara()">Detener camara</button>
      </div>
    </div>
  </div>


  <div class="modal fade" id="mostrarDatos" tabindex="-1" aria-labelledby="mostrarDatos" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DETALLE DE BOLETO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
            <tr>
                <td class="text-bold bg-info text-white">Nombre Evento</td>
                <td id="nombre_evento"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">DUi</td>
                <td id="dui"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">Telefono</td>
                <td id="telefono"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">Email</td>
                <td id="email"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">Boleto</td>
                <td id="id_boleto"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">Asiento</td>
                <td id="asiento"></td>
            </tr>
            <tr>
                <td class="text-bold bg-info text-white">Fila</td>
                <td id="fila"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerra</button>
        <button type="button" class="btn btn-primary" id="btnGuardarLectura">Guardar Lectura</button>
      </div>
    </div>
  </div>
</div>
  
  <audio id="audioScaner" src="assets/sonido.mp3"></audio>


    <!-- MODAL PARA AGREGAR O EDITAR EVENTOS -->

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-masks.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
    <script src="{{ URL::asset('build/js/qrCode.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/lectorBoletos.js') }}"></script>
@endsection
