<?php
// isset digunakan untuk mengecek bahwa ariabelnya ada atau tidak ada
$data=array("nama"=>"vivi","password"=>"123456")
if(isset($data["nama"])){
    if($data["nama"]=="vivi"){
        echo "username benar";
    }
    else{
        echo "username salah";
    }
// kosong dan tidak ada itu berbeda
}
else{
    echo "belum login";
}
?>