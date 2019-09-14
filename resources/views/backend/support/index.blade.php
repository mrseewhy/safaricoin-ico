@extends ('backend.layouts.app')

@section ('title', __('Support'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('Support') }}
                    </h4>
                </div>
            </div><!--row-->

            <div class="row mt-4">
                <div class="col" id="vue-app">
                    <support></support>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
@endsection
