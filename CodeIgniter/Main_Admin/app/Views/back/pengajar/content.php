<script type="text/javascript">
    var calendar;
    var save_method = "";
    var tb_siswa;
    var tb_pengajar, tb_zoom, tb_level;

    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialView: 'dayGridMonth',
            height: 800,
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '<?php echo base_url(); ?>homepengajar/ajaxevent',
                    dataType: 'json',
                    success: function(res) {
                        var events = [];
                        res.forEach(function(evt) {
                            events.push({
                                id: evt.kode,
                                title: evt.title,
                                start: evt.start,
                                end: evt.end,
                                url: evt.url,
                                description: evt.description,
                                textColor: '#0e0f0f',
                                className: evt.color,
                                color: evt.color,
                                sumber: evt.sumber
                            });
                        });
                        successCallback(events);
                    }
                });
            },
            selectable: true,
            select: function(start, end, allDay) {

            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                // change the border color
                info.el.style.borderColor = 'red';

                let id = info.event.id;
                let judul = info.event.title;
                // let deskripsi = info.event.extendedProps.description;
                // let link = info.event.url;
                // let start = info.event.start;
                // let end = info.event.end;

                if (info.event.extendedProps.sumber === "jadwal") {
                    showinfo(id, judul);

                } else if (info.event.extendedProps.sumber === "libur") {
                    showlibur(id, judul);
                }
            }
        });

        calendar.render();
    });

    function showlibur(id) {
        $('#modal_libur').modal('show');
        $('.modal-title-libur').text('Hari Libur');
        $.ajax({
            url: "<?php echo base_url(); ?>homepengajar/showinfolibur/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#judul_libur').html(data.title);
                $('#deskripsi_libur').html(data.description);
                $('#link_libur').html(data.url);
                $('#tanggal_libur').html(data.start + " - " + data.end);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: textStatus,
                    position: 'topRight'
                });
            }
        });
    }

    function showinfo(id, title) {
        $('#modal_form').modal('show');
        $('.modal-title').text('Group WA : ' + title);
        $.ajax({
            url: "<?php echo base_url(); ?>homepengajar/showinfo/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#kursus').html(data.kursus);
                $('#sesi').html(data.sesi);
                $('#periode').html(data.periode);
                $('#hari').html(data.hari);
                $('#level').html(data.level);
                $('#zoom').html(data.zoom);
                $('#pengajar').html(data.pengajar);

                tb_siswa = $('#tb_siswa').DataTable({
                    ajax: "<?php echo base_url(); ?>homepengajar/ajaxjadwalsiswa/" + id,
                    retrieve: true
                });
                tb_siswa.destroy();
                tb_siswa = $('#tb_siswa').DataTable({
                    ajax: "<?php echo base_url(); ?>homepengajar/ajaxjadwalsiswa/" + id,
                    retrieve: true
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: textStatus,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function closemodallibur() {
        $('#modal_libur').modal('hide');
    }

    function reload() {
        calendar.refetchEvents();
    }

    function closemodal_add() {
        $('#modal_add').modal('hide');
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5 class="modal-title" style="color: blue;">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <p><b>KURSUS</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="kursus"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>SESI</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="sesi"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>PERIODE</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="periode"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>HARI</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="hari"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>LEVEL</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="level"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>ZOOM</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="zoom"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>PENGAJAR</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="pengajar"></p>
                        </td>
                    </tr>
                </table>
                <div class="card-datatable table-responsive">
                    <table id="tb_siswa" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_libur">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5 class="modal-title-libur">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <p><b>JUDUL</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="judul_libur"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>DESKRIPSI</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="deskripsi_libur"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>LINK / URL</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="link_libur"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b>TANGGAL</b></p>
                        </td>
                        <td>
                            <p>&nbsp;:&nbsp;</p>
                        </td>
                        <td>
                            <p id="tanggal_libur"></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>