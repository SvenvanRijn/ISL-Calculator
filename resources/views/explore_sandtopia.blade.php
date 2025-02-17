@extends('layouts.app')

@section('content')
<div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
    <h2 class="mb-4"> Explore Sandtopia </h2>
    <form action="{{route('sumbit-exploration-sandtopia')}}" method="POST">
    {{-- <form action="{{route('test')}}" method="POST"> --}}
        @csrf
        <input id="new_run" type="checkbox" name="new_run" value="true" />
        <br>
        @foreach ($sandtopia as $reward)
            <button type="submit" name="sandtopia_id" value="{{$reward->id}}" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline">
                {{ $reward->reward }}
            </button>
        @endforeach

    </form>
    <h2 class="mb-4"> Explore Sandtopia test</h2>
    {{-- <form action="{{route('sumbit-exploration-sandtopia')}}" method="POST"> --}}
    <form action="{{route('test')}}" method="POST">
        @csrf
        <input type="checkbox" name="new_run" value="true" />
        <br>
        @foreach ($sandtopia as $reward)
            <button type="submit" name="sandtopia_id" value="{{$reward->id}}" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline">
                {{ $reward->reward }}
            </button>
        @endforeach

    </form>
</div>
@endsection
@section('modals')
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm hidden" id="explorationsModal" tabindex="-1" role="dialog" aria-labelledby="explorationsModal" aria-hidden="true">
        <div class="flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold">Add Fellow</h2>
            <button onclick="toggleExplorationModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
        </div>
        <div class="mt-4" id="explorationsModalBody">

        </div>


@endsection
