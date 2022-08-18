<?php
defined('BASEPATH') or exit('No direct script access allowed');

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Servis Kabul</title>';
$this->load->view("inc/meta");
$this->load->view("inc/styles");
echo '<link rel="stylesheet" href="' . base_url("plugins/icheck-bootstrap/icheck-bootstrap.min.css") . '">';
$this->load->view("inc/scripts");
if (strlen($servis_no)) {
} else {
    echo '<script>
    $(document).ready(function(){
        var servis_no = $("#servis_no");
        $("#ara").on("click", function(){
            var servis_no_val = servis_no.val();
            if(servis_no_val.length > 0){
                window.location.href = "' . base_url("serviskabul") . '/" + servis_no_val;
            }else{
                $("#uyari").show();
            }
        });
        servis_no.keyup(function(){
            $("#uyari").hide();
        });
    });
    </script>';
}
echo '</head>';
if (strlen($servis_no)) {
    echo '<body></body>';
} else {
    echo '<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="https://biltekbilgisayar.com.tr" target="_blank" class="h1 w-100 text-center"><img height="100" src="' . base_url("dist/img/logo.png") . '"/></a>
            </div>
            <div class="card-body">
            <div id="uyari" class="alert alert-danger" style="display:none;" role="alert">Lütfen bir servis numarası girin.</div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-laptop"></span>
                        </div>
                    </div>
                    <input type="text" id="servis_no" name="servis_no" class="form-control" placeholder="Servis Numarası">
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4">
                        <button id="ara" type="submit" class="btn btn-primary btn-block">Ara</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>';
}
echo '</html>';
