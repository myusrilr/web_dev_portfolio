// https://edabit.com/challenge/7KbZc8QvzqrJPaE6Q


const REGEXP = /red flag|blue flag/g;

const string = "red flag blue flag red flag blue flag";
const matches = "red flag blue flag".match(REGEXP);

console.log(matches); // ["red flag", "blue flag"]

const string2 = "yellow flag red flag blue flag green flag";
const matches2 = "yellow flag red flag blue flag green flag".match(REGEXP);

console.log(matches2); // ["red flag", "blue flag"]

const string3 = "pink flag red flag black flag blue flag green flag red flag ";
const matches3 = "pink flag red flag black flag blue flag green flag red flag ".match(REGEXP);

console.log(matches3); // ["red flag", "blue flag", "red flag"]

