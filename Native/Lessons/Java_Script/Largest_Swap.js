// https://edabit.com/challenge/hD3euqPHM82Cbr7R8


function largestSwap(num) {
    let str = num.toString();
    let arr = str.split('');
    let temp = arr[0];
    arr[0] = arr[1];
    arr[1] = temp;
    let result = parseInt(arr.join(''));
    return result <= num;
}

console.log(largestSwap(14));
console.log(largestSwap(53));
console.log(largestSwap(99));

  