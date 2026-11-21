// cw05 form validation - rajan sharma

function checkLength(text, min, max) {
    min = min || 1;
    max = max || 10000;
    if (text.length < min || text.length > max) {
        return false;
    }
    return true;
}

function printError(elemId, hintMsg) {
    document.getElementById(elemId).innerHTML = hintMsg;
}

function reportErrors(missingFields) {
    var msg = "You forgot to fill in the following field(s) ";
    for (var i = 0; i < missingFields.length; i++) {
        msg += missingFields[i];
        if (i < missingFields.length - 1) {
            msg += ", ";
        }
    }
    alert(msg);
}

function validateForm() {
    var form = document.getElementById("userForm");
    var idVal = form.userId.value;
    var fnameVal = form.firstName.value;
    var lnameVal = form.lastName.value;

    printError("idErr", "");
    printError("fnameErr", "");
    printError("lnameErr", "");

    var missingFields = [];

    if (!checkLength(idVal)) {
        printError("idErr", "Please Enter an ID");
        missingFields.push("ID");
    }

    if (!checkLength(fnameVal)) {
        printError("fnameErr", "Please Enter a First Name");
        missingFields.push("FirstName");
    }

    if (!checkLength(lnameVal)) {
        printError("lnameErr", "Please Enter a Last Name");
        missingFields.push("LastName");
    }

    if (missingFields.length > 0) {
        reportErrors(missingFields);
        return false;
    }

    var outputContainer = document.getElementById("resultOutput");
    outputContainer.innerHTML +=
        "<div>UserID: " + idVal + "</div>" +
        "<div>First Name: " + fnameVal + "</div>" +
        "<div>Last Name: " + lnameVal + "</div>";

    form.userId.value = "";
    form.firstName.value = "";
    form.lastName.value = "";

    return false;
}
