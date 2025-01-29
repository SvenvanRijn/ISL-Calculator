@extends('layouts.app')

@section('content')
    <div id="fellowList" class="flex flex-col items-centre bg-gray-100 w-full sm:max-w-sm p-2">
        <button id="addFellowModalButton" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline" onclick="toggleAddFellowModal()">
            Add Fellow
        </button>
        @foreach($userFellows as $userfellow)
            <div class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
                <img src="{{$userfellow->img_src}}" alt="{{$userfellow->name}}" class="inline-block w-14 h-14 m-2"/>
                <div class="flex flex-col my-2">
                    <p>{{$userfellow->name}}</p>
                    <p>{{number_format($userfellow->power, 0, '.', ',')}}</p>
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
                <form id="addFellowForm" action="{{route('create-fellow')}}" method="POST">
                    @csrf
                    <select name="fellow_id" class="w-full mb-2">
                        @foreach ($fellows as $fellow)
                            <option id="fellow{{$fellow->id}}" value="{{$fellow->id}}">{{$fellow->name}}</option>
                        @endforeach
                    </select>
                    <label for="power">Power: </label><input name="power" id="power" class="border border-blue-100"/>
                </form>
        </div>
        <!-- Modal Footer -->
        <div class="mt-6 flex justify-end">
            <button onclick="toggleAddFellowModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none">Close</button>
            <button onclick="submitFellowForm()" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none">Add Fellow</button>
        </div>
        <script>
            function toggleAddFellowModal(){
                document.getElementById('addFellowModal').classList.toggle('hidden');
                toggleModal();
            }
            async function submitFellowForm(){
                const form = document.getElementById('addFellowForm');
                const formData = new FormData(form); // Collect form data
                console.log(formData);
                try {
                    const response = await fetch('/userfellow/api/create', {
                    method: 'POST',
                    body: formData,
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    console.log('test2')
                    const result = await response.json(); // Assuming the backend responds with JSON
                    console.log(result);
                    removeOption(result.fellow_id);
                    addFellow(result);
                    // document.getElementById("responseMessage").textContent = `Success: ${result.message}`;
                } catch (error) {
                    // document.getElementById("responseMessage").textContent = `Error: ${error.message}`;
                }
                toggleAddFellowModal();
            }
            function addFellow(fellow){

                let power = number_format(fellow.power, 0, '.', ',');

                let html = `<div class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
                    <img src="${fellow.img_src}" alt="${fellow.name}" class="inline-block w-14 h-14 m-2"/>
                    <div class="flex flex-col my-2">
                        <p>${fellow.name}</p>
                        <p>${power}</p>
                    </div>
                    <button onclick="editFellow(event)" data-power="${fellow.power}" data-name="${fellow.name}" data-id="${fellow.id}" data-extra="${fellow.extra}">
                        <img src="{{asset('images/edit-button.svg')}}" class="w-4 h-4"/>
                    </button>
                </div>`

                document.getElementById("fellowList").insertAdjacentHTML('beforeend', html);
            }

            function removeOption(id){
                document.getElementById("fellow" + id).remove();
            }
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
                <form id="editFellowForm" action="{{route('edit-fellow')}}" method="POST">
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
            function toggleEditFellowModal(){
                document.getElementById('editFellowModal').classList.toggle('hidden');
                toggleModal();
            }
            function submitEditFellowForm(){
                console.log('click');
                document.getElementById('editFellowForm').submit();
            }
            function editFellow(event){
                let target = event.target;

                while (target.tagName !== "BUTTON"){
                    target = target.parentNode;
                }
                let data = target.dataset;
                document.getElementById('editPower').value = data.power;
                document.getElementById('editName').innerText = data.name;
                // document.getElementById('editExtra').value = data.extra;
                document.getElementById('editId').value = data.id;

                toggleEditFellowModal()
            }
            document.getElementById("addFellowForm").addEventListener("submit", async function (event) {
                event.preventDefault(); // Prevent the default form submission

                const form = event.target;
                const formData = new FormData(form); // Collect form data
                console.log('test')
                try {
                    const response = await fetch('/userfellow/api/create', {
                    method: 'POST',
                    body: formData,
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    console.log('test2')
                    const result = await response.json(); // Assuming the backend responds with JSON
                    document.getElementById("responseMessage").textContent = `Success: ${result.message}`;
                } catch (error) {
                    document.getElementById("responseMessage").textContent = `Error: ${error.message}`;
                }
            });
        </script>
    </div>
@endsection
