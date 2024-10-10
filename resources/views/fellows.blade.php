@extends('layouts.app')

@section('content')
    <div>
        @foreach($userFellows as $userfellow)
            <div class="fellow">
                <form method="POST" action="{{route('edit-fellow')}}">
                    @csrf
                    <input hidden name='id' value="{{$userfellow->id}}" />
                    <p> {{$userfellow->fellow->name}}</p>
                    <input name='power' value="{{$userfellow->power}}" />
                    <input type="submit" value="submit">
                </form>
            </div>
        @endforeach
    </div>
@endsection