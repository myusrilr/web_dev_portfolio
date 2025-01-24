// https://edabit.com/challenge/o7TwicAHWuMkjbDqQ

function whichIsLarger(f, g) {
  return f() > g() ? 'f' : f() < g() ? 'g' : 'neither';
}

console.log(whichIsLarger(() => 5, () => 10));
console.log(whichIsLarger(() => 25, () => 25));
console.log(whichIsLarger(() => 505050, () => 5050));
