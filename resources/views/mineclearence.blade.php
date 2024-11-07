@extends('layouts.app')

@section('content')
    <div>
        <h2 class="mb-4"> Mine Clearence </h2>
        <h3>Guild Fellows</h3>
        <form action="{{route('start-mine-clearence')}}" method="POST">
            @csrf
        <label for="name">Name:</label><input type="text" name="name[]">
        <label for="name">Power:</label><input type="text" name="power[]">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]">
        <label for="name">Power:</label><input type="text" name="power[]">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]">
        <label for="name">Power:</label><input type="text" name="power[]">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]">
        <label for="name">Power:</label><input type="text" name="power[]">
        <hr>
        <label for="name">Name:</label><input type="text" name="name[]">
        <label for="name">Power:</label><input type="text" name="power[]">
        <hr>


        <button type="submit" class="bg-blue-600 text-white rounded-full px-4 py-2" href="{{route('start-mine-clearence')}}">start mineclearence </button>
        {{-- <a class="bg-blue-600 text-white rounded-full px-4 py-2" href="{{route('start-mine-clearence')}}">start mineclearence </a> --}}
        </form>
    </div>
@endsection