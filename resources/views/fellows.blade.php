@extends('layouts.app')

@section('content')
    <div id="fellowList" class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        <button id="addFellowModalButton" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline" onclick="toggleAddFellowModal()">
            Add Fellow
        </button>
        <a id="massEditBtn" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline text-center mt-1" href='{{route('mass-edit')}}'>
            Mass Edit
        </a>
        @foreach($userFellows as $userfellow)
            <div id="fellow{{$userfellow->id}}" class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
                <img src="{{$userfellow->img_src}}?text={{urlencode($userfellow->name)}}" alt="{{$userfellow->name}}" class="inline-block w-14 h-14 m-2"/>
                <div class="flex flex-col my-2">
                    <p>{{$userfellow->name}}</p>
                    <p id="fellowPower{{$userfellow->id}}">{{number_format($userfellow->power, 0, '.', ',')}}</p>
                </div>
                <button onclick="editFellow(event)" data-power="{{$userfellow->power}}" data-name="{{$userfellow->name}}" data-id="{{$userfellow->id}}" data-extra="{{$userfellow->extra}}">
                    <img src="{{asset('images/edit-button.svg')}}" class="w-4 h-4"/>
                </button>
            </div>
        @endforeach
    </div>

@endsection
@section('modals')
    <!-- Modal -->
    <div id="addFellowModal" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm hidden" role="dialog" aria-labelledby="modal-title" aria-modal="true">
        <!-- Modal Header -->
        <div class="flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold">Add Fellow</h2>
            <button onclick="toggleAddFellowModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="mt-4">
            <div id="addFellowMsg">

            </div>
            <form id="addFellowForm"  method="POST">
                @csrf
                <select name="fellow_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-1">
                    @foreach ($fellows as $fellow)
                        <option id="fellow{{$fellow->id}}" value="{{$fellow->id}}">{{$fellow->name}}</option>
                    @endforeach
                </select>
                <label for="power">Power: </label><input name="power" id="power" class="block bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5"/>
            </form>
        </div>
        <!-- Modal Footer -->
        <div class="mt-6 flex justify-end">
            <button onclick="toggleAddFellowModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none">Close</button>
            <button onclick="submitFellowForm()" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">Add Fellow</button>
        </div>
        <script>
        </script>
    </div>


    <div id="editFellowModal" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm hidden" role="dialog" aria-labelledby="modal-title" aria-modal="true">
        <!-- Modal Header -->
        <div class="flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold">Edit Fellow</h2>
            <button onclick="toggleEditFellowModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="mt-4">
                <form id="editFellowForm" method="POST">
                    @csrf
                    <input name="id" hidden id='editId' type="text">
                    <p id='editName' type="text"></p>
                    {{-- <label for="extra">extra: </label><input name="extra" id='editExtra' type="text"> --}}

                    <label for="power">Power: </label><input class="border border-blue-100" name="power" id="editPower" value=""/>
                </form>
        </div>
        <!-- Modal Footer -->
        <div class="mt-6 flex justify-end">
            <button onclick="toggleEditFellowModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none">Close</button>
            <button onclick="submitEditFellowForm()" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">Save Changes</button>
        </div>
        <script>
        </script>
    </div>
@endsection
