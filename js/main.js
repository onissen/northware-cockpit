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

/*********** PWStack END *******************************/

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));