// document.write(typeof Math.floor(Math.random() * 10).toString());

// var data = Math.floor(Math.random() * 44);
// document.write(data.toString());

// Math.floor is used to round down the number to remove the decimal part
// Math.random is used to generate a random number
// data.toString is used to convert the number to a string so that it doesn't produce a new number when added
// *100 is used to set the limit

angka = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
function randomNum() {
  var random = Math.floor(Math.random() * 10);
  var result = random.toString();
  return result;
}
function randomLower() {
  const alpha = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
  var index = Math.floor(Math.random() * alpha.length);
  return alpha[index];
}
function randomUpper() {
  const Alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var Index = Math.floor(Math.random() * Alpha.length);
  return Alpha[Index];
}
function randomSymbol() {
  const Symbol = ["!", "@", "#", "$", "%", "&", "*", "+", "-", "_"];
  var Index = Math.floor(Math.random() * Symbol.length);
  return Symbol[Index];
}

function combine() {
  const elements = [randomNum(), randomLower(), randomUpper(), randomSymbol()];
  var result = "";
  for (var i = 0; i < elements.length; i++) {
    var randomIndex = Math.floor(Math.random() * elements.length);
    result += elements[randomIndex];
  }
  return result;
}

// function combine() {
//   const elements = [randomNum(), randomLower(), randomUpper(), randomSymbol()];
//   var result = "";
//   for (var i = 0; i < elements.length; i++) {
//     result += elements[i];
//   }
//   return result;
// }

// function combine() {
//   const combine = [randomNum(), randomLower(), randomUpper(), randomSymbol()];
//   var result = Math.floor(Math.random() * combine.length);
//   return combine[result];
// }

// document.write(randomNum());
// document.write(randomLower());
// document.write(randomUpper());
// document.write(randomSymbol());

document.write(combine());
