@extends('layouts.app')

@section('title', 'Dashboar Orang Tua')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="#" class="d-none d-sm-inline-block btn btn-sm shadow-sm" style="background-color: #9EDF9C;">
        <i class="fas fa-download fa-sm text-success-50" style="color:#526E48;"></i>
        <span style="color: #526E48;">Unduh Hasil Rapor</span>
    </a>
</div>
<div id="tree_wrapper"></div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
<script type="module" src="{{ asset('/js/three-murid.js') }}"></script>
@endsection