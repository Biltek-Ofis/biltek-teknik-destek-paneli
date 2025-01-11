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
        --kis_arkaplani:linear-gradient(#123, #111);;
    }
    .login-box .card {
        background: rgba(170, 166, 166, 0.6) !important;
    }
    body{
        scrollbar-color: var(--kis_arkaplani) !important;
    }
    body,
    .modal-content{
        background: var(--kis_arkaplani) !important;
        color: #fff !important;
    }
        
    .bg-light, .login-box .card{
        color: black !important;
    }
    .dropdown-menu, .login-box{
        background: var(--kis_arkaplani) !important;
    }
    .navbar-light .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba%28255, 255, 255, 1%29\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E");
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
    .paginate_button a,
    .nav-item{
        background: transparent !important;
    }
    .paginate_button a, .breadcrumb-item.active, .nav-tabs .nav-link.active{
        color: #fff !important;
    }
    input[type="search"], select{
        border-color: #fff !important;
    }
    input:not([type="submit"]),
    textarea,
    select,
    label,
    h1,
    h2,
    h3,
    h4,
    h5,
    .navbar .collapse .nav-link, .dropdown-item a{
        color: #fff !important;
    }
    .navbar .collapse .nav-item.active .nav-link,
    .dropdown-item.active a{
        color: rgba(255, 255, 255, 0.7) !important;
    }
    .navbar .dropdown-item:hover:not(.active),
    .navbar .dropdown-item:hover:not(.active) a,
    .navbar .dropdown-item:not(.active) a:hover,
    select option{
        color: black !important;
    }
    ::placeholder {
        color: #fff !important;
        opacity: 0.59 !important;
    }

    ::-ms-input-placeholder { 
        color: #fff !important;
        opacity: 0.5 !important;
    }

    
    .kis_modu_yok{
        background: #ffffff !important;
        color: black !important;
    }
</style>';
}
echo '<style>
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }


    @-webkit-keyframes rotate {
        from {
            -webkit-transform: rotate(0deg);
        }

        to {
            -webkit-transform: rotate(360deg);
        }
    }

    .yukleniyorDaire {
        width: 100px;
        height: 100px;
        /* margin: 110px auto 0;*/
        margin: auto;
        border: solid 10px gray;
        border-radius: 50%;
        border-right-color: transparent;
        border-bottom-color: transparent;
        -webkit-transition: all 0.5s ease-in;
        -webkit-animation-name: rotate;
        -webkit-animation-duration: 1.0s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;

        transition: all 0.5s ease-in;
        animation-name: rotate;
        animation-duration: 1.0s;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }
    .yukleniyorMesaj{
        width:100%;
        text-align: center;
        margin: auto;
        margin-top: 50px;
    }
</style>';