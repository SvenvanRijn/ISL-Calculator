@extends('layouts.app')

@section('content')
<div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
    <h2 class="mb-4"> Explore Sandtopia </h2>
    <div>
        @csrf
        <label for="new_run">Start new run (resets used fellows)</label>
        <input id="new_run" type="checkbox" name="new_run" value="true" />
        <br>
        @foreach ($sandtopia as $reward)
            <button onclick="submitExploration({{$reward->id}})" class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-600 focus:outline-none">{{ $reward->reward }}</button>
        @endforeach
    </div>
@endsection
@section('modals')
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm hidden" id="explorationsModal" tabindex="-1" role="dialog" aria-labelledby="explorationsModal" aria-hidden="true">
        <div class="flex justify-between items-center">
            <div>
                <h2 id="modal-title" class="text-xl font-semibold">Possible Options</h2>
                <p>Add the fellows in ISL before submitting</p>
            </div>
            <button onclick="toggleExplorationModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
        </div>
        <div class="mt-4" id="explorationsModalBody" style="overflow-y: scroll; max-height: 90vh">

        </div>


@endsection
