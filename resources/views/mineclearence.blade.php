@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        <h2 class="mb-4"> Mine Clearence </h2>
        <h3>Guild Fellows</h3>
        <form action="{{route('start-mine-clearence')}}" method="POST">
            @csrf
            @for ($i = 0; $i < 5; $i++)
                <div class="mb-2 p-2 bg-white rounded-md">
                    <div>
                        <label class="block" for="name">Name:</label>
                        <input class="block bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-1" type="text" name="name[]" value="{{$guildFellows[$i]['name'] ?? ""}}">
                    </div>
                    <div>
                        <label class="block" for="name">Power:</label>
                        <input class="block bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-1" type="text" name="power[]" value="{{$guildFellows[$i]['power'] ?? ""}}">
                    </div>
                </div> 
            @endfor


        <button type="submit" class="bg-blue-600 text-white text-center rounded-full w-full px-4 py-2">start mineclearence </button>
        {{-- <a class="bg-blue-600 text-white rounded-full px-4 py-2" href="{{route('start-mine-clearence')}}">start mineclearence </a> --}}
        </form>
        <a href="{{route('start-quick-mine-clearence')}}" class="bg-blue-600 text-white text-center rounded-full px-4 py-2 mt-2">Start without guild</a>
    </div>
@endsection
