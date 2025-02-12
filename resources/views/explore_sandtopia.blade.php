@extends('layouts.app')

@section('content')
<div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
    <h2 class="mb-4"> Explore Sandtopia </h2>
    <form action="{{route('sumbit-exploration-sandtopia')}}" method="POST">
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
