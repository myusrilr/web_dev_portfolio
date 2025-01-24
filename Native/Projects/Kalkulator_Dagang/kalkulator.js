let hpp = 0;
let hj = 0;
let margin = 0;
let input = "";  // Variable to hold current input
let isCalculatingHj = false;  // Flag to check if we are calculating HJ based on margin %

/** Function to insert numbers and display in the input field **/
function insert(num) {
    input += num;
    document.getElementById('hasil').value = input;
}

/** Function to set the HPP value when Hpp button is clicked **/
function setHpp() {
    hpp = parseFloat(input); // Convert input to a number
    if (!isNaN(hpp) && hpp > 0) {
        document.getElementById('hasil').value = "HPP: " + formatCurrency(hpp); // Display HPP in Rupiah format
        input = "";  // Reset the input after setting HPP
        isCalculatingHj = false;  // Reset mode to avoid HJ calculation after %
    } else {
        alert("Masukkan nilai HPP yang valid!");
    }
}

/** Function to set the percentage and calculate HJ **/
function setMargin() {
    margin = parseFloat(input);  // Set the margin based on user input
    if (!isNaN(margin) && margin > 0) {
        if (hpp > 0) {
            isCalculatingHj = true;  // Set mode to calculate HJ when the HJ button is pressed
            document.getElementById('hasil').value = "Margin: " + margin + "%"; // Display margin and instruct user to press HJ
            input = "";  // Reset input for next step
        } else {
            alert("HPP harus diatur terlebih dahulu!");
        }
    } else {
        alert("Masukkan nilai margin yang valid!");
    }
}

/** Function to handle HJ value **/
function handleHj() {
    if (isCalculatingHj) {
        // If in calculation mode, calculate HJ based on HPP and margin %
        if (hpp > 0 && margin > 0) {
            hj = hpp + (hpp * (margin / 100)); // Calculate HJ based on HPP and margin percentage
            document.getElementById('hasil').value = "HJ: " + formatCurrency(hj); // Display HJ in Rupiah format
            input = "";  // Reset input
            isCalculatingHj = false; // Reset mode after calculation
        } else {
            alert("HPP dan margin harus diatur terlebih dahulu!");
        }
    } else {
        // Set HJ directly from input
        hj = parseFloat(input); // Convert input to a number
        if (!isNaN(hj) && hj > 0) {
            document.getElementById('hasil').value = "HJ: " + formatCurrency(hj); // Display HJ in Rupiah format
            input = "";  // Reset the input after setting HJ
        } else {
            alert("Masukkan nilai HJ yang valid!");
        }
    }
}

/** Function to calculate and display margin based on HPP and HJ **/
function calculateMargin() {
    if (hpp > 0 && hj > 0) {
        margin = ((hj - hpp) / hpp) * 100;  // Calculate margin percentage
        document.getElementById('hasil').value = "Margin: " + margin.toFixed(2) + "%"; // Display margin with "%" symbol
    } else {
        alert("HPP dan HJ harus diatur terlebih dahulu untuk menghitung margin!");
    }
}

/** Function to clear the input when C button is clicked **/
function clearInput() {
    input = "";  // Reset input variable
    document.getElementById('hasil').value = "";  // Clear the display
    hpp = 0;  // Reset HPP
    hj = 0;   // Reset HJ
    margin = 0;  // Reset margin
    isCalculatingHj = false;  // Reset the mode
}

/** Function to format numbers to Rupiah currency **/
function formatCurrency(num) {
    return num.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 });
}
