// https://edabit.com/challenge/QkuiL7XApt2RMQqTJ

const string = "Breakfast at 09:00 in the room 123:456";
const regex = /\b\d{2}:\d{2}\b(?!\d{2}:\d{2})/;
const match = string.match(regex);

console.log(match);
