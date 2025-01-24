<html>
    <head>
        <title>LEAP-RAPOR SISWA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            @page {
                margin: 0cm 0cm;
            }

            body {
                background: url(<?php echo $background; ?>) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                margin-top: 0cm;
                margin-left: 0cm;
                margin-right: 0cm;
                margin-bottom: 0cm;
            }

            * {
                box-sizing: border-box;
            }

            /* Buat dua kolom yang sama yang mengapung di samping satu sama lain */
            .column {
                float: left;
                width: 50%;
                padding: 10px;
                height: 300px; /* Hanya untuk demonstrasi */
            }

            .column1 {
                float: left;
                width: 48.5%;
                padding: 10px;
                height: 300px; /* Hanya untuk demonstrasi */
            }

            .column2 {
                float: left;
                width: 51.5%;
                padding: 10px;
                height: 300px; /* Hanya untuk demonstrasi */
            }

            /* Hapus floats setelah  columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="row">
                <div class="column1">
                    <table border="0" style="width: 90%; margin-top: 40px; margin-right: 20px; margin-left: 20px; font-size: 12px;">
                        <tr><td colspan="2" style="text-align: center;"><img src="<?php echo $logo; ?>" alt="logo" style="width: 280px; height: auto;"/></td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align: center; font-size: 18px;">ACCREDITATION LEVEL B</td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align: center;">Operational Licence : 188 / 14226 / 436.7.1 / 2020</td></tr>
                        <tr><td colspan="2" style="text-align: center;">Nilek : 05209.1.0593 / 09</td></tr>
                        <tr><td colspan="2" style="text-align: center;">NPSN : K0560112</td></tr>
                        <tr><td colspan="2" style="text-align: center;">Rungkut Asri Tengah VII / 51, Surabaya 60293</td></tr>
                        <tr><td colspan="2" style="text-align: center;">Phone : (031) 870 5464 - 0813 3538 1619</td></tr>
                        <tr><td colspan="2" style="text-align: center;">www.leapsurabaya.sch.id</td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align: center; font-size: 18px;"><u>OUR VISION</u></td></tr>
                        <tr><td colspan="2" style="text-align: center;"><p style="margin-left: 30px; margin-right: 30px;">Leap's vision is to become holistic provider is 2030 to create competent graduates thorough collaborate with our staheholders.</p></td></tr>
                        <tr><td colspan="2"><hr style="border: 1px solid black;"></td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align: center; font-size: 18px;"><u>STUDENT PROGRESS REPORT</u></td></tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left; width: 100px;">&nbsp;&nbsp;NAME</td>
                            <td style="text-align: left;">&nbsp;&nbsp;<?php echo $siswa->nama; ?></td>
                        </tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">&nbsp;&nbsp;LEVEL</td>
                            <td style="text-align: left;">&nbsp;&nbsp;<?php echo $jadwal->level; ?></td>
                        </tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">&nbsp;&nbsp;TEACHER</td>
                            <td style="text-align: left;">&nbsp;&nbsp;<?php echo $pengajar->nama; ?></td>
                        </tr>
                        <tr><td colspan="2" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">&nbsp;&nbsp;TERM</td>
                            <td style="text-align: left;">&nbsp;&nbsp;<?php echo $jadwal->nama_term.' ('. $jadwal->tahun_ajar .')'; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="column2">
                    <table border="0" style="width: 90%; margin-top: 60px; margin-right: 20px; font-size: 11px;">
                        <tr>
                            <td colspan="4" style="text-align: left;"><u>ATTENDANCE : </u></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">
                                POSSIBLE TOTAL SESSIONS
                            </td>
                            <td style="text-align: left;">
                                <?php echo $total_kursus; ?>
                            </td>
                            <td style="text-align: right;">
                                SESSIONS ATTENDED
                            </td>
                            <td style="text-align: left;">
                                <?php echo $presensi; ?>
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4" style="text-align: left;"><u>CLASSWORK ASSESSMENT : </u></td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">CLASS PARTICIPATION</td>
                            <td style="text-align: left;">
                                <?php echo $class_participation; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>

                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">ORAL</td>
                            <td style="text-align: left;">
                                <?php echo $oral; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">LISTENING</td>
                            <td style="text-align: left;">
                                <?php echo $listening; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">WRITING</td>
                            <td style="text-align: left;">
                                <?php echo $writing; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4" style="text-align: left;"><u>END OF TERM TEST : </u></td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">ORAL AND LISTENING</td>
                            <td style="text-align: left;">
                                <?php echo $nilai_oral; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">WRITING AND READING</td>
                            <td style="text-align: left;">
                                <?php echo $writing_and_reading; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">ENGLISH CONVERSATION</td>
                            <td style="text-align: left;">
                                <?php echo $ec; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4" style="text-align: left;"><u>TEACHERS COMMENTS :</u></td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4" style="text-align: left;">
                                <?php echo $comment; ?>
                            </td>
                        </tr>
                        <tr><td colspan="4" style="text-align: left; height: 120px;">&nbsp;</td></tr>
                        <tr>
                            <td style="text-align: left;">FINAL RESULT</td>
                            <td style="text-align: left;">
                                <?php echo $final_result; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">DATE</td>
                            <td style="text-align: left;">
                                <?php echo $curDate; ?>
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                            <td style="text-align: left;">
                                
                            </td>
                        </tr>
                    </table>

                    
                </div>
            </div>
        </main>
    </body>
</html>