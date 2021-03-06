@extends('frontend.layouts.app')

@section('title', app_name() . ' | Reset Password')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-6 align-self-center">
            <div class="box-static box-bordered p-30">
                <div class="box-title mb-30">
                    <h2 class="fs-20">{{ __('labels.frontend.passwords.reset_password_box_title') }}</h2>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.email'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group mb-0 clearfix">
                            {{ form_submit(__('labels.frontend.passwords.send_password_reset_link_button')) }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->
                {{ html()->form()->close() }}
            </div>
        </div><!-- col-6 -->
    </div><!-- row -->
@endsection
