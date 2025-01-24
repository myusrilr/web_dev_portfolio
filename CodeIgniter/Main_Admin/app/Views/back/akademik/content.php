<script type="text/javascript">
    
    var calendar;
    var save_method = "";
    var tb_siswa;
    var tb_pengajar, tb_zoom, tb_level;
    var tb_jadwal_guru, tb_list_guru;
    var tb_jadwal_siswa, tb_list_siswa;

    $(document).ready(function () {
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
                    url: '<?php echo base_url(); ?>homependidikan/ajaxevent',
                    dataType: 'json',
                    success: function(res) {
                        var events = [];
                        res.forEach(function (evt) {
                            events.push({
                                id: evt.kode,
                                title: evt.title,
                                start: evt.start,
                                end: evt.end,
                                url: evt.url,
                                description: evt.description,
                                textColor : '#0e0f0f',
                                className: evt.color,
                                color : evt.color,
                                sumber : evt.sumber
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

                let id = info.event.id;
                let judul = info.event.title;
                // let deskripsi = info.event.extendedProps.description;
                // let link = info.event.url;
                // let start = info.event.start;
                // let end = info.event.end;

                if(info.event.extendedProps.sumber === "jadwal"){
                    showinfo(id, judul);

                }else if(info.event.extendedProps.sumber === "libur"){
                    showlibur(id, judul);
                }
            }
        });

        calendar.render();
        
        
    });
    
    function showlibur(id){
        $('#modal_libur').modal('show');
        $('.modal-title-libur').text('Edit Hari Libur');
        
        $.ajax({
            url: "<?php echo base_url(); ?>homependidikan/showinfolibur/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#kode').val(data.idlibur);
                $('#judul').val(data.title);
                $('#deskripsi').val(data.description);
                $('#url').val(data.url);
                $('#tgl_awal').val(data.start);
                $('#tgl_akhir').val(data.end);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: textStatus,
                    position: 'topRight'
                });
            }
        });
    }

    function editLibur(){
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var deskripsi = document.getElementById('deskripsi').value;
        var link = document.getElementById('url').value;
        var tglawal = document.getElementById('tgl_awal').value;
        var tglakhir = document.getElementById('tgl_akhir').value;

        var tot = 0;
        if (judul === '') {
            document.getElementById('judul').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('judul').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tglawal === '') {
            document.getElementById('tgl_awal').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgl_awal').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tglakhir === '') {
            document.getElementById('tgl_akhir').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgl_akhir').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if(tot === 3){
            $('#btnSaveLibur').text('Menyimpan...');
            $('#btnSaveLibur').attr('disabled', true);
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('deskripsi', deskripsi);
            form_data.append('url', link);
            form_data.append('tglawal', tglawal);
            form_data.append('tglakhir', tglakhir);

            $.ajax({
                url: "<?php echo base_url(); ?>libur/ajax_edit",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    calendar.refetchEvents();

                    $('#btnSaveLibur').text('Simpan');
                    $('#btnSaveLibur').attr('disabled', false);
                    $('#modal_libur').modal('hide');

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSaveLibur').text('Simpan'); //change button text
                    $('#btnSaveLibur').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function showinfo(id, title){
        $('#modal_form').modal('show');
        $('.modal-title').text('Group WA : ' + title);
        $.ajax({
            url: "<?php echo base_url(); ?>homependidikan/showinfo/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#id_jadwal_detil').val(id);
                $('#kursus').html(data.kursus);
                $('#sesi').html(data.sesi);
                $('#periode').html(data.periode);
                $('#hari').html(data.hari);
                $('#level').html(data.level);
                $('#zoom').html(data.zoom);
                $('#pengajar').html(data.pengajar);
                
                tb_siswa = $('#tb_siswa').DataTable({
                    ajax : "<?php echo base_url(); ?>homependidikan/ajaxjadwalsiswa/" + id,
                    retrieve : true
                });
                tb_siswa.destroy();
                tb_siswa = $('#tb_siswa').DataTable({
                    ajax : "<?php echo base_url(); ?>homependidikan/ajaxjadwalsiswa/" + id,
                    retrieve : true
                });
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: textStatus,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function closemodallibur(){
        $('#modal_libur').modal('hide');
    }
    
    function reload(){
        calendar.refetchEvents();
    }
    
    function add(startDate){
        $('#form_add')[0].reset();
        $('#modal_add').modal('show');
        $('.modal-title-add').text('Tambah Jadwal');
        document.getElementById('tgl_awal_new').value = startDate;
        document.getElementById('tgl_akhir_new').value = startDate;
        document.getElementById('rbKursus').checked = true;
        
        $('#wadah_jadwal').show();
        $('#wadah_libur').hide();
    }

    function closemodal_add(){
        $('#modal_add').modal('hide');
    }

    function saveAll(){
        if(document.getElementById('rbKursus').checked){
            saveJadwal();
        }else if(document.getElementById('rbLibur').checked){
            saveLibur();
        }
    }

    function pindahmode(){
        if(document.getElementById('rbKursus').checked){
            $('#wadah_jadwal').show();
            $('#wadah_libur').hide();
        }else if(document.getElementById('rbLibur').checked){
            $('#wadah_libur').show();
            $('#wadah_jadwal').hide();
        }
    }
    
    function saveLibur(){
        var kode = document.getElementById('kodeAdd').value;
        var judul = document.getElementById('judul_new').value;
        var deskripsi = document.getElementById('deskripsi_new').value;
        var link = document.getElementById('url_new').value;
        var tglawal = document.getElementById('tgl_awal_new').value;
        var tglakhir = document.getElementById('tgl_akhir_new').value;

        var tot = 0;
        if (judul === '') {
            document.getElementById('judul_new').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('judul_new').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tglawal === '') {
            document.getElementById('tgl_awal_new').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgl_awal_new').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tglakhir === '') {
            document.getElementById('tgl_akhir_new').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgl_akhir_new').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if(tot === 3){
            $('#btnSaveAdd').text('Menyimpan...');
            $('#btnSaveAdd').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('deskripsi', deskripsi);
            form_data.append('url', link);
            form_data.append('tglawal', tglawal);
            form_data.append('tglakhir', tglakhir);

            $.ajax({
                url: "<?php echo base_url(); ?>libur/ajax_add",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    reload();

                    $('#btnSaveAdd').text('Simpan');
                    $('#btnSaveAdd').attr('disabled', false);
                    $('#modal_add').modal('hide');

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSaveAdd').text('Simpan'); //change button text
                    $('#btnSaveAdd').attr('disabled', false); //set button enable 
                }
            });
        }
    }
    
    function hapusLibur() {
        var id = document.getElementById('kode').value;
        var nama = document.getElementById('judul').value;
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus " + nama + " ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        },function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>libur/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                            closemodallibur();
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }
    
    function pilihperiode(){
        var kursus = document.getElementById('kursus_add').value;
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/showperiode/" + kursus,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#periode_add').html(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function showlevel(){
        var kursus = document.getElementById('kursus_add').value;
        if(kursus === "-"){
            swal("Pilih kursus terlebih dahulu", "info");
        }else{
            $('#modal_level').modal('show');
            tb_level = $('#tb_level').DataTable({
                ajax: "<?php echo base_url(); ?>jadwal/ajaxlevel/" + kursus,
                retrieve : true
            });
            tb_level.destroy();
            tb_level = $('#tb_level').DataTable({
                ajax: "<?php echo base_url(); ?>jadwal/ajaxlevel/" + kursus,
                retrieve : true
            });
        }
    }
    
    function pilihlevel(idlevel, level){
        $('[name="idlevel_add"]').val(idlevel);
        $('[name="level_add"]').val(level);
        $('#modal_level').modal('hide');
    }
    
    function showzoom(){
        $('#modal_zoom').modal('show');
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
        tb_zoom.destroy();
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
    }
    
    function pilihzoom(id, link){
        $('[name="idzoom_add"]').val(id);
        $('[name="zoom_add"]').val(link);
        $('#modal_zoom').modal('hide');
    }
    
    function getHari(){
        var hari = "";
        if(document.getElementById('ckSenin').checked){
            hari += "Senin,";
        }
        if(document.getElementById('ckSelasa').checked){
            hari += "Selasa,";
        }
        if(document.getElementById('ckRabu').checked){
            hari += "Rabu,";
        }
        if(document.getElementById('ckKamis').checked){
            hari += "Kamis,";
        }
        if(document.getElementById('ckJumat').checked){
            hari += "Jumat,";
        }
        
        return hari.substring(0, hari.length -1);
    }
    
    function saveJadwal() {
        var kode = document.getElementById('kode').value;
        var g_wa = document.getElementById('g_wa_add').value;
        var kursus = document.getElementById('kursus_add').value;
        var sesi = document.getElementById('sesi_add').value;
        var periode = document.getElementById('periode_add').value;
        var hari = getHari();
        var idlevel = document.getElementById('idlevel_add').value;
        var level = document.getElementById('level_add').value;
        var idzoom = document.getElementById('idzoom_add').value;
        var zoom = document.getElementById('zoom_add').value;
        var mode_belajar = document.getElementById('mode_belajar').value;
        var tempat = document.getElementById('tempat').value;

        var tot = 0;
        if (g_wa === '') {
            document.getElementById('g_wa_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('g_wa_add').classList.remove('is-invalid');
            tot += 1;
        }

        if (kursus === '-') {
            document.getElementById('kursus_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('kursus_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (sesi === '-') {
            document.getElementById('sesi_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('sesi_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (periode === '-') {
            document.getElementById('periode_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('periode_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (hari === '') {
            document.getElementById('hari_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('hari_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (level === '') {
            document.getElementById('level_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('level_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (zoom === '') {
            document.getElementById('zoom_add').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('zoom_add').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (tot === 7) {
            $('#btnSaveAdd').text('Menyimpan...'); //change button text
            $('#btnSaveAdd').attr('disabled', true); //set button disable 

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('g_wa', g_wa);
            form_data.append('idsesi', sesi);
            form_data.append('periode', periode);
            form_data.append('kursus', kursus);
            form_data.append('hari', hari);
            form_data.append('idlevel', idlevel);
            form_data.append('zoom', zoom);
            form_data.append('idzoom', idzoom);
            form_data.append('mode_belajar', mode_belajar);
            form_data.append('tempat', tempat);

            $.ajax({
                url: "<?php echo base_url(); ?>jadwal/ajax_add_jadwal",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                    reload();

                    $('#modal_add').modal('hide');
                    $('#btnSaveAdd').text('Simpan');
                    $('#btnSaveAdd').attr('disabled', false);
                    
                }, error: function (jqXHR, textStatus, errorThrown) {
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSaveAdd').text('Simpan');
                    $('#btnSaveAdd').attr('disabled', false);
                }
            });
        }
    }
    
    function pindah(){
        $('#form_pindah_jadwal')[0].reset();
        $('#modal_pindah').modal('show');
        radio_pindah();
        
        var idjadwaldetil = document.getElementById('id_jadwal_detil').value;
        document.getElementById('id_jadwal_detil_pindah').value = idjadwaldetil;
        
        $.ajax({
            url: "<?php echo base_url(); ?>homependidikan/showpindah/" + idjadwaldetil,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                document.getElementById('id_jadwal_pindah').value = data.idjadwal;
                document.getElementById('rombel_pindah').value = data.groupwa;
                document.getElementById('tgl_sebelum_pindah').value = data.tanggal;
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal_pindah(){
        $('#modal_pindah').modal('hide');
    }
    
    function savePindahJadwal(){
        var idjadwaldetil = document.getElementById('id_jadwal_detil_pindah').value;
        var idjadwal = document.getElementById('id_jadwal_pindah').value;
        var tgl_pindah = document.getElementById('tgl_pindah').value;
        var maju_mundur_minggu = document.getElementById('maju_mundur_minggu').value;
        var maju_mundur_hari = document.getElementById('maju_mundur_hari').value;
        
        if(document.getElementById('rbBerlakuSingle').checked){

            if(tgl_pindah === ""){
                iziToast.error({
                    title: 'Stop',
                    message: "Tanggal pindah tidak boleh kosong",
                    position: 'topRight'
                });
            }else{
                
                $('#btnSavePindah').text('Menyimpan...');
                $('#btnSavePindah').attr('disabled', true);

                var form_data = new FormData();
                form_data.append('idjadwaldetil', idjadwaldetil);
                form_data.append('idjadwal', idjadwal);
                form_data.append('tgl_pindah', tgl_pindah);

                $.ajax({
                    url: "<?php echo base_url(); ?>homependidikan/proses_pindah_jadwal",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {

                        if(data.status === "Jadwal berhasil dipindah"){

                            iziToast.success({
                                title: 'Info',
                                message: data.status,
                                position: 'topRight'
                            });
                            reload();

                            $('#modal_pindah').modal('hide');
                            $('#modal_form').modal('hide');

                        }else{
                            iziToast.error({
                                title: 'Error',
                                message: data.status,
                                position: 'topRight'
                            });
                        }

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);

                    }, error: function (jqXHR, textStatus, errorThrown) {

                        iziToast.error({
                            title: 'Error',
                            message: errorThrown,
                            position: 'topRight'
                        });

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);
                    }
                });
            }
            
            
        }else if(document.getElementById('rbBerlakuMulti').checked && document.getElementById('rbMinggu').checked){
            
            if(maju_mundur_minggu === ""){
                iziToast.error({
                    title: 'Stop',
                    message: "Maju minggu tidak boleh kosong",
                    position: 'topRight'
                });
            }else{

                $('#btnSavePindah').text('Menyimpan...');
                $('#btnSavePindah').attr('disabled', true);

                var form_data = new FormData();
                form_data.append('idjadwaldetil', idjadwaldetil);
                form_data.append('idjadwal', idjadwal);
                form_data.append('maju_mundur_minggu', maju_mundur_minggu);

                $.ajax({
                    url: "<?php echo base_url(); ?>homependidikan/proses_pindah_jadwal_multi",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {

                        if(data.status === "Jadwal berhasil dipindah"){

                            iziToast.success({
                                title: 'Info',
                                message: data.status,
                                position: 'topRight'
                            });
                            reload();

                            $('#modal_pindah').modal('hide');
                            $('#modal_form').modal('hide');

                        }else{
                            iziToast.error({
                                title: 'Error',
                                message: data.status,
                                position: 'topRight'
                            });
                        }

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);

                    }, error: function (jqXHR, textStatus, errorThrown) {

                        iziToast.error({
                            title: 'Error',
                            message: errorThrown,
                            position: 'topRight'
                        });

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);
                    }
                });
                
            }
            
        }else if(document.getElementById('rbBerlakuMulti').checked && document.getElementById('rbHari').checked){
            
            if(maju_mundur_hari === ""){
                iziToast.error({
                    title: 'Stop',
                    message: "Maju hari tidak boleh kosong",
                    position: 'topRight'
                });
            }else{

                $('#btnSavePindah').text('Menyimpan...');
                $('#btnSavePindah').attr('disabled', true);

                var form_data = new FormData();
                form_data.append('idjadwaldetil', idjadwaldetil);
                form_data.append('idjadwal', idjadwal);
                form_data.append('maju_mundur_hari', maju_mundur_hari);

                $.ajax({
                    url: "<?php echo base_url(); ?>homependidikan/proses_pindah_jadwal_multi_hari",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {

                        if(data.status === "Jadwal berhasil dipindah"){

                            iziToast.success({
                                title: 'Info',
                                message: data.status,
                                position: 'topRight'
                            });
                            reload();

                            $('#modal_pindah').modal('hide');
                            $('#modal_form').modal('hide');

                        }else{
                            iziToast.error({
                                title: 'Error',
                                message: data.status,
                                position: 'topRight'
                            });
                        }

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);

                    }, error: function (jqXHR, textStatus, errorThrown) {

                        iziToast.error({
                            title: 'Error',
                            message: errorThrown,
                            position: 'topRight'
                        });

                        $('#btnSavePindah').text('Pindah Jadwal');
                        $('#btnSavePindah').attr('disabled', false);
                    }
                });
                
            }
            
        }

    }
    
    function radio_pindah(){
        if(document.getElementById('rbBerlakuSingle').checked){
            $('#keterangan_pindah_all').html("");
            $('#lay_pindah1').show();
            $('#lay_pindah2').hide();
            $('#lay_hari').hide();
        }else if(document.getElementById('rbBerlakuMulti').checked){
            var tmp = document.getElementById('tgl_sebelum_pindah').value;
            $('#keterangan_pindah_all').html("Berlaku dari " + tmp + " dan setelahnya");
            $('#lay_pindah1').hide();
            $('#lay_pindah2').show();
        }
    }

    function radio_hari(){
        if(document.getElementById('rbHari').checked){
            $('#lay_hari').show();
            $('#lay_minggu').hide();
        }else if(document.getElementById('rbMinggu').checked){
            var tmp = document.getElementById('tgl_sebelum_pindah').value;
            $('#lay_hari').hide();
            $('#lay_minggu').show();
        }
    }

    function cari_jadwal_siswa(){
        $('#modal_cari_jadwal_siswa_1').modal('show');
        load_jadwal_siswa();
    }
    
    function load_jadwal_siswa(){
        var idsiswa = document.getElementById('idsiswa').value;
        tb_jadwal_siswa = $('#tb_jadwal_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/ajaxmodaljadwalsiswa/" + idsiswa,
            retrieve:true
        });
        tb_jadwal_siswa.destroy();
        tb_jadwal_siswa = $('#tb_jadwal_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/ajaxmodaljadwalsiswa/" + idsiswa,
            retrieve:true
        });
    }

    function cari_jadwal_guru(){
        $('#modal_cari_jadwal_guru').modal('show');
        load_jadwal_guru();
    }

    function load_jadwal_guru(){
        var idusers_guru = document.getElementById('idusers_guru').value;
        tb_jadwal_guru = $('#tb_jadwal_guru').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/ajaxjadwalguru/" + idusers_guru,
            retrieve:true
        });
        tb_jadwal_guru.destroy();
        tb_jadwal_guru = $('#tb_jadwal_guru').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/ajaxjadwalguru/" + idusers_guru,
            retrieve:true
        });
    }

    function showlistguru(){
        $('#modal_list_guru').modal('show');
        tb_list_guru = $('#tb_list_guru').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/listguru",
            retrieve:true
        });
        tb_list_guru.destroy();
        tb_list_guru = $('#tb_list_guru').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/listguru",
            retrieve:true
        });
    }

    function pilihguru(idusers, nama){
        $('[name="idusers_guru"]').val(idusers);
        $('[name="nama_guru"]').val(nama);
        $('#modal_list_guru').modal('hide');
        load_jadwal_guru();
    }

    function showlistsiswa(){
        $('#modal_list_siswa').modal('show');
        tb_list_siswa = $('#tb_list_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/listsiswa",
            retrieve:true
        });
        tb_list_siswa.destroy();
        tb_list_siswa = $('#tb_list_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>homependidikan/listsiswa",
            retrieve:true
        });
    }

    function pilihsiswa(idsiswa, nama){
        $('[name="idsiswa"]').val(idsiswa);
        $('[name="nama_siswa"]').val(nama);
        $('#modal_list_siswa').modal('hide');
        load_jadwal_siswa();
    }

    function cek_koneksi_wa(){
        $('#form_koneksi_wa')[0].reset();
        $('#modal_wa_koneksi').modal('show');
        $.ajax({
            url : "<?php echo base_url(); ?>homependidikan/getInfoPaketWA",
            type: "POST",
            dataType: "JSON",
            success: function(data){
                $('#status_wa').val(data.data.status);
                $('#no_wa').val(data.data.nomor);
                $('#nama_wa').val(data.data.nama);
                
            },error: function (jqXHR, textStatus, errorThrown){
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Beranda</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Beranda</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="cari_jadwal_siswa();"><i class="fas fa-search"></i> Jadwal Siswa </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="cari_jadwal_guru();"><i class="fas fa-search"></i> Jadwal Pengajar </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="cek_koneksi_wa();"><i class="feather icon-wifi"></i> Cek Koneksi WA </button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5 class="modal-title" style="color: blue;">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_jadwal_detil" readonly>
                <table style="width: 100%;">
                    <tr>
                        <td><p><b>KURSUS</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="kursus"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>SESI</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="sesi"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>TAHUN AJAR</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="periode"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>HARI</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="hari"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>LEVEL</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="level"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>ZOOM</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="zoom"></p></td>
                    </tr>
                    <tr>
                        <td><p><b>PENGAJAR</b></p></td>
                        <td><p>&nbsp;:&nbsp;</p></td>
                        <td><p id="pengajar"></p></td>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="pindah();">Pindah Jadwal</button>
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
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
            <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Judul</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" autocomplete="off">
                            <small class="invalid-feedback">Judul wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link / Url</label>
                            <input type="text" id="url" name="url" class="form-control" placeholder="Link / Url" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date" id="tgl_awal" name="tgl_awal" class="form-control" placeholder="Tanggal Awal" autocomplete="off" value="<?php echo $curdate; ?>">
                            <small class="invalid-feedback">Tanggal awal wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control" placeholder="Tanggal Akhir" autocomplete="off" value="<?php echo $curdate; ?>">
                            <small class="invalid-feedback">Tanggal akhir wajib diisi</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closemodallibur();">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="hapusLibur();">Hapus</button>
                <button id="btnSaveLibur" type="button" class="btn btn-primary" onclick="editLibur();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5 class="modal-title-add">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_add">
                    <input type="hidden" id="kodeAdd" name="kodeAdd">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jenis Jadwal</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input onchange="pindahmode();"; class="form-check-input" type="radio" id="rbKursus" name="jenis_jadwal" checked value="Kursus"> Kursus 
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input onchange="pindahmode();" class="form-check-input" type="radio" id="rbLibur" name="jenis_jadwal" value="Libur"> Libur 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="wadah_jadwal">
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Group WA</label>
                                <input type="text" id="g_wa_add" name="g_wa_add" class="form-control" placeholder="Group WA" autocomplete="off">
                                <small class="invalid-feedback">Group WA wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Sesi</label>
                                <select id="sesi_add" name="sesi_add" class="form-control">
                                    <option value="-">- Pilih -</option>
                                    <?php
                                    foreach ($sesi->getResult() as $row) {
                                        ?>
                                    <option value="<?php echo $row->idsesi; ?>"><?php echo $row->nama_sesi.' ('.$row->waktu_awal.' - '.$row->waktu_akhir.')'; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <small class="invalid-feedback">Pilih sesi terlebih dahulu</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Kursus</label>
                                <select id="kursus_add" name="kursus_add" class="form-control" onchange="pilihperiode();">
                                    <option value="-">- Pilih -</option>
                                    <option value="English">English</option>
                                    <option value="Coding">Coding</option>
                                </select>
                                <small class="invalid-feedback">Pilih jenis kursus</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Periode</label>
                                <select id="periode_add" name="periode_add" class="form-control">
                                    <option value="-">- Pilih -</option>
                                </select>
                                <small class="invalid-feedback">Pilih periode kursus</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Level</label>
                                <div class="input-group">
                                    <input type="hidden" id="idlevel_add" name="idlevel_add" readonly autocomplete="off">
                                    <input type="text" id="level_add" name="level_add" class="form-control" placeholder="Level" readonly autocomplete="off">
                                    <span class="input-group-append">
                                        <button class="btn btn-sm btn-secondary" type="button" onclick="showlevel();">...</button>
                                    </span>
                                    <small class="invalid-feedback">Level wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Hari</label>
                                <div id="hari_add">
                                    <label class="form-check form-check-inline">
                                        <input id="ckSenin" class="form-check-input" type="checkbox" value="Senin">
                                        <span class="form-check-label">Senin</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input id="ckSelasa" class="form-check-input" type="checkbox" value="Selasa">
                                        <span class="form-check-label">Selasa</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input id="ckRabu" class="form-check-input" type="checkbox" value="Rabu">
                                        <span class="form-check-label">Rabu</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input id="ckKamis" class="form-check-input" type="checkbox" value="Kamis">
                                        <span class="form-check-label">Kamis</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input id="ckJumat" class="form-check-input" type="checkbox" value="Jumat">
                                        <span class="form-check-label">Jumat</span>
                                    </label>
                                </div>
                                <small class="invalid-feedback">Pilih hari</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Zoom</label>
                                <div class="input-group">
                                    <input type="hidden" id="idzoom_add" name="idzoom_add" readonly autocomplete="off">
                                    <input type="text" id="zoom_add" name="zoom_add" class="form-control" placeholder="Zoom Meeting" readonly autocomplete="off">
                                    <span class="input-group-append">
                                        <button class="btn btn-sm btn-secondary" type="button" onclick="showzoom();">...</button>
                                    </span>
                                    <small class="invalid-feedback">Link Zoom wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Model Belajar</label>
                                <select id="mode_belajar" name="mode_belajar" class="form-control">
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Tempat Belajar</label>
                                <input type="text" id="tempat" name="tempat" class="form-control" placeholder="Tempat Belajar" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div id="wadah_libur" style="display: none;">
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Judul</label>
                                <input type="text" id="judul_new" name="judul_new" class="form-control" placeholder="Judul" autocomplete="off">
                                <small class="invalid-feedback">Judul wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" id="deskripsi_new" name="deskripsi_new" class="form-control" placeholder="Deskripsi" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Link / Url</label>
                                <input type="text" id="url_new" name="url" class="form-control" placeholder="Link / Url" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Tanggal Awal</label>
                                <input type="date" id="tgl_awal_new" name="tgl_awal_new" class="form-control" placeholder="Tanggal Awal" autocomplete="off">
                                <small class="invalid-feedback">Tanggal awal wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" id="tgl_akhir_new" name="tgl_akhir_new" class="form-control" placeholder="Tanggal Akhir" autocomplete="off">
                                <small class="invalid-feedback">Tanggal akhir wajib diisi</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal_add();">Tutup</button>
                <button id="btnSaveAdd" type="button" class="btn btn-primary" onclick="saveAll();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_level">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_level" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Level</th>
                                <th style="text-align: center;">Aksi</th>
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

<div class="modal fade" id="modal_zoom">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Zoom</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_zoom" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Meeting ID</th>
                                <th>Passcode</th>
                                <th style="text-align: center;">Aksi</th>
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

<div class="modal fade" id="modal_pindah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5>Pindah Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_pindah_jadwal">
                    <input type="hidden" id="id_jadwal_detil_pindah" name="id_jadwal_detil_pindah" readonly>
                    <input type="hidden" id="id_jadwal_pindah" name="id_jadwal_pindah" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Rombel</label>
                            <input type="text" id="rombel_pindah" name="rombel_pindah" class="form-control" placeholder="Rombel" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date" id="tgl_sebelum_pindah" name="tgl_sebelum_pindah" class="form-control" placeholder="Tanggal Pindah" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Berlaku</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="rbBerlakuSingle" name="rbBerlaku" checked value="Single" onchange="radio_pindah();"> 
                                    Hanya tanggal tersebut
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="rbBerlakuMulti" name="rbBerlaku" value="Multi" onchange="radio_pindah();"> 
                                    Semua Rombel tersebut
                                    <p id="keterangan_pindah_all" style="color: red;"></p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" id="lay_pindah1" style="display: block;">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Pindah</label>
                            <input type="date" id="tgl_pindah" name="tgl_pindah" class="form-control" placeholder="Tanggal Pindah" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row" id="lay_pindah2" style="display: none;">
                        <div class="form-group col">
                            <label class="form-label">Berdasarkan : </label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="rbHari" name="rbBerdasarkan" value="Hari" onchange="radio_hari();"> 
                                   Hari
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="rbMinggu" name="rbBerdasarkan" value="Minggu" onchange="radio_hari();"> 
                                    Minggu
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" id="lay_minggu" style="display: none;">
                        <div class="form-group col">
                            <label class="form-label">Digeser Berapa Minggu ?</label>
                            <input type="text" id="maju_mundur_minggu" name="maju_mundur_minggu" class="form-control" placeholder="+1" value="+1" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row" id="lay_hari" style="display: none;">
                        <div class="form-group col">
                            <label class="form-label">Digeser Berapa Hari ?</label>
                            <input type="text" id="maju_mundur_hari" name="maju_mundur_hari" class="form-control" placeholder="+1" value="+1" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal_pindah();">Tutup</button>
                <button id="btnSavePindah" type="button" class="btn btn-primary" onclick="savePindahJadwal();">Pindah Jadwal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_cari_jadwal_siswa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Jadwal Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_zoom" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Meeting ID</th>
                                <th>Passcode</th>
                                <th style="text-align: center;">Aksi</th>
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

<div class="modal fade" id="modal_cari_jadwal_guru">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Jadwal Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="input-group">
                            <input type="hidden" id="idusers_guru" name="idusers_guru" readonly autocomplete="off">
                            <input type="text" id="nama_guru" name="nama_guru" class="form-control" placeholder="Nama Guru" readonly autocomplete="off">
                            <span class="input-group-append">
                                <button class="btn btn-sm btn-secondary" type="button" onclick="showlistguru();">...</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="tb_jadwal_guru" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal<br>Waktu</th>
                                <th>Kursus</th>
                                <th>Level</th>
                                <th>Hari</th>
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

<div class="modal fade" id="modal_list_guru">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_list_guru" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>WA</th>
                                <th style="text-align:center;">Aksi</th>
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

<div class="modal fade" id="modal_cari_jadwal_siswa_1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Jadwal Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="input-group">
                            <input type="hidden" id="idsiswa" name="idsiswa" readonly autocomplete="off">
                            <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="Nama Siswa" readonly autocomplete="off">
                            <span class="input-group-append">
                                <button class="btn btn-sm btn-secondary" type="button" onclick="showlistsiswa();">...</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="tb_jadwal_siswa" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal<br>Waktu</th>
                                <th>Kursus</th>
                                <th>Level</th>
                                <th>Hari</th>
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

<div class="modal fade" id="modal_list_siswa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_list_siswa" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>Jkel</th>
                                <th style="text-align:center;">Aksi</th>
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

<div class="modal fade" id="modal_wa_koneksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header with-border">
                <h5>Koneksi WA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_koneksi_wa">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status WA</label>
                            <input type="text" id="status_wa" name="status_wa" class="form-control" placeholder="Status WA" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nomor WA</label>
                            <input type="text" id="no_wa" name="no_wa" class="form-control" placeholder="Nomor WA" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">NAMA WA</label>
                            <input type="text" id="nama_wa" name="nama_wa" class="form-control" placeholder="Nama WA" autocomplete="off" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>