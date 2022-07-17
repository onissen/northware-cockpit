// jshint esversion: 6

/****** PW Stack Confirm Identity START ***********/

const identity_inputs = document.querySelectorAll('.otp-input-fields input');

identity_inputs.forEach((input, index) => {
    input.dataset.index = index;
    input.addEventListener('focus', clear);
    // input.addEventListener('keydown', clear);
    input.addEventListener('paste', onPaste);
    input.addEventListener('keyup', onKeyUp);
});


function clear($event) {
    $event.target.value = '';
}

function checkNumber(number) {
    return /[0-9]/g.test(number);
}

function onPaste($event) {
    const data = $event.clipboardData.getData('text');
    const value = data.replace(/ /g, '').split('');
    if (!value.some(number => !checkNumber(number))) {
        if (value.length == identity_inputs.length) {
            identity_inputs.forEach((input, index) => {
                input.value = value[index];
            });
            submitIdentKey();
        }
    } else {
        console.log('Probleme');
        return; 
    }
}

function onKeyUp($event) {
    const input = $event.target;
    const value = input.value;
    const fieldIndex = +input.dataset.index;

    if ($event.key == 'Backspace' && fieldIndex > 0) {
        input.previousElementSibling.focus();
    }

    if (checkNumber(value)) {
        if (value.length > 0 && fieldIndex < identity_inputs.length -1) {
            input.nextElementSibling.focus();
        }

        if (input.value != '' && fieldIndex == identity_inputs.length -1) {
            submitIdentKey();
        }
    } else {
        clear($event);
    }
}

function submitIdentKey() {
    let otp = '';
    identity_inputs.forEach((input) => {
        otp += input.value;
        input.disabled = true;
    });
    document.getElementById('input-key').value = otp;
    console.log(otp);
    document.getElementById('ident-form').submit();
}

/************* Duplicate Input Rows *******************************/
var i_inputRow = 1;

function CloneInputRow() {
    i_inputRow ++;

    var roleId = 'input-role';
    roleId += i_inputRow;
    
    var rowId = 'input-row';
    rowId += i_inputRow;

    let cloneRowID = document.querySelector('#input-rowid1').cloneNode( true );
    cloneRowID.value = i_inputRow -1;
    cloneRowID.setAttribute( 'id', rowId);
    
    let cloneRole = document.querySelector('#input-role1').cloneNode( true );
    cloneRole.setAttribute( 'id', roleId);
    
    var nameId = 'input-rolename';
    nameId += i_inputRow;
    var nameName = 'role_name';
    nameName += i_inputRow;

    let cloneRoleName = document.querySelector('#input-rolename1').cloneNode( true );
    cloneRoleName.setAttribute( 'id', nameId );
    
    document.querySelector('#row-input').appendChild( cloneRowID );
    document.querySelector('#row-input').appendChild( cloneRole );
    document.querySelector('#row-input').appendChild( cloneRoleName );
}

function WPRoleSet() {
    CloneInputRow();
    CloneInputRow();
    CloneInputRow();
    CloneInputRow();

    document.getElementById('input-role1').value = 'admin';
    document.getElementById('input-rolename1').value = 'Administrator';
    
    document.getElementById('input-role2').value = 'author';
    document.getElementById('input-rolename2').value = 'Autor';

    document.getElementById('input-role3').value = 'contributor';
    document.getElementById('input-rolename3').value = 'Website Mitarbeiter';

    document.getElementById('input-role4').value = 'editor';
    document.getElementById('input-rolename4').value = 'Redakteur';

    document.getElementById('input-role5').value = 'subscriber';
    document.getElementById('input-rolename5').value = 'Abonnent';


}

/*********** PWStack END *******************************/

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

/************ Realtime Search ********************/
var searchType = '3';
document.getElementById("SearchType").addEventListener('change', function () {
    searchType = document.getElementById("SearchType").value;
});

function FunctionSearch () {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("SearchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("resultTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[searchType];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}