// https://edabit.com/challenge/Gpy2qSFnfhGJnWMMj
// https://edabit.com/challenge/Gpy2qSFnfhGJnWMMj
function canNest(arr1, arr2) {
    return Math.max(...arr1) < Math.max(...arr2) && Math.min(...arr1) > Math.min(...arr2);
}

console.log(canNest([1, 2, 3, 4], [0, 6]));
console.log(canNest([3, 1], [4, 0]));
console.log(canNest([9, 9, 8], [8, 9]));
console.log(canNest([1, 2, 3, 4], [2, 3]));

