@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm">
        @foreach($perLevel as $level => $fellows)
            @if($fellows !== [])
            <div class="flex flex-col items-center shadow-sm rounded my-2 px-4 bg-white justify-between">
                <h4>{{$level}}/50</h4>
                @foreach($fellows as $id => $fellow)
                    <div class="flex flex-row items-center justify-between w-full my-2">
                        @if ($id == "auto")
                            <span class="text-gray-400 w-full text-center">Auto</span>
                        @elseif(str_contains($id, "g"))
                            <p>{{$fellow['name']}}</p>
                            <p>{{$fellow['power']}}</p>
                        @else
                            <p>{{$fellow['name']}}</p>
                            <p>{{$fellow['power']}}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>
@endsection
