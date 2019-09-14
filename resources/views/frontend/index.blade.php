@extends('frontend.layouts.app')

@section('content')
    <!-- Header -->
    <header class="masthead" id="slider">
        <span class="overlay dark-2"></span>
        <canvas v-pre id="canvas-particle" data-rgb="156,217,249"></canvas>
        <div class="container d-flex justify-content-center" style="height: 100%;position:relative;z-index:15;">
            <div class="intro-text align-self-center">
                <div class="intro-heading text-uppercase">{{ __("Welcome to") }} {{ app_name() }}</div>
                <div class="intro-lead-in">Trusted by <span style="color:#8ab933;">{{ rand(5000, 99999) }}</span> users!</div>
                <a class="btn btn-default btn-lg" href="{{ route("frontend.auth.register") }}">{{ __("Join now") }}</a>
            </div>
        </div>
    </header>

    <!-- Services -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">What is {{ app_name() }}?</h2>
                    <h3 class="section-subheading text-muted">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis diam dui, condimentum sit amet malesuada non, suscipit a ex. Aenean tristique in nibh ut vehicula. Donec at ornare mauris. Quisque sit amet tincidunt justo, et malesuada metus. Nam a lectus mi. Integer mauris erat, rutrum quis fringilla a, sagittis in sem. Maecenas odio metus, hendrerit eget scelerisque sed, pretium sodales nibh. Etiam euismod dolor a massa pretium imperdiet. Curabitur volutpat nulla in nibh rhoncus, id vestibulum velit convallis. Etiam molestie neque neque, et euismod nisl convallis non.
                    </h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Deposit Bitcoins</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Exchange Coins</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
            </span>
                    <h4 class="service-heading">Secure</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
