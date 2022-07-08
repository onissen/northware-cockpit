/*jshint esversion: 6 */
function deleteMainKto (mainkto) {
    var question = 'Möchtest du das Hauptkonto ';
    question += mainkto;
    question += ' wirklich löschen?';
        swal({
        icon: "warning",
        title: "Hauptkonto löschen",
        text: question,

        buttons: {
            cancel: {
                text: "Abbrechen",
                visible: true,
                className: "swal-btn-cancel",
              },
              confirm: {
                text: "Ja, löschen",
                value: "deleteMainKto",
                visible: true,
                className: "swal-btn-danger",
              }
        },
    }).then((value) => {
        if (value == 'deleteMainKto') {
            document.getElementById('id-delete').value = mainkto;
            document.getElementById('submit-delete').value = value;
            document.getElementById('form-delete').submit();
        }
    });
}

function deletePW (uid, username) {
    var question = 'Möchtest du den Eintrag zu ';
    question += username;
    question += ' (ID ';
    question += uid;
    question += ') wirklich löschen?';
        swal({
        icon: "warning",
        title: "Eintrag löschen",
        text: question,

        buttons: {
            cancel: {
                text: "Abbrechen",
                visible: true,
                className: "swal-btn-cancel",
              },
              confirm: {
                text: "Ja, löschen",
                value: "deletePW",
                visible: true,
                className: "swal-btn-danger",
              }
        }
    }).then((value) => {
        if (value == 'deletePW') {
            document.getElementById('uid-delete').value = uid;
            document.getElementById('username-delete').value = username;
            document.getElementById('submit-delete').value = value;
            document.getElementById('form-delete').submit();
        }
    });
}