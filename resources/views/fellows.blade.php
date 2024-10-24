@extends('layouts.app')

@section('content')
    <div>
        @foreach($userFellows as $userfellow)
            <div class="flex items-center">
                <img src="{{$userfellow->img_src}}" alt="{{$userfellow->name}}" class="inline-block w-10"/>
                <form class="inline-block" method="POST" action="{{route('edit-fellow')}}">
                    @csrf
                    <input hidden name='id' value="{{$userfellow->id}}" />
                    <p class="font-bold"> {{$userfellow->name}}</p>
                    <label for="power" class="sr-only">Fellow Power</label>
                    <input name='power' value="{{$userfellow->power}}" />
                    <input type="submit" value="submit">
                </form>
            </div>
        @endforeach
    </div>
@endsection