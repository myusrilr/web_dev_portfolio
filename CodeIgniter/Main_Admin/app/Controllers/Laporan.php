<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function cetak(){
        if(session()->get("logged_hr")){
            $dompdf = new Dompdf();

            $tgl = explode(':',$this->request->getUri()->getSegment(3));

            $data['list'] = $this->model->getAllQ("select * from perijinan where created_at between '".$tgl[0]."' and '".$tgl[1]."' having (select count(*) from 
            perijinan_note where idusers = '".session()->get("idusers")."') > 0 order by created_at desc");
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;

            $data['tglmulai'] = $tgl[0];
            $data['tglselesai'] = $tgl[1];

            $options = new Options();
            $options->setChroot(FCPATH);

            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('back/hrd/laporan/print', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'Laporan Perijinan dan Lembur : '.$tgl[0].' hingga '.$tgl[1].'.pdf';
            $dompdf->stream($filename); // download
            // $dompdf->stream($filename, array("Attachment" => 0));
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
