function addDoubleZero(value) {
    var formattedValue = value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    var lastIndex = formattedValue.lastIndexOf(' ');
    var newValue = formattedValue.substring(0, lastIndex) + formattedValue.substring(lastIndex);
    return newValue;
}

console.log(addDoubleZero(9000));

// cara 2
let num=9000;
let text=num.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

document.getElementById("idr").innerHTML=text;