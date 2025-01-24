                </div>
                    <!-- [ content ] End -->
                    <!-- [ Layout footer ] Start -->
                    <nav class="layout-footer footer footer-light">
                        <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="float-md-right d-none d-lg-block">&copy; Leap Surabaya 2023</span>
                            </div>
                        </div>
                    </nav>
                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
            <input type="hidden" id="status" value="<?php echo $status;?>"/>
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core scripts -->
    <script src="<?php echo base_url(); ?>back/assets/js/pace.js"></script>
        
    <script src="<?php echo base_url(); ?>back/assets/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/sidenav.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/layout-helpers.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="<?php echo base_url(); ?>back/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/datatables/datatables.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-sweetalert/bootstrap-sweetalert.js"></script>
    
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/moment/moment.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/timepicker/timepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/minicolors/minicolors.js"></script> 
    <script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>

    <!-- Demo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/analytics.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/pages/tables_datatables.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/pages/ui_modals.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>back/assets/src/phonemask.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.1/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript">
        // const cssPhone = 'input[name="phone"';
        // (new phoneMask()).init(cssPhone);
        $("#telp").inputmask({"mask": "9999-9999-9999"});
        $("#phone").inputmask({"mask": "9999-9999-9999"});
        $("#npwp").inputmask({"mask": "99.999.999.9-999.999"});
        $("#email").inputmask("email");

        function hanyaAngka(e, decimal) {
            var key;
            var keychar;
            if (window.event) {
                key = window.event.keyCode;
            } else if (e) {
                key = e.which;
            } else {
                return true;
            }
            keychar = String.fromCharCode(key);
            if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                return true;
            } else if ((("0123456789").indexOf(keychar) > -1)) {
                return true;
            } else if (decimal && (keychar == ".")) {
                return true;
            } else {
                return false;
            }
        }

        // Bootstrap Maxlength
        $(function() {
            $('.bootstrap-maxlength-example').each(function() {
                $(this).maxlength({
                warningClass: 'label label-success',
                limitReachedClass: 'label label-danger',
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true,
                threshold: +this.getAttribute('maxlength')
                });
            });

            var isRtl = $('html').attr('dir') === 'rtl';

            $('#datepicker-base').datepicker({
                orientation: isRtl ? 'auto right' : 'auto left'
            });

            $('#daterange-2').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                format: 'd MMMM Y h:mm A'
                },
                opens: (isRtl ? 'left' : 'right')
            });            
        });

        function confirmation(ev) {
            $status = document.getElementById('status').value;
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            console.log(urlToRedirect); // verify if this is the right URL
            if($status == 1){
                window.location.href = "<?php echo base_url(); ?>pemutusan/";
            }else{
                swal({
                    title: 'Apa anda Yakin?',
                    text: "Sistem akan mengarahkan anda ke halaman pengajuan pemutusan kontrak. Pastikan Anda yakin dengan pilihan Anda!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Ya, Saya yakin!',
                    confirmButtonText: 'Tidak!',
                    reverseButtons: true,
                    dangerMode: true,
                    closeOnConfirm: true,
                    closeOnCancel: false,
                },
                function(isConfirm) {
                    if (isConfirm === false) {
                        window.location.href = "<?php echo base_url(); ?>pemutusan/syarat/";
                    }
                });
            }

        }
    </script>
</body>

</html>
