// https://edabit.com/challenge/4gzDuDkompAqujpRi

function addUp(num) {
  let sum = 0;
  for (let i = 1; i <= num; i++) {
    sum += i;
  }
  return sum;
}

console.log(addUp(4));
console.log(addUp(13));
console.log(addUp(600));
