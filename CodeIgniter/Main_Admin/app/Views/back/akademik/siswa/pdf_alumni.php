<html>

<head>
    <title>Leap English & Digital Class</title>
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

        hr {
            border: none;
            height: 0.5px;
            color: #333;
            background-color: #333;
        }
    </style>
</head>

<body>
    <!--        <header>
            RAHASIA
        </header>
        <footer>
        </footer>-->
    <main style="font-size: 12px;">
        <table border="0" style="width: 100%;">
            <tr>
                <td style="text-align: center; vertical-align: middle; padding: 2px; width: 20%;">
                    <img src="<?php echo $logo; ?>" style="width: 150px; height: auto;">
                </td>
                <td style="text-align: left; font-size: 14px;">
                    <table>
                        <tr>
                            <td style="text-align: left;">Operational Licence : 188 / 14226 / 436.7.1 / 2020</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Nilek : 05209.1.0593 / 09</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">NPSN : K0560112</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Rungkut Asri Tengah VII / 51, Surabaya 60293</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Phone : (031) 870 5464 - 0813 3538 1619</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">www.leapsurabaya.sch.id</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        <h2 style="text-align: center;">LAPORAN ALUMNI</h2>
        <table border="0" style="margin-top: 20px; font-size: 10px;">
            <tr>
                <td style="width: 15%; padding: 2px;">TANGGAL CETAK :</td>
                <td colspan="5" style="padding: 2px;"><?php echo $curdate; ?></td>
            </tr>
        </table>
        <table style="font-size: 11px; font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">Jadwal</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">Siswa</th>
                    <th style="text-align: center; vertical-align: middle; padding:5px;">Ortu</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $isitable; ?>
            </tbody>
        </table>
    </main>
</body>

</html>