
<script type="text/javascript">

    var save_method; //for save method string

    $('#errorsetuju').hide();

    function save(){
        var setuju = document.getElementById('setuju').checked;

        var tot = 0;
        if (setuju === false) {$('#errorsetuju').show();}else{$('#errorsetuju').hide(); tot += 1;} 

        if(tot === 1){
            $('#btnSave').text('Mengirim...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>pemutusan/ajax_add";
            
            var form_data = new FormData();
            form_data.append('setuju', setuju);
            
            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                traditional: true,
                type: 'POST',
                success: function (data) {
                    swal({
                        title: "Berhasil!",
                        text: "Sistem akan mengarahkan ke form pemutusan kontrak",
                        type: "success",
                        timer: 1000
                    }, function () {
                        window.location.href = "<?php echo base_url(); ?>pemutusan/";
                    });

                    $('#btnSave').text('Kirim'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Kirim'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }
</script>
<div class="container flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <h6 class="card-header">Syarat Resign</h6>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="kode" name="kode" value="">
                        <div class="col-12">
                            <p><?php echo $syarat; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setuju" name="setuju" value="1">
                            <span class="custom-control-label" for="setuju">Saya menyatakan bahwa saya telah membaca, memahami, dan menyetujui seluruh syarat yang telah dijelaskan di atas. <span id="errorsetuju" style="color: red;">*Wajib</span></span>
                        </label>
                    </div>
                    <button type="button" class="btn btn-info btn-block mt-4" onclick="save();">Setuju</button>
                </div>
            </div>
        </div>
    </div>