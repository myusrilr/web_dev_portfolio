<html>
    <head>
        <title>Laporan Perijinan / Lembur tanggal </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 1cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 1cm;
                /* background-image: url("back/images/noimg.jpg"); */
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }
            
            .dash{
                border: 0 none;
                border-top: 1px dashed #322f32;
                background: none;
                height:0;
              } 

            footer {
                position: fixed; 
                bottom: -2cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }

            header {
                position: fixed;
                top: -40px;
                left: 65px;
                right: 0px;
                height: auto;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <main style="font-size: 12px;">
           
            <h2 style="text-align: center;">LAPORAN PERIJINAN / LEMBUR</h2>
            <h2 style="text-align: center;">PERIODE : <?php echo date('d M Y',strtotime($tglmulai)).' s/d '.date('d M Y',strtotime($tglselesai))?></h2>

            <table style="border-collapse: collapse; border: 1px solid #b7bec5; margin-top: 10px; margin-bottom: 5px; width: 100%;">
                <tr>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 20px;"><b>NO</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 80px;"><b>TANGGAL</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 100px;"><b>JENIS</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 130px;"><b>NAMA KARYAWAN</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 170px;"><b>TGL & WAKTU</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 300px;"><b>KETERANGAN</b></td>
                    <td style="text-align: center; border: 1px solid black; padding: 5px; width: 100px;"><b>STATUS</b></td>
                </tr>
                <?php 
                $no = 1;
                foreach($list->getResult() as $row) {?>
                <tr>
                    <td style="text-align: center; border: 1px solid #b7bec5; padding: 5px; width: 24px;"><?php echo $no; ?></td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 80px;">
                    <?php echo date('d M Y',strtotime($row->created_at)); ?>
                    </td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 100px;"><?php echo $row->jenis; ?></td>
                    <?php $nama = $model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama; ?> 
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 130px;"><?php echo $nama; ?></td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 170px;"><?php echo date('d M Y',strtotime($row->tanggalmulai)).' s/d '.date('d M Y',strtotime($row->tanggalselesai)).'<br>'.date('H:i',strtotime($row->waktumulai)).' - '.date('H:i',strtotime($row->waktuselesai)); ?></td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 300px;"><?php echo $row->keterangan; ?></td>
                    <td style="text-align: justify; border: 1px solid #b7bec5; padding: 5px; width: 100px;"><?php echo $row->status; ?></td>
                </tr>
                <?php 
                $no++;
                } ?>
            </table>
        </main>
    </body>
</html>