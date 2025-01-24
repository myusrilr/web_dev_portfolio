<script type="text/javascript">

    var calendar;
    var save_method = "";

    $(document).ready(function () {
        var calendarEl = document.getElementById('calendar');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialView: 'dayGridMonth',
            height: 600,
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '<?php echo base_url(); ?>ploting/ajaxevent',
                    dataType: 'json',
                    success: function(res) {
                        var events = [];
                        res.forEach(function (evt) {
                            events.push({
                                id: evt.idjadwaldetil,
                                title: evt.title,
                                start: evt.start,
                                end: evt.end,
                                textColor : '#0e0f0f',
                                className: 'fc-event-info'
                            });
                        });
                        successCallback(events);
                    }
                });
            },
            selectable: true,
            select: function (start, end, allDay) {
                add(start.startStr);
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();
                // change the border color
                info.el.style.borderColor = 'red';

                Swal.fire({
                    title: info.event.title,
                    icon: 'info',
                    html: '<p>' + info.event.extendedProps.description + '</p><a href="' + info.event.url + '">Visit event page</a>',
                    showCloseButton: true,
                    showCancelButton: true,
                    showDenyButton: true,
                    cancelButtonText: 'Close',
                    confirmButtonText: 'Edit',
                    denyButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show event
                        show(info.event.id);

                    } else if (result.isDenied) {
                        // Delete event
                        hapus(info.event.id, info.event.title);

                    } else {
                        Swal.close();
                    }
                });
            }
        });

        calendar.render();
    });

    function add(start) {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Event');
        $('#start').val(start);
    }

    function save() {
        var title = document.getElementById('title').value;
        var description = document.getElementById('description').value;
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;

        if (title === "") {
            iziToast.success({
                title: 'Info',
                message: 'Title can not be null ',
                position: 'topRight'
            });
        } else if (description === "") {
            iziToast.success({
                title: 'Info',
                message: 'Description can not be null',
                position: 'topRight'
            });
        } else if (start === "") {
            iziToast.success({
                title: 'Info',
                message: 'Start can not be null',
                position: 'topRight'
            });
        } else if (end === "") {
            iziToast.success({
                title: 'Info',
                message: 'End can not be null',
                position: 'topRight'
            });

        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var url;
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>home/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>home/ajax_edit";
            }
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function (data) {

                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    $('#modal_form').modal('hide');
                    calendar.refetchEvents();

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);

                }, error: function (jqXHR, textStatus, errorThrown) {

                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });

        }
    }

    function show(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Edit Event');
        $.ajax({
            url: "<?php echo base_url(); ?>home/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.id);
                $('[name="title"]').val(data.title);
                $('[name="description"]').val(data.description);
                $('[name="url"]').val(data.url);
                $('[name="start"]').val(data.start);
                $('[name="end"]').val(data.end);

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data",
                    position: 'topRight'
                });
            }
        });
    }

    function hapus(id, title) {
        if (confirm("Apakah anda yakin menghapus jadwal " + title + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>home/ajax_hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {

                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                    calendar.refetchEvents();

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Info',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Ploting Jadwal</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item active">Ploting Jadwal</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="jadwal_siswa();"><i class="fas fa-search"></i> Jadwal Siswa </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="jadwal_guru();"><i class="fas fa-search"></i> Jadwal Pengajar </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Topic</label>
                            <input type="text" id="topic" name="topic" class="form-control" placeholder="Topic" autocomplete="off">
                            <small class="invalid-feedback">Topic wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link</label>
                            <input type="text" id="link" name="link" class="form-control" placeholder="Link Zoom" autocomplete="off">
                            <small class="invalid-feedback">Link zoom wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Meeting ID</label>
                            <input type="text" id="meeting_id" name="meeting_id" class="form-control" placeholder="Meeting ID" autocomplete="off">
                            <small class="invalid-feedback">Meeting ID wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Passcode</label>
                            <input type="text" id="passcode" name="passcode" class="form-control" placeholder="Passcode" autocomplete="off">
                            <small class="invalid-feedback">Passcode wajib diisi</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>