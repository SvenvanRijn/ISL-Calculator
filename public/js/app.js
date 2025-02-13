function toggleHamburgerMenu(){
    let menu = document.getElementById('mobile-menu');
    if(menu.style.display == "none"){
        menu.toggleAttribute('style');
    }else{
        menu.style.display = 'none';
    }
}

function closeHamburgerMenu(){
    let menu = document.getElementById('mobile-menu');
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
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
    console.log(data)
    toggleEditFellowModal()
}

function toggleEditFellowModal(){
    document.getElementById('editFellowModal').classList.toggle('hidden');
    toggleModal();
}
async function submitEditFellowForm(){
    const form = document.getElementById('editFellowForm');
    const formData = new FormData(form); // Collect form data

    try {
        const response = await fetch('/userfellow/api/edit', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            //throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json(); // Assuming the backend responds with JSON
        changeFellowData(result);
        toggleEditFellowModal();
        //document.getElementById("responseMessage").textContent = `Success: ${result.message}`;
    } catch (error) {
        document.getElementById("responseMessage").textContent = `Error: ${error.message}`;
    }
}

function changeFellowData(fellow){
    console.log(fellow);
    let fellowHTML = document.getElementById(`fellowPower${fellow.id}`);
    fellowHTML.textContent = number_format(fellow.power, 0, '.', ',');
}

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
        document.getElementById("addFellowMsg").textContent = `Success: ${result.message}`;
    } catch (error) {
        // document.getElementById("responseMessage").textContent = `Error: ${error.message}`;
    }
    //toggleAddFellowModal();
}
function addFellow(fellow){

    let power = number_format(fellow.power, 0, '.', ',');

    let html = `<div id="fellow${fellow.id}" class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
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