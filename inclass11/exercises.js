// CSC 4370 - In-Class Activity 11: Intro to JavaScript
// Rajan Sharma

// Challenge 1: Loops & Strings - drawTriangle(triangleSize)
function drawTriangle(triangleSize) {
    for (let i = 1; i <= triangleSize; i++) {
        let line = "";
        for (let j = 1; j <= i; j++) {
            line += "*";
        }
        console.log(line);
    }
}

console.log("--- Challenge 1: drawTriangle(4) ---");
drawTriangle(4);

// Challenge 2: Password / Input Validation - isStrongPassword(password)
function isStrongPassword(password) {
    if (password.length < 8) {
        return false;
    }
    if (password.toLowerCase().indexOf("password") !== -1) {
        return false;
    }
    let hasUppercase = false;
    for (let i = 0; i < password.length; i++) {
        let code = password.charCodeAt(i);
        if (code >= 65 && code <= 90) {
            hasUppercase = true;
            break;
        }
    }
    return hasUppercase;
}

console.log("\n--- Challenge 2: isStrongPassword ---");
console.log("Qwerty (too short):", isStrongPassword("Qwerty"));
console.log("passwordQwerty (contains password):", isStrongPassword("passwordQwerty"));
console.log("qwerty123 (no uppercase):", isStrongPassword("qwerty123"));
console.log("Qwerty123 (valid):", isStrongPassword("Qwerty123"));

// Challenge 3: Array Filtering & Sorting - sortEvens(numArray)
function sortEvens(numArray) {
    let evens = numArray.filter(function(num) {
        return num % 2 === 0;
    });
    evens.sort(function(a, b) {
        return a - b;
    });
    return evens;
}

console.log("\n--- Challenge 3: sortEvens ---");
console.log("sortEvens([4, 2, 9, 1, 8]):", sortEvens([4, 2, 9, 1, 8]));
console.log("sortEvens([15, 10, 3, 22, 6, 7]):", sortEvens([15, 10, 3, 22, 6, 7]));

// Challenge 4: String Reverser & Palindrome Checker
function reverseString(str) {
    let reversed = "";
    for (let i = str.length - 1; i >= 0; i--) {
        reversed += str[i];
    }
    return reversed;
}

function isPalindrome(str) {
    let cleaned = str.toLowerCase();
    return cleaned === reverseString(cleaned);
}

console.log("\n--- Challenge 4: reverseString & isPalindrome ---");
console.log('reverseString("javascript"):', reverseString("javascript"));
console.log('reverseString("panther"):', reverseString("panther"));
console.log('isPalindrome("racecar"):', isPalindrome("racecar"));
console.log('isPalindrome("Level"):', isPalindrome("Level"));
console.log('isPalindrome("hello"):', isPalindrome("hello"));

// Module 14 Debug Challenge (Fixed 3 Bugs from debug-challenge.js)
function greetUser(name) {
    // Bug 1 fix: was nme (ReferenceError), changed to name
    console.log("Hello, " + name + "!");
}

console.log("\n--- Module 14: Debug Challenge Fixed ---");
greetUser("Sam");

let student = { name: "Ada", score: 92 };
// Bug 2 fix: was student.nam (undefined), changed to student.name
console.log(student.name);

let scores = [85, 92, 78];
// Bug 3 fix: was scores.pushh(90) (TypeError), changed to scores.push(90)
scores.push(90);
console.log("Scores: " + scores);
