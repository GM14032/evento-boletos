$(document).ready(function(){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("#btnGuardarLectura").click(function(){
    guardarLecturaBoleto();
  });
});
var idBoleto = "";
//crea elemento
const video = document.createElement("video");

//nuestro camvas
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

//div donde llegara nuestro canvas
const btnScanQR = document.getElementById("btn-scan-qr");

//lectura desactivada
let scanning = false;

//funcion para encender la camara
const encenderCamara = () => {
    navigator.mediaDevices
      .getUserMedia({ video: { facingMode: "environment" } })
      .then(function (stream) {
        scanning = true;
        btnScanQR.hidden = true;
        canvasElement.hidden = false;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.srcObject = stream;
        video.play();
        tick();
        scan();
      });
  };

//funciones para levantar las funiones de encendido de la camara
function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}

//apagara la camara
const cerrarCamara = () => {
  video.srcObject.getTracks().forEach((track) => {
    track.stop();
  });
  canvasElement.hidden = true;
  btnScanQR.hidden = false;
};

const activarSonido = () => {
  var audio = document.getElementById('');
  audio.play();
}

const arreglo = [];
//callback cuando termina de leer el codigo QR
qrcode.callback = (respuesta) => {
    if (respuesta) {
        const json = JSON.parse(respuesta);
        console.log(json);
        // cerrarCamara();   
        verificarLectura (json);
    }
};


function verificarLectura(json){
    $.ajax({
        type: "POST",
        url: "verificar_lectura",
        data: {
            id_boleto: json.id_boleto,
        },
        dataType: 'json',
        success: function (data) {
            if(data.estado || data.estado==1 || data.estado=="1"){
              $("#mostrarDatos").modal("show");
                  $("#nombre_evento").html(json.evento);
                  $("#telefono").html(json.telefono);
                  $("#email").html(json.email);
                  $("#dui").html(json.dui);
                  $("#id_boleto").html(json.id_boleto);
                  $("#asiento").html(json.asiento);
                  $("#fila").html(json.fila);
                  idBoleto = json.id_boleto;
            }else{
                mensajeError("Error",data.mensaje);
                return false;
            }
        }
    });
}

function guardarLecturaBoleto(){
  $.ajax({
    type: "POST",
    url: "guardar_lectura",
    data: {
        id_boleto: idBoleto,
    },
    dataType: 'json',
    success: function (data) {
        if(data.estado || data.estado==1 || data.estado=="1"){
          $("#mostrarDatos").modal("hide");
            $("#nombre_evento").html("");
            $("#telefono").html("");
            $("#email").html("");
            $("#dui").html("");
            $("#id_boleto").html("");
            $("#asiento").html("");
            $("#fila").html("");
            idBoleto = "";
            mensajeExito("Éxito",data.mensaje);
        }else{
            mensajeError("Error",data.mensaje);
            return false;
        }
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






