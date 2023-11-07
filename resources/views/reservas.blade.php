@extends('layouts.master')
@section('title')
    Dashboards
@endsection
@section('css')
	<link href="{{ URL::asset('style.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card mt-n4 mx-n0">
                <div class="bg-soft-light">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img class="rounded-start img-fluid h-100 object-cover" src="{{URL::asset('storage/img_eventos/' . $event->ruta_imagen )}}" alt="Card image">
                        </div>
                        <div class="col-md-10">

                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">
                            <div class="col-md">
                                <div class="row align-items-center g-3">

                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{$event->evento}}</h4>
                                            <div><i class="mdi mdi-stadium-variant align-bottom me-1"></i> Lugar: MULTIEVENTOS POMA, CENTRO DE SAN SALVADOR
                                            </div>
                                            <div><i class="mdi mdi-calendar-clock align-bottom me-1"></i> Fecha: <span
                                                    class="fw-medium">{{$event->fecha}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div></div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Compra de boletos</h4>
                </div>
                <div class="card-body form-steps">
                    <form class="vertical-navs-step">
                        @csrf
                        <div class="row gy-5">
                            <div class="col-lg-3">
                                <div class="nav flex-column custom-nav nav-pills" role="tablist"
                                     aria-orientation="vertical">
                                    <button class="nav-link active" id="v-pills-bill-info-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-bill-info" type="button" role="tab"
                                            aria-controls="v-pills-bill-info" aria-selected="true">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Paso 1
                                    </span>
                                        Asientos
                                    </button>
                                    <button class="nav-link" id="v-pills-bill-address-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-bill-address" type="button" role="tab"
                                            aria-controls="v-pills-bill-address" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Paso 2
                                    </span>
                                        Informacion del usuario
                                    </button>
                                    <button class="nav-link" id="v-pills-finish-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-finish" type="button" role="tab"
                                            aria-controls="v-pills-finish" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Paso 4
                                    </span>
                                        Terminar
                                    </button>
                                </div>
                                <!-- end nav -->
                            </div>
                            <div class="col-lg-6">
                                <div class="px-lg-4">
                                    <div class="tab-content">
                                        <div class="tab-pane fade  show active" id="v-pills-bill-info" role="tabpanel"
                                             aria-labelledby="v-pills-bill-info-tab">
                                            <div>
                                                <h5>Elija sus asientos</h5>
                                                <span id="choose-seats" style="color:red;"></span>
                                            </div>
                                            <div>
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <select class="form-select mb-3" aria-label="Default select example"
                                                                name="zona" id="select-location-id">
                                                            <option selected>Seleccione la localidad</option>
                                                            @foreach($zonas as $zona)
                                                                <option value="{{ $zona->id }}">{{ $zona->nombre }} - ${{$zona->precio}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <button onclick="showModal()" type="button" class="btn btn-primary " data-bs-target="#myModal"  id="btnAgregarAsiento" disabled>Agregar asiento</button>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#Boleto</th>
                                                                <th>Zona</th>
                                                                <th>Asiento</th>
                                                                <th>Accion</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button"
                                                        onclick="guardarInformacion()"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        ><i

                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Informacion del usuario

                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="v-pills-bill-address" role="tabpanel"
                                             aria-labelledby="v-pills-bill-address-tab">
                                            <div>
                                                <h5>Informacion del usuario</h5>
                                            </div>

                                            <div>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="dui" class="form-label">Dui</label>
                                                        <input type="text" class="form-control" id="dui"
                                                               placeholder="05125669-8" required>
                                                        <div class="invalid-feedback">Por favor ingrese su telefono</div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="telefono" class="form-label">Telefono </label>
                                                        <input type="text" class="form-control" id="telefono"
                                                               placeholder="7898-6985"/>
                                                    </div>
                                                        <div class="col-12">
                                                            <label for="email" class="form-label">Email </label>
                                                            <input type="text" class="form-control" id="email"
                                                                   placeholder="example@test.com"/>
                                                        </div>
                                                </div>
                                                <hr class="my-4 text-muted">
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab"
                                                        data-previous="v-pills-bill-info-tab"><i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to Billing Info
                                                </button>
                                                <button type="button"
                                                        onclick="saveReserva()"
                                                        id="btnGuardarReserva"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="v-pills-finish-tab"><i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                    to Payment
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="v-pills-finish" role="tabpanel"
                                             aria-labelledby="v-pills-bill-address">
                                            <div class="text-center pt-4 pb-2">

                                                <div class="mb-4">
                                                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json"
                                                               trigger="loop" colors="primary:#0ab39c,secondary:#405189"
                                                               style="width:120px;height:120px"></lord-icon>
                                                </div>
                                                <h5>Your Order is Completed !</h5>
                                                <p class="text-muted">You Will receive an order confirmation email with
                                                    details of your order.</p>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </div>
                            </div>

                            <div class="col-lg-3" id="cart-element" style="display:none;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fs-14 text-primary mb-0"><i
                                            class="ri-shopping-cart-fill align-middle me-2"></i> Tu carrito</h5>
                                    <span class="badge bg-danger rounded-pill">3</span>
                                </div>
                                <ul class="list-group mb-3" id="tabla-carrito">
                                </ul>
                            </div>
							<div class="col-lg-3 image-location" id="location-element">
								<img src="/images/location.jpeg" alt="location">
                            </div>
                        </div>
                        <!-- end row -->
                    </form>
                </div>
            </div>
        </div>
    </div>
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Agregar asiento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="lastName" class="form-label">Fila</label>
                                    <select class="form-select mb-3" aria-label="Default select example"
                                            name="fila" id="select-fila-id">
                                        <option value='' selected>Seleccione la fila</option>

                                    </select>
                                    </div>
                                <div class="col-sm-6">
                                            <label for="lastName" class="form-label">Asiento</label>
                                            <select class="form-select mb-3" aria-label="Default select example"
                                                    name="asiento" id="select-asiento-id">
                                                <option value='' selected>Seleccione el asiento</option>

                                            </select>

                                </div>
                                <span class="col-sm-9" style="color:red;" id="error-asiento"></span>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="modalButton">Save Changes</button>
                            </div>

                        </div>
                    </div>
                </div>

@endsection
@section('script')
        <script>
            const MAX_ASIENTOS = 5;
            const MODAL_OPTIONS = ['vip', 'platinum'];
            const selectLocation = document.querySelector("#select-location-id");
            const btnAgregarAsiento = document.querySelector("#btnAgregarAsiento");
            const selectFila = document.querySelector("#select-fila-id");
            const selectAsiento = document.querySelector("#select-asiento-id");
            const errorAsientos = document.querySelector("#error-asiento");
            const errorMaxAsientos = document.querySelector("#choose-seats");
            const btnFirstStep = document.querySelector("#v-pills-bill-address-tab");
            let reservas = [];
            const dui = document.querySelector("#dui");
            const telefono = document.querySelector("#telefono");
            const email = document.querySelector("#email");

            const modal = new bootstrap.Modal(document.getElementById('myModal'));
            const zonasJson = @json($zonas);

            function handleFirstStep(e){
                e.preventDefault();
                console.log('handleFirstStep()');
            }

            selectLocation.addEventListener("change", async () => {
                if (selectLocation.value !== "Seleccione la localidad") {
                    btnAgregarAsiento.removeAttribute("disabled");
                    const response = await fetch(`/filas/${selectLocation.value}`);
                    const data = await response.json();
                    selectFila.innerHTML = "";
                    const defaultOptions = document.createElement("option");
                    defaultOptions.value = '';
                    defaultOptions.text = 'Seleccione la fila';
                    defaultOptions.selected=true;
                    selectFila.appendChild(defaultOptions);
                    data.forEach((fila) => {
                        const option = document.createElement("option");
                        option.value = fila.fila;
                        option.text = fila.fila;
                        selectFila.appendChild(option);
                    });
                } else {
                    btnAgregarAsiento.setAttribute("disabled", "disabled");
                }
            });

            selectFila.addEventListener("change", async () => {
                const filaSeleccionada = selectFila.value;
                if (filaSeleccionada && filaSeleccionada !== "Seleccione la fila") {
                    const zonaSeleccionada = selectLocation.value;
                    const response = await fetch(`/asientos/${zonaSeleccionada}/${filaSeleccionada}`);
                    const allSeats = await response.json();

                    const data = allSeats.filter((asiento) => !reservas.some((reserva) => +reserva.boleto === +asiento.id));

                    selectAsiento.innerHTML = "";
                    const defaultOption = document.createElement("option");
                    defaultOption.value = '';
                    defaultOption.text = 'Seleccione el asiento';
                    defaultOption.selected=true;
                    selectAsiento.appendChild(defaultOption);
                    data.forEach((asiento) => {
                        const option = document.createElement("option");
                        option.value = asiento.id;
                        option.text = asiento.numero;
                        selectAsiento.appendChild(option);
                    });
                }
            });

            document.getElementById("modalButton").addEventListener("click", async () => {
                if (!selectLocation.value || isNaN(selectLocation.value) || !selectFila.value || isNaN(selectFila.value) || !selectAsiento.value || isNaN(selectAsiento.value)) {
                    errorAsientos.textContent = "Debe seleccionar fila y asiento";
                    return;
                }
                errorAsientos.textContent = "";
                const zona = selectLocation.options[selectLocation.selectedIndex];
                const asiento = selectAsiento.options[selectAsiento.selectedIndex];

                reservas.push({
                    zona: selectLocation.value,
                    zonaName: zona.textContent,
                    fila: selectFila.value,
                    asiento: asiento.textContent,
                    boleto: selectAsiento.value,
                });

                actualizarTabla();
                modal.hide();
                selectAsiento.value = "";
                selectFila.value = "";
            });

            async function showModal(){
                errorMaxAsientos.textContent = "";
                if (reservas.length >= MAX_ASIENTOS) {
                    errorMaxAsientos.textContent =`Solo puede reservar ${MAX_ASIENTOS} asientos`;
                    return;
                }
                const option = selectLocation.options[selectLocation.selectedIndex];
                if (!MODAL_OPTIONS.some((value) => option.innerHTML.toLowerCase().includes(value))) {
                    btnAgregarAsiento.setAttribute("disabled", "disabled");
                    const response = await fetch(`/asiento-evento/${selectLocation.value}`);
                    const data = await response.json()
                    const asientoSeleccionado = data.filter((asiento) => !reservas.some((reserva) => reserva.boleto === asiento.id))[0];
                    if (asientoSeleccionado) {
                        reservas.push({
                            zona: selectLocation.value,
                            zonaName: option.textContent,
                            fila: asientoSeleccionado.fila,
                            asiento: asientoSeleccionado.numero,
                            boleto: asientoSeleccionado.id,
                        });
                        actualizarTabla();
                    }
                    btnAgregarAsiento.removeAttribute("disabled");
                    return;
                }
                modal.show();
            }

            function actualizarTabla() {
                const tabla = document.getElementById("alternative-pagination").getElementsByTagName('tbody')[0];
                tabla.innerHTML = "";

                for (const reserva of reservas) {
                    const fila = tabla.insertRow();
                    const numero = fila.insertCell(0);
                    const zona = fila.insertCell(1);
                    const asiento = fila.insertCell(2);
                    const accion = fila.insertCell(3);
                    // document.create button
                    const button = document.createElement("button");
                    const iElement = document.createElement("i");
                    iElement.classList.add("label-icon", "align-middle", "fs-16", "bx", "bxs-trash");
                    button.appendChild(iElement);
                    button.classList.add("btn", "btn-danger");
                    button.addEventListener("click", () => {
                        const currentReservas = reservas.filter((r) => r.boleto !== reserva.boleto);
                        reservas = currentReservas;
                        actualizarTabla();
                    });
                    accion.appendChild(button);

                    numero.innerHTML = reserva.boleto;
                    zona.innerHTML = reserva.zonaName;
                    asiento.innerHTML = `${reserva.fila}-${reserva.asiento}`;
                }
            }

            function updateCarrito() {
                const tabla = document.getElementById("tabla-carrito");
                tabla.innerHTML = "";
                let total = 0;

                for (const reserva of reservas) {
                    const currentZona = zonasJson.find((zona) => zona.id === +reserva.zona);
                    const precio = +currentZona.precio || 0;
                    total += precio;
                    const zonaName = currentZona.nombre || reserva.zonaName || "";
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "d-flex", "justify-content-between", "lh-sm");
                    const div = document.createElement("div");
                    const h6 = document.createElement("h6");
                    h6.classList.add("my-0");
                    h6.textContent = zonaName;
                    const small = document.createElement("small");
                    small.classList.add("text-muted");
                    small.textContent = `${reserva.fila}-${reserva.asiento}`;
                    div.appendChild(h6);
                    div.appendChild(small);
                    const span = document.createElement("span");
                    span.classList.add("text-muted");
                    span.textContent = `$${precio}`;
                    li.appendChild(div);
                    li.appendChild(span);
                    tabla.appendChild(li);
                }
                const li = document.createElement("li");
                li.classList.add("list-group-item", "d-flex", "justify-content-between");
                const span = document.createElement("span");
                span.textContent = "Total (USD)";
                const strong = document.createElement("strong");
                strong.textContent = `$${total}`;
                li.appendChild(span);
                li.appendChild(strong);
                tabla.appendChild(li);
            }

            function guardarInformacion(){
                if (reservas.length === 0) {
                    errorMaxAsientos.textContent = "Debe seleccionar al menos un asiento";
                    return;
                }
                btnFirstStep.click();
                updateCarrito();
            }
            async function saveReserva(){
                // disable btnGuardarReserva
                document.getElementById("btnGuardarReserva").setAttribute("disabled", "disabled");
                // get values of dui, telefono, email
                const duiValue = dui.value;
                const telefonoValue = telefono.value;
                const emailValue = email.value;
                // validate values
                if (!duiValue || !telefonoValue || !emailValue) {
                    return;
                }
                // validate reservas length
                if (reservas.length === 0) {
                    return;
                }
                // post request to save reserva
                const bodyReserva = {
                    dui: duiValue,
                    telefono: telefonoValue,
                    email: emailValue,
                    reservas: reservas.map((reserva) => ({
                        id_boleto: reserva.boleto,
                        id_zona: reserva.zona,
                        fila: reserva.fila,
                        numero: reserva.asiento,
                    })),
                };
                // post to the endpoint /create/reserva
                try {
                    const response = await fetch('/create/reserva', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(bodyReserva),
                    });
                    const data = await response.json();
                    console.log('Success:', data);
                    // redirect to /reservas
                    window.location.href = window.location.origin;

                } catch (error) {
                    console.error('Error:', error);
                    console.error('Error:', error.message);
                }
                // enable btnGuardarReserva
                document.getElementById("btnGuardarReserva").removeAttribute("disabled");

            }
        </script>
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/apps-nft-explore.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

	<script src="{{ URL::asset('scripts/reservas.js') }}"></script>
@endsection
