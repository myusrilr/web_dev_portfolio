// https://edabit.com/challenge/8kTQqoWYQXRsKuYEf

const promise = new Promise((resolve, reject) => {
    setTimeout(() => {
        resolve("Promise resolved successfully!");
    }, 1000);
});

// To handle the promise
promise.then((result) => {
    console.log(result);  // Output: "Promise resolved successfully!"
});

// To handle the promise with error
promise.catch((error) => {
    console.log(error);
});

// To handle the promise with error and success
promise.then((result) => {
    console.log(result);  // Output: "Promise resolved successfully!"
}).catch((error) => {
    console.log(error);
});

