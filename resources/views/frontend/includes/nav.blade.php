<nav class="navbar navbar-expand-lg fixed-top {{ active_class(!Active::checkRoute('frontend.index'), 'bg-dark') }} d-flex justify-content-end" id="userNav">
    <ul class="top-links list-inline">
        @guest
            <li><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">{{ __('navs.frontend.login') }}</a></li>

            @if (config('access.registration'))
                <li><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">{{ __('navs.frontend.register') }}</a></li>
            @endif
        @else
            <li><a href="{{route('frontend.user.dashboard')}}" class="{{ active_class(Active::checkRoute('frontend.user.dashboard')) }}">{{ __('navs.frontend.dashboard') }}</a></li>
            <li>
                <a href="{{ route('frontend.user.account') }}" class="{{ active_class(Active::checkRoute('frontend.user.account')) }}">{{ __('navs.frontend.user.account') }}</a>
            </li>
            <li>
                <a href="{{ route('frontend.auth.logout') }}" class="dropdown-item">{{ __('navs.general.logout') }}</a>
            </li>
            @can('view backend')
                <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">{{ __('navs.frontend.user.administration') }}</a></li>
            @endcan
        @endguest
    </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top {{ active_class(!Active::checkRoute('frontend.index'), 'bg-dark') }}" id="mainNav">
    <a class="navbar-brand js-scroll-trigger" href="{{ route('frontend.index') }}">{{ app_name() }}</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item"><a href="{{route('frontend.index')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.index')) }}">{{ __('Home') }}</a></li>
            <li class="nav-item"><a href="#" class="nav-link">{{ __('Features') }}</a></li>
            <li class="nav-item"><a href="#" class="nav-link">{{ __('Charts') }}</a></li>
            <li class="nav-item"><a href="{{route('frontend.faq')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.faq')) }}">{{ __('FAQ') }}</a></li>
            @auth
                <li class="nav-item"><a href="{{route('frontend.user.contact')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.contact')) }}">{{ __('Support') }}</a></li>
            @endauth
        </ul>
    </div>
</nav>
