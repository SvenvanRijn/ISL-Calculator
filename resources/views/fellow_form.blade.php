@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Fellow') }}</div>

                <div class="card-body">
                    @if (session('succes'))
                        <div class="alert alert-success" role="alert">
                            {{ session('succes') }}
                        </div>
                    @endif
                    <form action="{{route('create-fellow')}}" method="POST">
                        @csrf
                        <select name="fellow_id">
                            @foreach ($fellows as $fellow)
                                <option value="{{$fellow->id}}">{{$fellow->name}}</option>
                            @endforeach
                        </select>
                        <label for="power">Power:</label><input name="power" id="power"/>
                        <input type="submit" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
