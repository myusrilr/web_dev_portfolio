// https://edabit.com/challenge/nuXdWHAoHv9y38sn7

function sortDrinkByPrice(drinks) {
  return drinks.sort((a, b) => a.price - b.price);
}

console.log(
  sortDrinkByPrice([
    { name: "lemonade", price: 50 },
    { name: "lime", price: 10 },
  ])
);
