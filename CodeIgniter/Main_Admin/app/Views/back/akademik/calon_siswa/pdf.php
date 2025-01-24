<html>

<head>
    <title>SERAP VERIFIKASI</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 0.5cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 0.5cm;
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
    </style>
</head>

<body>
    <!-- <header>
        RAHASIA
    </header> -->
    <footer>
        <?php echo $tglcetak; ?>
    </footer>
    <main style="font-size: 12px;">
        <p style="text-align: center; font-size: 14px;"><b>LAPORAN CALON SISWA</b></p>

        <table>
            <tr>
                <td><b>Jenis Pendidikan</b></td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td style="text-align: right;"><?php echo $mode; ?></td>
            </tr>
        </table>

        <table style="font-size: 11px; font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">NO</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">SISWA (PANGGILAN)</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">WA</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">EMAIL</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">JENIS</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($list->getResult() as $row) {
                ?>
                    <tr>
                        <td style="padding:5px;"><?php echo $no; ?></td>
                        <td style="padding:5px;"><?php echo $row->nama; ?></td>
                        <td style="padding:5px;"><?php echo $row->tlp; ?></td>
                        <td style="padding:5px;"><?php echo $row->email; ?></td>
                        <td style="padding:5px;"><?php echo $row->nama_kursus; ?></td>
                        <td style="padding:5px;">
                            <?php
                            if ($row->status == "1") {
                                $status = '<span class="badge badge-success">Diterima</span>';
                            } else if ($row->status == "0") {
                                $status = '<span class="badge badge-warning">Pending</span>';
                            } else if ($row->status == "2") {
                                $status = '<span class="badge badge-danger">Ditolak</span>';
                            }
                            echo $status;
                            ?>
                        </td>
                    </tr>
                <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>