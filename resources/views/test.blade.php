@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-centre bg-gray-100 w-full lg:max-w-lg  p-2">
        <p class="sticky" style="top: 0px">Needed Power: {{number_format($neededPower)}}</p>
        <p class="sticky" style="top: 20px">Current Power: <span id="currentPower" data-power=0></span></p>
        <div class="grid lg:grid-cols-3 gap-4 lg:gap-8 grid-cols-1">
            @foreach ($unusedFellows as $fellow)
                <div id="fellow{{$fellow->id}}" data-power="{{$fellow->power}}" data-toggle="false" class="fellow flex items-center shadow-sm rounded my-2 px-4 py-2 bg-white justify-between">
                    <div class="flex flex-col my-2">
                        <p>{{$fellow->name}}</p>
                        <p>{{number_format($fellow->power)}}</p>
                        <img src="{{$fellow->img_src}}" alt="{{$fellow->name}}" class="inline-block w-14 h-14 m-2"/>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
            console.log(document.querySelectorAll('.fellow'));
            document.querySelectorAll('.fellow').forEach(fellow => {
                console.log(fellow);
            fellow.addEventListener('click', () => {
                let currentPower = document.getElementById('currentPower');
                if (fellow.dataset.toggle === "false"){
                    fellow.dataset.toggle = "true";
                    fellow.classList.add('ring-2');
                    currentPower.dataset.power = Number(currentPower.dataset.power) + Number(fellow.dataset.power);
                    currentPower.textContent = number_format(currentPower.dataset.power);
                } else {
                    fellow.dataset.toggle = "false";
                    fellow.classList.remove('ring-2');
                    currentPower.dataset.power = Number(currentPower.dataset.power) - Number(fellow.dataset.power);
                    currentPower.textContent = number_format(currentPower.dataset.power);
                }
            })
        })

    </script>
@endsection
