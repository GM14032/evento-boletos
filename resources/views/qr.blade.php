<!DOCTYPE html>
<html>
<head>
    <title>Códigos QR</title>
</head>
<body>
<div style="text-align: center;">
    @foreach ($reservas as $key => $reserva)
        <div style="margin-bottom: 32px;">
            <div style="float: left; margin-right: 32px;">
                <img src="data:image/png;base64,{{ $qrCodes[$key] }}" style="max-width: 250px; max-height: 250px; object-fit: cover;" alt="qr de la reserva">
            </div>
            <div style="float: left;">
                <div>
                    <strong>Nombre del Evento</strong>
                    <span>{{$event->evento}}</span>
                </div>
                <div>
                    <strong>Zona y Precio</strong>
                    <span>{{$event->nombre}} - {{$event->precio}}</span>
                </div>
                <div>
                    <strong>Asiento</strong>
                    <span>{{$reserva['fila']}}-{{$reserva['numero']}}</span>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    @endforeach
</div>
</body>
</html>
