@extends ('backend.layouts.app')

@section ('title', __('Withdraw BTC'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('BTC Withdraw') }}
                    </h4>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col" id="vue-app">
                    <withdraw></withdraw>
                </div>
            </div>

        </div>
    </div>
@endsection
