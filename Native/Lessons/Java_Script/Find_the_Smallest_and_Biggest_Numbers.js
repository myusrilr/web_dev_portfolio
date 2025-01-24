// https://edabit.com/challenge/Q3n42rEWanZSTmsJm

// versi 1
function minMax(arr) {
  return [Math.min(...arr), Math.max(...arr)];
}

// versi 2
function minMax(arr) {
  let min = arr[0];
  let max = arr[0];

  for (let i = 0; i < arr.length; i++) {
    if (arr[i] < min) {
      min = arr[i];
    }
    // bisa ditulis
    // if (min>arr[i]) {
    //   min= arr[i];
    // }
    
    if (arr[i] > max) {
      max = arr[i];
    }
    // bisa ditulis
    // if (max<arr[i]) {
    //   max= arr[i];
    // }
  }

  return [min, max];
}


console.log(minMax([1, 2, 3, 4, 5]));
console.log(minMax([2334454, 5]));
console.log(minMax([1]));