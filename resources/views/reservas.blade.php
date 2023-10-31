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
                                            <div><i class="mdi mdi-stadium-variant align-bottom me-1"></i> Lugar: Themesbrand
                                            </div>
                                            <div><i class="mdi mdi-calendar-clock align-bottom me-1"></i> Fecha: <span
                                                    class="fw-medium">15 Sep, 2021</span></div>
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
                                    <button class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-payment" type="button" role="tab"
                                            aria-controls="v-pills-payment" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Paso 3
                                    </span>
                                        Pago
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
                                                 </div>
                                            <div>
                                                <div class="row g-3">
                                                    <div class="col-sm-6">
                                                        <label for="lastName" class="form-label">Zona</label>
                                                        <select class="form-select mb-3" aria-label="Default select example"
                                                                name="zona" id="select-location-id">
                                                            <option selected>Seleccione la localidad</option>
                                                            @foreach($zonas as $zona)
                                                                <option value="{{ $zona->id }}">{{ $zona->nombre }} - ${{$zona->precio}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label for="lastName" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="cantidad"
                                                               placeholder="Cantidad"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="v-pills-bill-address-tab"><i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"
                                                        ></i>Go
                                                    to Shipping
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="v-pills-bill-address" role="tabpanel"
                                             aria-labelledby="v-pills-bill-address-tab">
                                            <div>
                                                <h5>Shipping Address</h5>
                                                <p class="text-muted">Fill all information below</p>
                                            </div>

                                            <div>
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="address" class="form-label">Address</label>
                                                        <input type="text" class="form-control" id="address"
                                                               placeholder="1234 Main St" required>
                                                        <div class="invalid-feedback">Please enter a address</div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="address2" class="form-label">Address 2 <span
                                                                class="text-muted">(Optional)</span></label>
                                                        <input type="text" class="form-control" id="address2"
                                                               placeholder="Apartment or suite"/>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label for="country" class="form-label">Country</label>
                                                        <select class="form-select" id="country" required>
                                                            <option value="">Choose...</option>
                                                            <option>United States</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a country</div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="state" class="form-label">State</label>
                                                        <select class="form-select" id="state">
                                                            <option value="">Choose...</option>
                                                            <option>California</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a state</div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="zip" class="form-label">Zip</label>
                                                        <input type="text" class="form-control" id="zip"
                                                               placeholder=""/>
                                                    </div>
                                                </div>

                                                <hr class="my-4 text-muted">

                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" id="same-address">
                                                    <label class="form-check-label" for="same-address">Shipping address
                                                        is the same as my billing address</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="save-info">
                                                    <label class="form-check-label" for="save-info">Save this
                                                        information for next time</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab"
                                                        data-previous="v-pills-bill-info-tab"><i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to Billing Info
                                                </button>
                                                <button type="button"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="v-pills-payment-tab"><i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                    to Payment
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="v-pills-payment" role="tabpanel"
                                             aria-labelledby="v-pills-payment-tab">
                                            <div>
                                                <h5>Payment</h5>
                                                <p class="text-muted">Fill all information below</p>
                                            </div>

                                            <div>
                                                <div class="my-3">
                                                    <div class="form-check form-check-inline">
                                                        <input id="credit" name="paymentMethod" type="radio"
                                                               class="form-check-input" checked required>
                                                        <label class="form-check-label" for="credit">Credit card</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input id="debit" name="paymentMethod" type="radio"
                                                               class="form-check-input" required>
                                                        <label class="form-check-label" for="debit">Debit card</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input id="paypal" name="paymentMethod" type="radio"
                                                               class="form-check-input" required>
                                                        <label class="form-check-label" for="paypal">PayPal</label>
                                                    </div>
                                                </div>

                                                <div class="row gy-3">
                                                    <div class="col-md-12">
                                                        <label for="cc-name" class="form-label">Name on card</label>
                                                        <input type="text" class="form-control" id="cc-name"
                                                               placeholder="" required>
                                                        <small class="text-muted">Full name as displayed on card</small>
                                                        <div class="invalid-feedback">
                                                            Name on card is required
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="cc-number" class="form-label">Credit card
                                                            number</label>
                                                        <input type="text" class="form-control" id="cc-number"
                                                               placeholder="" required>
                                                        <div class="invalid-feedback">
                                                            Credit card number is required
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="cc-expiration" class="form-label">Expiration</label>
                                                        <input type="text" class="form-control" id="cc-expiration"
                                                               placeholder="" required>
                                                        <div class="invalid-feedback">
                                                            Expiration date required
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="cc-cvv" class="form-label">CVV</label>
                                                        <input type="text" class="form-control" id="cc-cvv"
                                                               placeholder="" required>
                                                        <div class="invalid-feedback">
                                                            Security code required
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab"
                                                        data-previous="v-pills-bill-address-tab"><i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to Shipping Info
                                                </button>
                                                <button type="button"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="v-pills-finish-tab"><i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                                    Order Complete
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="v-pills-finish" role="tabpanel"
                                             aria-labelledby="v-pills-finish-tab">
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
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div>
                                            <h6 class="my-0">Product name</h6>
                                            <small class="text-muted">Brief description</small>
                                        </div>
                                        <span class="text-muted">$12</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total (USD)</span>
                                        <strong>$20</strong>
                                    </li>
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
            <!-- end -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')

    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/apps-nft-explore.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
	<script src="{{ URL::asset('scripts/reservas.js') }}"></script>
@endsection
