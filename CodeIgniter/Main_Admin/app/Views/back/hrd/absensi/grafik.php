<script type="text/javascript">

    var save_method; //for save method string
    var table, table2;
    
    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 250,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>absence/ajaxlist"
        });

        table2 = $('#tb2').DataTable({
            ajax: "<?php echo base_url(); ?>absence/ajaxlistnote"
        });

        $('#info').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function reload2() {
        table2.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Import Excel');
    }

    function note() {
        $('#info2').hide();
        $('#form2')[0].reset();
        $('#modal_form2').modal('show');
        $('.modal-title2').text('Analisa Absensi Karyawan');
    }

    function save() {
        var file = $('#file').prop('files')[0];

        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var form_data = new FormData();
        form_data.append('file', file);
        
        $.ajax({
            url: "<?php echo base_url(); ?>absence/ajax_upload",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                $('#modal_form').modal('hide');
                reload();
                
            }, error: function (response) {
                alert(response.status);
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                reload();
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function save2() {
        var note = tinyMCE.get('note').getContent();
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>absence/submitnote";
        
        var form_data = new FormData();
        form_data.append('note', note);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                $('#info2').show();
                if(data.status == "simpan"){
                    $('#info2').text('Berhasil menyimpan data!');
                    $('[name="note"]').val("");
                }
                reload2();

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function closemodal2(){
        $('#modal_form2').modal('hide');
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Grafik Absensi Kehadiran Karyawan (<b>KESELURUHAN</b> <?php echo date("Y") ?>)</h6>
                </div>
                <div class="card-body py-0">
                    <div id="chart-bar-moris" style="height:300px"></div>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Grafik <b>KEHADIRAN</b> (<?php echo date("F Y") ?>)</h6>
                </div>
                <div class="card-body py-0">
                    <div id="morrisjs-graph" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Grafik <b>KETERLAMBATAN </b> (<?php echo date("Y") ?>)</h6>
                </div>
                <div class="card-body py-0">
                    <div id="morrisjs-bars" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var gridBorder = '#eeeeee';
    new Morris.Bar({
        element: 'morrisjs-bars',
        data: [
            <?php foreach($nickname->getResult() as $row1){
                $t = $model->getAllQR("SELECT count(*) as tot FROM absensi a, karyawan k where a.status = 'Terlambat' and a.idkaryawan = k.idkaryawan and nickname = '".$row1->nickname."' and month(tanggal) = month(now());");
                $o = $model->getAllQR("SELECT count(*) as tot FROM absensi a, karyawan k where a.status = 'Tepat Waktu' and a.idkaryawan = k.idkaryawan and nickname = '".$row1->nickname."' and month(tanggal) = month(now());");
            ?>
            { device: '<?php echo $row1->nickname ?>', geekbench: <?php echo $t->tot ?> , ontime : <?php echo $o->tot; ?>},
            <?php } ?>
        ],
        xkey: 'device',
        ykeys: ['geekbench', 'ontime'],
        labels: ['Keterlambatan','Tepat Waktu'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#2e76bb','#62d493'],
        gridLineColor: gridBorder,
        resize: true
    });

    new Morris.Line({
        element: 'morrisjs-graph',
        data: [
        { period: '2011 Q3', licensed: 71, sorned: 41 },
        { period: '2011 Q2', licensed: 24, sorned: 80 },
        { period: '2011 Q1', licensed: 39, sorned: 28 },
        { period: '2010 Q4', licensed: 34, sorned: 38 },
        { period: '2009 Q4', licensed: 51, sorned: 11 },
        { period: '2008 Q4', licensed: 68, sorned: 67 },
        { period: '2007 Q4', licensed: 85, sorned: 6 },
        { period: '2006 Q4', licensed: 21, sorned: 87 },
        { period: '2005 Q4', licensed: 38, sorned: 94 }
        ],
        xkey: 'period',
        ykeys: [<?php foreach($nickname->getResult() as $row1){ echo "'".$row1->nickname."',"; } ?>],
        labels: [<?php foreach($nickname->getResult() as $row1){ echo "'".$row1->nickname."',"; } ?>],
        lineColors: ['#2196f3', '#FF4961'],
        lineWidth: 1,
        pointSize: 4,
        gridLineColor: gridBorder,
        resize: true
    });

    buildchart()
    $(window).on('resize', function() {
        buildchart();
    });
    $('#mobile-collapse').on('click', function() {
        setTimeout(function() {
            buildchart();
        }, 700);
    });

    Morris.Bar({
        element: 'chart-bar-moris',
        data: [
            <?php foreach($all->getResult() as $row){?>
            {
                y: '<?php echo date("F",strtotime($row->tanggal)); ?>',
                a: <?php echo $row->telat; ?>,
                b: <?php echo $row->tepat; ?>,
                c: <?php echo $row->jmlijin; ?>,
            },
            <?php } ?>
        ],
        xkey: 'y',
        barSizeRatio: 0.70,
        barGap: 5,
        resize: true,
        responsive: true,
        ykeys: ['a', 'b', 'c'],
        labels: ['Terlambat', 'Tepat Waktu', 'Ijin'],
        barColors: ['#ff4a00', '#62d493', '#f4ab55']
    });
});

function buildchart() {
    $(function() {
        //Flot Base Build Option for bottom join
        var options_bt = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 0,
                margin: {
                    top: 5,
                    left: 0,
                    bottom: 0,
                    right: 0,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

        //Flot Base Build Option for Center card
        var options_ct = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 5,
                margin: {
                    top: 8,
                    left: 8,
                    bottom: 8,
                    right: 8,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

    });
}
</script>