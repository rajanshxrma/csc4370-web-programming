// cw05 form validation - rajan sharma

function trim(str) {
    return str.replace(/^\s+|\s+$/, "");
}

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

function flagFieldDOM(inputId, isMissing) {
    var inputElem = document.getElementById(inputId);
    if (isMissing) {
        inputElem.classList.add("input-error");
    } else {
        inputElem.classList.remove("input-error");
    }
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

function displayEnteredValues(idVal, fnameVal, lnameVal) {
    var outputContainer = document.getElementById("resultOutput");

    // clear previous result so repeated clicks only show the last entered values
    outputContainer.innerHTML = "";

    var entries = [
        "UserID: " + idVal,
        "First Name: " + fnameVal,
        "Last Name: " + lnameVal
    ];

    for (var i = 0; i < entries.length; i++) {
        var row = document.createElement("div");
        row.appendChild(document.createTextNode(entries[i]));
        outputContainer.appendChild(row);
    }
}

function validateForm() {
    var form = document.getElementById("userForm");
    var idVal = trim(form.userId.value);
    var fnameVal = trim(form.firstName.value);
    var lnameVal = trim(form.lastName.value);

    printError("idErr", "");
    printError("fnameErr", "");
    printError("lnameErr", "");
    flagFieldDOM("userId", false);
    flagFieldDOM("firstName", false);
    flagFieldDOM("lastName", false);

    var missingFields = [];

    if (!checkLength(idVal)) {
        printError("idErr", "Please Enter an ID");
        flagFieldDOM("userId", true);
        missingFields.push("ID");
    }

    if (!checkLength(fnameVal)) {
        printError("fnameErr", "Please Enter a First Name");
        flagFieldDOM("firstName", true);
        missingFields.push("FirstName");
    }

    if (!checkLength(lnameVal)) {
        printError("lnameErr", "Please Enter a Last Name");
        flagFieldDOM("lastName", true);
        missingFields.push("LastName");
    }

    if (missingFields.length > 0) {
        reportErrors(missingFields);
        return false;
    }

    displayEnteredValues(idVal, fnameVal, lnameVal);

    form.userId.value = "";
    form.firstName.value = "";
    form.lastName.value = "";

    return false;
}
