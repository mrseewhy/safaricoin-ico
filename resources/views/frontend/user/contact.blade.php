@extends('frontend.layouts.app')

@section('content')
    <script src='/js/cryptobox.min.js' type='text/javascript'></script>

    <div class="box-static box-bordered p-30">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                {{ __('labels.frontend.contact.box_title') }}
            </h2>
        </div>
        {{ html()->form('POST', route('frontend.user.contact.send'))->open() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                    {{ html()->email('email')
                        ->class('form-control')
                        ->attribute('maxlength', 191)
                        ->attribute('disabled')
                        ->value($logged_in_user->email)
                        ->required() }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('Transaction ID'))->for('transaction_id') }}

                    {{ html()->text('transaction_id')
                        ->class('form-control') }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('Transaction Hash'))->for('transaction_hash') }}

                    {{ html()->text('transaction_hash')
                        ->class('form-control') }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.message'))->for('message') }}

                    {{ html()->textarea('message')
                        ->class('form-control')
                        ->placeholder(__('validation.attributes.frontend.message'))
                        ->required()
                        ->attribute('rows', 3) }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group mb-0 clearfix">
                    {{ form_submit(__('labels.frontend.contact.button')) }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
        {{ html()->form()->close() }}
    </div>



@endsection
