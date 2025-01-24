const waktu=document.getElementById("waktu");
const timerUp=setInterval(counterUp,1000);
let menit=0;
let detik=0;
let output_menit=0;

function counterUp(){
    if(detik==59){
        detik=0;
        ++menit;
    }else{
        ++detik;
    }if(detik<10){
        detik="0"+detik;
    }if(menit<10){
        output_menit="0"+menit;
    }
    if(menit==1){
        waktu.style.color="RED";
    }
    waktu.innerHTML=output_menit+":"+detik;
}