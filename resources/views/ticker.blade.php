@extends('layouts.app')

@section('content')
<article class="row mt-4">
    <div class="col-lg-8 mx-auto">

       

      @include('widget-ticker')

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="/" class="btn btn-outline-dark rounded-pill px-4">&larr; Kembali ke Beranda</a>
            <div>
                <button class="btn btn-light rounded-circle shadow-sm me-2">🔗</button>
                <button class="btn btn-light rounded-circle shadow-sm">🐦</button>
            </div>
        </div>

    </div>
</article>
@endsection