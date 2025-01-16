@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        @foreach($perLevel as $level => $fellows)
            @if($fellows !== [])
            <div class="relative">
            <div class="flex flex-col items-center shadow-md rounded-lg my-2 px-4 bg-white justify-between">
                <h4>{{$level}}/50</h4>
                @foreach($fellows as $id => $fellow)
                    @if($id !== "auto")
                        <div class="flex flex-row items-center justify-between w-full my-2">
                            <p>{{$fellow['name']}}</p>
                            <p>{{$fellow['power']}}</p>
                            <img src="{{$fellow['img_src']}}" alt="{{$fellow['name']}}" class="inline-block w-14 h-14 m-2"/>
                        </div>
                    @endif
                    @if (array_key_last($fellows) === $id)
                </div>
                    @endif
                @if ($id == "auto")
                    <div class="absolute w-full h-full text-center align-middle flex items-center justify-center bg-gray-100 opacity-50 top-0">
                        <span class="text-gray-400 w-full text-center">Auto</span>
                    </div>
                @endif
                @endforeach

            </div>
            @endif
        @endforeach
    </div>
@endsection
