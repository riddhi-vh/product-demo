@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
            </div>
            <div class="" id="">
            <ul class="navbar-nav me-auto">
            @if (Route::has('products.index'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">{{ __('Product') }}</a>
                </li>
            @endif
            </ul>
        </div>
        </div>
    </div>
</div>
@endsection
