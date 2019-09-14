<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', '')">
        <meta name="author" content="@yield('meta_author', '')">
        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
        @stack('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ style(mix('css/frontend.css')) }}

        @stack('after-styles')
    </head>
    <body id="page-top">
        <div id="app">
            @include('frontend.includes.nav')
            @include('includes.partials.logged-in-as')

            @if(!Active::checkRoute('frontend.index'))
                <div class="nav-spacer"></div>
                <div class="container">
                    @include('includes.partials.messages')
            @endif
            @yield('content')
            @if(!Active::checkRoute('frontend.index'))
                </div>
            @endif
            <footer>
                <div class="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                Copyright &copy; {{ env('APP_NAME') }} 2017
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <ul class="list-inline quicklinks">
                                    <li class="list-inline-item">
                                        <a href="#">Privacy Policy</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#">Terms of Use</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div><!-- #app -->

        <!-- Scripts -->
        @stack('before-scripts')
        {!! script(mix('js/frontend.js')) !!}
        @stack('after-scripts')

        @include('includes.partials.ga')
        @yield('scripts')
    </body>
</html>
