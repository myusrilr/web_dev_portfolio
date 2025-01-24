// https://edabit.com/challenge/JDkyQJqNfJNhvjmRW

function seriesResistance(arr) {
  let sum = arr.reduce((a, b) => a + b);
  return sum <= 1 ? `${sum} ohm` : `${sum} ohms`;
}

console.log(seriesResistance([1, 5, 6, 3]));
console.log(seriesResistance([16, 3.5, 6]));
console.log(seriesResistance([0.5, 0.5]));