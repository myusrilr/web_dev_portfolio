// Mengambil elemen output dari form
const output = document.querySelector('.output');

// Mendapatkan semua tombol yang ada di kalkulator
const buttons = document.querySelectorAll('.button');

// Inisialisasi variabel untuk menyimpan data inputan
let currentInput = '';  // Untuk menyimpan inputan saat ini
let previousInput = ''; // Untuk menyimpan inputan sebelumnya
let operator = '';      // Untuk menyimpan operator yang dipilih

// Event listener untuk setiap tombol
buttons.forEach(button => {
    button.addEventListener('click', (e) => {
        const value = e.target.value; // Mendapatkan nilai dari tombol yang ditekan
        
        // Jika tombol yang ditekan adalah "C", kita reset kalkulator
        if (value === 'C') {
            currentInput = '';
            previousInput = '';
            operator = '';
            output.value = '';
        }
        // Jika tombol yang ditekan adalah "Del", hapus karakter terakhir dari input
        else if (value === 'del') {
            currentInput = currentInput.slice(0, -1);
            output.value = currentInput;
        }
        // Jika tombol yang ditekan adalah salah satu operator (+, -, *, /)
        else if (['+', '-', '*', '/'].includes(value)) {
            if (currentInput === '') return; // Jika tidak ada input, abaikan operator
            if (previousInput !== '') {
                // Jika sudah ada operator sebelumnya, lakukan perhitungan
                previousInput = calculate(previousInput, currentInput, operator);
                output.value = previousInput;
            } else {
                previousInput = currentInput;
            }
            operator = value;
            currentInput = ''; // Bersihkan current input untuk angka berikutnya
        }
        // Jika tombol "=" ditekan, lakukan perhitungan
        else if (value === '=') {
            if (previousInput === '' || currentInput === '') return; // Cegah jika tidak ada input yang valid
            previousInput = calculate(previousInput, currentInput, operator);
            output.value = previousInput;
            currentInput = ''; // Bersihkan current input
        }
        // Jika tombol angka atau titik ditekan, tambahkan ke current input
        else {
            if (value === '.' && currentInput.includes('.')) return; // Cegah dua titik dalam satu angka
            currentInput += value;
            output.value = currentInput;
        }
    });
});

// Fungsi untuk melakukan perhitungan
function calculate(firstValue, secondValue, operator) {
    const num1 = parseFloat(firstValue);
    const num2 = parseFloat(secondValue);
    let result = 0;

    switch (operator) {
        case '+':
            result = num1 + num2;
            break;
        case '-':
            result = num1 - num2;
            break;
        case '*':
            result = num1 * num2;
            break;
        case '/':
            result = num1 / num2;
            break;
    }

    return result.toString(); // Kembalikan hasil perhitungan sebagai string
}
