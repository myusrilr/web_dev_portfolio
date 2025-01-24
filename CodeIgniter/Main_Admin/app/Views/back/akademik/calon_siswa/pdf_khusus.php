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
                <td><b>PAGU</b></td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td><b>SERAP</b></td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td style="text-align: right;"></td>
            </tr>
            <tr>
                <td><b>PROSENTASE</b></td>
                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td style="text-align: right;"></td>
            </tr>
        </table>

        <table style="font-size: 11px; font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">NO</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">SATKER</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">PAGU</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">REALISASI</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">SISA</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">PROSENTASE</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</body>

</html>