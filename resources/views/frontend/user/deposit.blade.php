@extends('frontend.layouts.app')

@section('content')
    <script src='/js/cryptobox.min.js' type='text/javascript'></script>

    <div class="box-static box-bordered p-30">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                Deposit BTC
            </h2>
        </div>

        {!! $cryptoBox->display_cryptobox(false, 580, 230) !!}

        <br>
        <a href="{{ route('frontend.user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>



@endsection
