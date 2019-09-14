@extends('frontend.layouts.app')



@section('title', app_name() . ' | Register')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="box-static box-bordered p-30">
                <div class="box-title mb-30">
                    <h2 class="fs-20">Don't have an account yet?</h2>
                </div>

                {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                            {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.first_name'))
                                ->attribute('maxlength', 191) }}
                        </div><!--col-->
                    </div><!--row-->

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                            {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.last_name'))
                                ->attribute('maxlength', 191) }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.email'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                            {{ html()->password('password')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.password'))
                                ->required() }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                            {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                ->required() }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                @if (config('access.captcha.registration'))
                    <div class="row">
                        <div class="col">
                            {!! Captcha::display() !!}
                            {{ html()->hidden('captcha_status', 'true') }}
                        </div><!--col-->
                    </div><!--row-->
                @endif

                <div class="row">
                    <div class="col">
                        <div class="form-group mb-0 clearfix">
                            {{ form_submit(__('labels.frontend.auth.register_button')) }}
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->
                {{ html()->form()->close() }}
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            {!! $socialiteLinks !!}
                        </div>
                    </div><!--/ .col -->
                </div><!-- / .row -->
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endpush
