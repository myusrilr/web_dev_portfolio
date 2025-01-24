const display = document.getElementById('display');
const numerics = document.getElementsByClassName('numeric');
const operators = document.getElementsByClassName('operator');
const btnCalculate = document.getElementById('calculate');
const btnClear = document.getElementsByClassName('operator_clear')[0];
const darkModeBtn = document.getElementById('dark-mode-btn');
const lightModeBtn = document.getElementById('light-mode-btn');
const body = document.body;

let currentNumber = "";
let number1 = 0;
let number2 = 0;
let temp1 = "";
let temp2 = "";
let opsi_operator = "";
let result = 0;


// untuk update display
function updateDisplay() {
    display.innerText = currentNumber;
}

// untuk baca tombol angka
for (let i = 0; i < numerics.length; i++) {
    numerics[i].addEventListener('click', function () {
        currentNumber += numerics[i].innerText;
        if (opsi_operator) {
            temp2 += numerics[i].innerText;  // simpan semua digit angka ke temp2
        }
        updateDisplay();
    });
}

// untuk baca tombol operator
for (let i = 0; i < operators.length; i++) {
    operators[i].addEventListener('click', function () {
        if (currentNumber && !opsi_operator) {
            temp1 = currentNumber;
            number1 = parseFloat(temp1);
            opsi_operator = operators[i].innerText;  // ambil operator
            currentNumber += " " + opsi_operator + " ";  // tampilkan operator di display
            updateDisplay();
        }
    });
}

// untuk menghitung hasil ketika tombol "=" diklik
btnCalculate.addEventListener('click', function () {
    number2 = parseFloat(temp2);  // konversi temp2 ke angka
    if (!isNaN(number1) && !isNaN(number2)) {
        if (opsi_operator === "+") {
            result = number1 + number2;
        } else if (opsi_operator === "-") {
            result = number1 - number2;
        } else if (opsi_operator === "x") {
            result = number1 * number2;
        } else if (opsi_operator === "/") {
            if (number2 !== 0) {
                result = number1 / number2;
            } else {
                result = "Error (div by 0)";
            }
        }
        currentNumber = result.toString();  // ubah hasil jadi string untuk ditampilkan
        updateDisplay();
        resetCalculator();  // reset setelah kalkulasi
    }
});

// untuk mereset kalkulator
function resetCalculator() {
    number1 = 0;
    number2 = 0;
    temp1 = "";
    temp2 = "";
    opsi_operator = "";
}

// untuk tombol AC (reset semua)
btnClear.addEventListener('click', function () {
    currentNumber = "";
    resetCalculator();
    updateDisplay();
});



// Fungsi untuk toggle mode gelap
darkModeBtn.addEventListener('click', function () {
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');

    // Toggle tombol: sembunyikan tombol bulan, tampilkan tombol matahari
    darkModeBtn.style.display = 'none';
    lightModeBtn.style.display = 'block';
});

// Fungsi untuk toggle mode terang
lightModeBtn.addEventListener('click', function () {
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');

    // Toggle tombol: sembunyikan tombol matahari, tampilkan tombol bulan
    lightModeBtn.style.display = 'none';
    darkModeBtn.style.display = 'block';

    // Ubah warna tombol bulan agar lebih gelap pada mode terang
    darkModeBtn.style.backgroundColor = '#333';  // Warna gelap
    darkModeBtn.style.color = 'white';  // Teks putih
});
