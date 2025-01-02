<?php
echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="' . base_url("plugins/fontawesome-free/css/all.min.css") . '">
<link rel="stylesheet" href="' . base_url("dist/css/panel.min.css") . '">
<link rel="stylesheet" href="' . base_url("dist/css/style.css") . '">';

$ayarlar = $this->Ayarlar_Model->getir();
if($ayarlar->kis_modu == 1){
	echo '
<style>
    :root {
        --kis_arkaplani: rgba(108, 117, 125, 0.5);
    }
    .login-box .card {
        background-color: rgba(108, 117, 125, 0.6) !important;
    }
    body{
        scrollbar-color: var(--kis_arkaplani) !important;
    }
    body,
    .modal-content{
        background-color: var(--kis_arkaplani) !important;
    }
    .modal-dialog, .dropdown-menu, .login-box{
        background-color: #ffffff !important;
    }
    .wrapper, 
    .navbar, 
    .content-wrapper,
    .list-group-item,
    .nav-tabs .nav-link.active,
    .input-group-append,
    .input-group-text,
    input:not([type="submit"]),
    textarea,
    select,  
    .content-wrapper .card,
    .pagination, 
    .dataTables_paginate, 
    .paginate_button, 
    .paginate_button a{
        background-color: transparent !important;
    }
    .paginate_button a, .breadcrumb-item.active{
        color: black !important;
    }
    input[type="search"], select{
        border-color: #ffffff;
    }
    input:not([type="submit"]),
    textarea,
    select{
        color: black !important;
    }
    ::placeholder {
        color: black !important;
        opacity: 0.5 !important;
    }

    ::-ms-input-placeholder { 
        color: black !important;
        opacity: 0.5 !important;
    }

    
    .kis_modu_yok{
        background-color: #ffffff !important;
    }
</style>';
}
