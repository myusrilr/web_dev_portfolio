<script>
//     document.addEventListener('keyup',(e)=>{
//         navigator.clipboard.writeText('');
//         alert('Screenshot disabled');
//     });

//     document.addEventListener('touchstart', function(event) {
//             if (event.targetTouches.length > 1) {
//                 event.preventDefault();
//             }
//         }, { passive: false });

//         document.addEventListener('contextmenu', function(event) {
//             event.preventDefault();
//         });

//         document.addEventListener('touchstart', function(event) {
//     if (event.targetTouches.length > 1) {
//         event.preventDefault();
//     }
// }, { passive: false });
</script>

<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Data Karyawan Leap Surabaya</h4>
    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">
            <!-- <div class="card">
                <div class="card-body text-center">
                    <div class="py-1 mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Karyawan..">
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <?php foreach($pu->getResult() as $row){
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $row->foto;
            if(strlen($foto) > 0){
                if(file_exists($modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }?>
        <div class="col-lg-3 col-md-4">
            <div class="card user-card user-card-1 mt-3">
                <div class="card-body">
                    <div class="user-about-block text-center">
                        <div class="row align-items-start">
                            <div class="col"><img class="img-radius img-fluid" src="<?php echo $def_foto; ?>" alt="User image" style="height:150px; width:150px; object-fit: cover;"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#!" data-toggle="modal" data-target="#modal-report">
                            <h4 class="mb-1 mt-3"><?php echo $row->nama; ?></h4>
                        </a>
                        <p class="small opacity-75"><?php echo $row->jabatan.' / '.$row->divisi; ?></p>
                        <?php $idkaryawan = $model->getAllQR("select idkaryawan from karyawan where idusers = '".$row->idusers."'")->idkaryawan; ?>
                        <p class="mb-1"><b><?php echo $idkaryawan; ?></b></p>
                        <p class="mb-0"><i><?php echo $row->minat; ?></i></p>
                        <?php if($row->expertise != ""){ ?>
                        <p class="mb-0"><b>Ahli : <u><?php echo $row->expertise; ?></u></b></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- liveline-section end -->
    </div>