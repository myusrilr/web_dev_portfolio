<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Calon Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">
    <style>
        .back {
            background: url('<?php echo base_url() ?>singlepage/images/bgcalon.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: 100% 100%;
        }
    </style>
</head>

<body>
    <div class="wrapper back">
        <div class="inner">
            <form action="<?php echo base_url() ?>calonsiswasp/proses" method="post">
                <h3>Calon Siswa</h3>
                <input type="hidden" id="idcalon" name="idcalon" value="<?php echo $idcalon_enkrip; ?>">
                <input type="hidden" id="idpendkurusus" name="idpendkurusus" value="<?php echo $head->idpendkursus; ?>">
                <?php
                $index = 1;
                $str = '';
                foreach ($pertanyaan->getResult() as $row) {
                    $jawaban = "";
                    $cek = $model->getAllQR("SELECT count(*) as jml FROM calon_detil where idpendkursus = '" . $head->idpendkursus . "' and idcalon_p = '" . $row->idcalon_p . "' and idcalon = '" . $idcalon . "';")->jml;
                    if ($cek > 0) {
                        $jawaban = $model->getAllQR("SELECT jawaban FROM calon_detil where idpendkursus = '" . $head->idpendkursus . "' and idcalon_p = '" . $row->idcalon_p . "' and idcalon = '" . $idcalon . "';")->jawaban;
                    }
                    if ($row->mode == "text") {
                        if ($index == 1) {
                            $str .= '<div class="form-group">
                                            <div class="form-wrapper">
                                                <label>' . $row->pertanyaan . '</label>
                                                <div class="form-holder">
                                                    <input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="text" class="form-control" value="' . $jawaban . '" autocomplete="off">
                                                </div>
                                            </div>';
                            $index++;
                        } else {
                            $str .= '<div class="form-wrapper">
                                            <label>' . $row->pertanyaan . '</label>
                                            <div class="form-holder">
                                                <input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="text" class="form-control" value="' . $jawaban . '" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>';
                            $index = 1;
                        }
                    } else if ($row->mode == "select" || $row->mode == "radio") {
                        if ($index == 1) {
                            $str .= '<div class="form-group">
                                            <div class="form-wrapper">
                                                <label>' . $row->pertanyaan . '</label>
                                                <div class="form-holder select">';

                            if ($row->target_tb == "Kabupaten / Kota") {
                                // artinya ini pick dari table
                                $str .= '<select id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" class="form-control">';
                                $list2 = $model->getAllQ("SELECT idkabupaten, name FROM kabupaten;");
                                foreach ($list2->getResult() as $row2) {
                                    if ($row2->idkabupaten == $jawaban) {
                                        $str .= '<option selected value="' . $row2->idkabupaten . '">' . $row2->name . '</option>';
                                    } else {
                                        $str .= '<option value="' . $row2->idkabupaten . '">' . $row2->name . '</option>';
                                    }
                                }
                                $str .= '</select>';
                            } else {
                                $str .= '<select id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" class="form-control">';
                                $list2 = $model->getAllQ("SELECT idcalon_pd, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p = '" . $row->idcalon_p . "';");
                                foreach ($list2->getResult() as $row2) {
                                    if ($row2->idcalon_pd == $jawaban) {
                                        $str .= '<option selected value="' . $row2->idcalon_pd . '">' . $row2->pertanyaan_detil . '</option>';
                                    } else {
                                        $str .= '<option value="' . $row2->idcalon_pd . '">' . $row2->pertanyaan_detil . '</option>';
                                    }
                                }
                                $str .= '</select>';
                            }

                            $str .= '</div>
                                            </div>';
                            $index++;
                        } else {
                            $str .= '<div class="form-wrapper">
                                            <label>' . $row->pertanyaan . '</label>
                                            <div class="form-holder select">
                                                <select id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" class="form-control">';

                            if ($row->target_tb == "Kabupaten / Kota") {
                                $list2 = $model->getAllQ("SELECT idkabupaten, name FROM kabupaten;");
                                foreach ($list2->getResult() as $row2) {
                                    if ($row2->idkabupaten == $jawaban) {
                                        $str .= '<option selected value="' . $row2->idkabupaten . '">' . $row2->name . '</option>';
                                    } else {
                                        $str .= '<option value="' . $row2->idkabupaten . '">' . $row2->name . '</option>';
                                    }
                                }
                            }else{
                                $list2 = $model->getAllQ("SELECT idcalon_pd, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p = '" . $row->idcalon_p . "';");
                                foreach ($list2->getResult() as $row2) {
                                    if ($row2->idcalon_pd == $jawaban) {
                                        $str .= '<option selected value="' . $row2->idcalon_pd . '">' . $row2->pertanyaan_detil . '</option>';
                                    } else {
                                        $str .= '<option value="' . $row2->idcalon_pd . '">' . $row2->pertanyaan_detil . '</option>';
                                    }
                                }
                            }
                            $str .= '</select>
                                            </div>
                                        </div>
                                    </div>';
                            $index = 1;
                        }
                    } else if ($row->mode == "date") {
                        if (strlen($jawaban) < 1) {
                            $jawaban = $curdate;
                        }
                        if ($index == 1) {
                            $str .= '<div class="form-group">
                                            <div class="form-wrapper">
                                                <label>' . $row->pertanyaan . '</label>
                                                <div class="form-holder">
                                                    <input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="date" class="form-control" value="' . $jawaban . '" autocomplete="off">
                                                </div>
                                            </div>';
                            $index++;
                        } else {
                            $str .= '<div class="form-wrapper">
                                            <label>' . $row->pertanyaan . '</label>
                                            <div class="form-holder">
                                                <input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="date" class="form-control" value="' . $jawaban . '" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>';
                            $index = 1;
                        }
                    }
                }
                echo $str;
                ?>
                <div class="form-end">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked disabled> Setuju syarat dan ketentuan leap surabaya.
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="button-holder">
                        <button>Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>