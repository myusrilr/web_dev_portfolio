// Get the output element
const output = document.querySelector('.output');

// Get all the buttons
const buttons = document.querySelectorAll('.button');

// Add click event listener to all buttons
buttons.forEach(button => {
    button.addEventListener('click', () => {
        const value = button.value;

        if (value === 'C') {
            clearOutput();
        } else if (value === 'del') {
            deleteLastChar();
        } else if (value === '=') {
            calculateResult();
        } else {
            appendToOutput(value);
        }
    });
});

// Function to append value to output
function appendToOutput(value) {
    output.value += value;
}

// Function to clear the output
function clearOutput() {
    output.value = '';
}

// Function to delete the last character
function deleteLastChar() {
    output.value = output.value.slice(0, -1);
}

// Function to calculate the result
function calculateResult() {
    try {
        // Replace 'X' with '*' for multiplication
        const expression = output.value.replace(/X/g, '*');
        const result = eval(expression);
        output.value = result;
    } catch (error) {
        output.value = 'Error';
    }
}
