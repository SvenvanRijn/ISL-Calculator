@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        <form action="{{route('start-sandtopia')}}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline">
                {{ __('Submit') }}
            </button>
            @foreach($sandtopia as $rewardOption)
                <div class="flex items-center shadow-sm rounded my-2 px-4 py-2 bg-white justify-between">
                    <div class="flex flex-col my-2">
                        <p>{{$rewardOption->reward}}</p>
                        <input class="border border-blue-100" name="power[{{$rewardOption->id}}]" id="sandtopiaPower{{$rewardOption->id}}" value="{{$rewardOption->power}}"/>
                    </div>
                </div>
            @endforeach
        </form>
    </div>
@endsection
