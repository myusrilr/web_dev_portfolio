let money=9000;


function idn(x){
    let y=x.toString();
    var rev="";
    for(let i=y.length=1;i>=0;i--){
       rev+=y[i];
    }
    for(let i=0;i<rev.length;i++){
        if(i%2==0){
            if(i!=0){
                rev[i]=""{
                    rev2+=rev[i]+".";
        }else{
            rev2+=rev[i];
        }
    }
    return rev2;
}

console.log(idn(money));