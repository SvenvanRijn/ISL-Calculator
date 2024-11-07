@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm">
        @foreach($perLevel as $level => $fellows)
            @if($fellows !== [])
            <div class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
                <h4>{{$level}}/50</h4>
                @foreach($fellows as $id => $fellow)
                {{$id}}
                    @if(str_contains($id, "g"))
                        <p>{{$fellow['name']}}</p>
                        <p>{{$fellow['power']}}</p>
                    @else
                        <p>{{$fellow['name']}}</p>
                        <p>{{$fellow['power']}}</p>
                    @endif

                @endforeach
            </div>
            @endif
        @endforeach
    </div>
@endsection