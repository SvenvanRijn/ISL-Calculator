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
    const formData = new FormData(form);
    try {
        const response = await fetch('/userfellow/api/create', {
        method: 'POST',
        body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        removeOption(result.fellow_id);
        addFellow(result);
        document.getElementById("addFellowMsg").textContent = `Success: ${result.message}`;
    } catch (error) {
        document.getElementById("addFellowMsg").textContent = `Error: ${error.message}`;
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
            <img src="images/edit-button.svg" class="w-4 h-4"/>
        </button>
    </div>`

    document.getElementById("fellowList").insertAdjacentHTML('beforeend', html);
}

function removeOption(id){
    document.getElementById("fellow" + id).remove();
}


function toggleExplorationModal() {
    document.getElementById('explorationsModal').classList.toggle('hidden');
    toggleModal();
}
let reward_id = 0;

async function submitExploration(sandtopia_id){
    reward_id = sandtopia_id;
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let newRun = document.getElementById('new_run').checked;
    document.getElementById("explorationsModalBody").innerHTML = 'Loading...';
    toggleExplorationModal();
    try{
        const response = await fetch('/api/explore-sandtopia', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                'sandtopia_id': sandtopia_id,
                'new_run': newRun
            })
        })
        if(!response.ok){
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        console.log(result);
        document.getElementById("explorationsModalBody").innerHTML = '';
        Object.values(result.options).forEach(option => {
            parseExplorationOption(option);
        })
    }
    catch(error){
        console.log(error);
    }
}

function parseExplorationOption(option){

    let fellowHtml = '';
    Object.values(option.fellows).forEach(fellow => {
        fellowHtml += `<div class="flex items-center shadow-sm rounded my-2 pr-4 bg-white justify-between">
            <img src="${fellow.img_src}" alt="${fellow.name}" class="inline-block w-14 h-14 m-2"/>
            <div class="flex flex-col my-2">
                <p>${fellow.name}</p>
                <p>${fellow.power}</p>
            </div>
        </div>`
    });

    let fellowsString = JSON.stringify(Object.keys(option.fellows));

    let html = `<div>
        ${fellowHtml}
        <div>
            <button onClick="confirmExploration(event)" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline" data-fellows='${fellowsString}'>Submit</button>
        </div>
    </div>`

    document.getElementById("explorationsModalBody").insertAdjacentHTML('beforeend', html);
}

async function confirmExploration(event){
    let target = event.target;
    while (target.tagName !== "BUTTON"){
        target = target.parentNode;
    }
    let fellows = target.dataset.fellows;
    console.log(fellows);

    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try{
        const response = await fetch('/api/confirm-exploration', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                'sandtopia_id': reward_id,
                'fellows': fellows
            })
        })
        if(!response.ok){
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = await response.json();
        console.log(result);
        toggleExplorationModal();
    }
    catch(error){
        console.log(error);
    }

}
