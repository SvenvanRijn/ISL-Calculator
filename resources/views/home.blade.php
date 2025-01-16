@extends('layouts.app')
@section('pageTitle', " - Home")
@section('meta')
    <meta name="description" content="A calculator for Mine Clearance and Sandtopia for the mobile game Isekai: Slow Life.">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ "ISL-Calculator" }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        Welcome, I made this calculator because i noticed the auto function in Mine Clearence and Sandtopia are very inefficient.
                    </p>
                    <p>
                        Create an account and add your fellows to make use of the calculator, yes filling in all your fellows is a pain but what can you do.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
