// https://edabit.com/challenge/rvsvGvqZ3BzNieKqA

// https://edabit.com/challenge/rvsvGvqZ3BzNieKqA

function detectWord(str) {
    const regex = /[a-z]/g;
    const matches = str.match(regex);
    return matches ? matches.join('') : null;
  }
  
  console.log(detectWord("UcUNFYGaFYFYGtNUH"));
  console.log(detectWord("bEEFGBuFBRrHgUHlNFYaYr"));
  console.log(detectWord("YFemHUFBbezFBYzFBYLleGBYEFGBMENTment"));
  