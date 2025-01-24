Year = 2024,
month = 8;
let months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
let days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
let firstDayofMonth = new Date(Year, month, 1).getDay();

console.log("Hari pertama di bulan", months[month], "ialah :", days[firstDayofMonth]);

for(let i=firstDayofMonth)