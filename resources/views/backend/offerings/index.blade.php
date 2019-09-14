@extends ('backend.layouts.app')

@section ('title', __('Offering rounds'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('Offering rounds') }}
                    </h4>
                </div>
                <div class="col-sm-7 text-right">
                    <a href="{{ route('admin.offerings.edit') }}" class="btn btn-success">
                        <i class="fa fa-plus-circle"></i> Add new round
                    </a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col" id="vue-app">
                    <offerings></offerings>
                </div>
            </div>

        </div>
    </div>
@endsection
