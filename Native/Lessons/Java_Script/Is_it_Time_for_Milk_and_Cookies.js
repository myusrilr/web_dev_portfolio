// https://edabit.com/challenge/hPWnaSckJke5FXNEH

function timeForMilkAndCookies(date) {
  return date.getMonth() === 11 && date.getDate() === 24;
}

console.log(timeForMilkAndCookies(new Date(2013, 11, 24)));
console.log(timeForMilkAndCookies(new Date(3000, 0, 23)));
console.log(timeForMilkAndCookies(new Date(3000, 11, 24)));