@extends('layouts.app')

@section('content')
    <div>
        <h2 class="mb-4"> Mine Clearence </h2>
        <h3>Guild Fellows</h3>
        <form action="{{route('start-mine-clearence')}}" method="POST">
            @csrf
        <label for="name">Name:</label><input type="text" name="name[]" value="{{$guildFellows[0]['name'] ?? ""}}">
        <label for="name">Power:</label><input type="text" name="power[]" value="{{$guildFellows[0]['power'] ?? ""}}">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]" value="{{$guildFellows[1]['name'] ?? ""}}">
        <label for="name">Power:</label><input type="text" name="power[]" value="{{$guildFellows[1]['power'] ?? ""}}">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]" value="{{$guildFellows[2]['name'] ?? ""}}">
        <label for="name">Power:</label><input type="text" name="power[]" value="{{$guildFellows[2]['power'] ?? ""}}">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]" value="{{$guildFellows[3]['name'] ?? ""}}">
        <label for="name">Power:</label><input type="text" name="power[]" value="{{$guildFellows[3]['power'] ?? ""}}">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]" value="{{$guildFellows[4]['name'] ?? ""}}">
        <label for="name">Power:</label><input type="text" name="power[]" value="{{$guildFellows[4]['power'] ?? ""}}">
        <hr>


        <button type="submit" class="bg-blue-600 text-white rounded-full px-4 py-2" href="{{route('start-mine-clearence')}}">start mineclearence </button>
        {{-- <a class="bg-blue-600 text-white rounded-full px-4 py-2" href="{{route('start-mine-clearence')}}">start mineclearence </a> --}}
        </form>
        <a href="{{route('start-quick-mine-clearence')}}" class="bg-blue-600 text-white rounded-full px-4 py-2">Start without guild</a>
    </div>
@endsection
