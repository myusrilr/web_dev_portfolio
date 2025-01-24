// https://edabit.com/challenge/7ysTEDruHz2prcJQ9

function tuckIn(arr1, arr2) {
    let middleIndex = Math.floor(arr1.length / 2);
    let result = [arr1.slice(0, middleIndex), ...arr2, arr1.slice(middleIndex)];
    return result.flat();
  }
  
  console.log(tuckIn([1, 10], [2, 3, 4, 5, 6, 7, 8, 9]));
  console.log(tuckIn([15, 150], [45, 75, 35]));
  console.log(tuckIn([[1, 2], [5, 6]], [[3, 4]]));
  
  

