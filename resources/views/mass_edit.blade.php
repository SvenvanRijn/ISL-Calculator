@extends('layouts.app')

@section('content')
    <form action="{{route('mass-update')}}" method="POST" id="fellowList" class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        @csrf
        @foreach($userFellows as $userfellow)
            <div id="fellow{{$userfellow->id}}" class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
                <div class="flex flex-col my-2">
                    <p>{{$userfellow->name}}</p>
                    <input class="border border-blue-100" name="fellow[{{$userfellow->id}}]" id="fellowPower{{$userfellow->id}}" value="{{$userfellow->power}}"/>
                </div>
            </div>
        @endforeach
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline">
            {{ __('Confirm') }}
        </button>
    </form>

@endsection