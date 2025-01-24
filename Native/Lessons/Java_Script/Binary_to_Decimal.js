// cara 1
function binaryToDecimal(binary) {
  let decimal = 0;
  for (let i = 0; i < binary.length; i++) {
    decimal += binary[i] * Math.pow(2, binary.length - i - 1);
  }
  return decimal;
}

console.log(binaryToDecimal("10101010"));

// cara 2


function binaryToDecimal(binary) {
  return parseInt(binary, 2);
}

console.log(binaryToDecimal("10101010"));

// cara 3

function binaryToDecimal(binary) {
  return binary.split("").reverse().reduce((acc, curr, i) => acc + curr * Math.pow(2, i), 0);
}

console.log(binaryToDecimal("10101010"));
