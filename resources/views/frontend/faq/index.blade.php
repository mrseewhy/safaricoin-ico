@extends('frontend.layouts.app')

@section('content')
    <div class="box-static box-bordered p-30">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                FAQ
            </h2>
        </div>
        @foreach($faq as $item)
            <h5>Q: {{ $item->question }}</h5>
            <p class="text-secondary mb-3 pt-2 pb-2">{{ $item->answer }}</p>
        @endforeach
    </div>
@endsection
