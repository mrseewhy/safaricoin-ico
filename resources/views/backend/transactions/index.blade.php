@extends ('backend.layouts.app')

@section ('title', __('Transactions'))

@section('content')
    <script>
        window.currencyShort = '{{ env('COIN_NAME_SHORT') }}';
    </script>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('Transactions') }}
                    </h4>
                </div>
            </div><!--row-->

            <div class="row mt-4">
                <div class="col" id="vue-app">
                    <transactions></transactions>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
@endsection
