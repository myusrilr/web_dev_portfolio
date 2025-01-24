const waktu=document.getElementById("waktu");
const timerDown=setInterval(counterDown,1000);
let menit=0;
let detik=10;
let output_menit=0;

function counterDown(){
    if(detik<10)
        {
        detik="0"+detik;
        }
    if(menit<10)
        {
        output_menit="0"+menit;
        }
waktu.innerHTML=output_menit+":"+detik;
    if(detik==0)
        {
        detik=59;
        --menit;
        }
    else
        {
        --detik;
        }
    if(menit==-1)
        {
        clearInterval(timerDown);
        }
}