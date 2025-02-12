@extends('layouts.app')


@if (env('APP_ENV') != 'local')
@section('content')
    <p>
        W.I.P.
    </p>
@endsection
@else

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        <a href="{{route('edit-sandtopia')}}" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline mb-2">
            {{ __('Edit Sandtopia') }}
        </a>
        <a href="{{route('explore-sandtopia')}}" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline">
            {{ __('Explore Sandtopia') }}
        </a>
    </div>
@endsection
@endif
