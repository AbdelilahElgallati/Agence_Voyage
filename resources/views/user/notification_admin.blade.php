@extends('layouts.app_admin')

@section('content')
    <div class="container" style="margin-top: 50px;">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute; margin-top: 1rem; margin-left: 12%; width: 65%;">
                <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; margin-top: 1rem; margin-left: 12%; width: 65%;">
                <strong>Success:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <hr>
            <div class="card-header text-center" style="font-weight: 600;font-style: italic;font-size: xx-large;">{{ __('Notifications d\'administration') }}</div>
        <hr>

        {{-- @foreach ($notifications as $notification)
            <div class="notification card" style="background-color: #f8f9fa;border: 1px solid #dee2e6;padding: 10px;margin-bottom: 10px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $notification->message }}</h5>
                    <p class="card-text text-muted">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @endforeach --}}

        <div class="timeline">
            @foreach ($notifications as $notification)
                <div class="timeline__event  animated fadeInUp delay-3s timeline__event--type1">
                    <div class="timeline__event__icon ">
                        <i class="lni-sport"></i>
                    </div>
                    <div class="timeline__event__date">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                    <div class="timeline__event__content ">
                        <div class="timeline__event__description">
                            <p>{{ $notification->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


