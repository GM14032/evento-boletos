@extends('layouts.master')
@section('title')
Dashboards
@endsection
@section('css')

@endsection
@section('content')

    <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1" id="">
        @foreach($events as $event)
        <div class="col list-element">
            <div class="card explore-box card-animate">
                <div class="explore-place-bid-img">
                    <input type="hidden" class="form-control" id="'+ prodctData.id + '">
                    <div class="d-none">'+ prodctData.salesType + '</div>
                    <img src="{{URL::asset('storage/img_eventos/' . $event->ruta_imagen )}}" alt="" class="card-img-top explore-img" />
                    <div class="bg-overlay"></div>
                    <div class="place-bid-btn">
                        <a href="{{ route('reservas', ['id' => $event->id]) }} " class="btn btn-success"><i class="ri-auction-fill align-bottom me-1"></i> Comprar</a>
                    </div>
                </div>
                <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                    <button type="button" class="btn btn-icon '+ likeBtn + '" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                </div>
                <div class="card-body">
                    <p class="fw-medium mb-0 float-end"><i class="mdi mdi-heart text-danger align-middle"></i> 350 </p>
                    <h5 class="mb-1"><a href="apps-nft-item-details">{{$event->evento }}</a></h5>
                    <p class="text-muted mb-0">{{$event->fecha }}</p>
                </div>
                <div class="card-footer border-top border-top-dashed">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 fs-14">
                            <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> Capacidad: <span class="fw-medium">{{$event->capacidad}}</span>
                        </div>
                        <h5 class="flex-shrink-0 fs-14 text-primary mb-0">360</h5>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
@section('script')

    <script src="{{ URL::asset('build/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/wnumb/wNumb.min.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/apps-nft-explore.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
