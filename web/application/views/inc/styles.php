<?php
echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link rel="stylesheet" href="' . base_url("dist/css/panel.min.css") . '">
<link rel="stylesheet" href="' . base_url("dist/css/style.css") . '">';
echo '
<style>
';
$ayarlar = $this->Ayarlar_Model->getir();
$tema = $this->Ayarlar_Model->kullaniciTema();
if(strlen($tema->arkaplan) > 0){
    echo ':root {
        --tema_arkaplani:'.$tema->arkaplan.';
    }';
}
echo '
    svg.patternlock g.lock-lines line {
        stroke-width: 1.5;
        stroke: '.(strlen($tema->yazi_rengi) > 0 ? "".$tema->yazi_rengi : "black").' !important;
        opacity: 0.5;
    }
    svg.patternlock g.lock-actives circle,
    svg.patternlock g.lock-dots circle {
        fill: '.(strlen($tema->yazi_rengi) > 0 ? "".$tema->yazi_rengi : "black").' !important;
    }
        ';
if(strlen($tema->giris_arkaplani) > 0){
    echo '.login-box .card {
        background: '.$tema->giris_arkaplani.'!important;
    }';
}
    echo ' body{
    ';
if(strlen($tema->arkaplan) > 0){
    echo '
        scrollbar-color: var(--tema_arkaplani) !important;
    ';
}
    echo '
    }
    body,
    .modal-content{';
if(strlen($tema->arkaplan) > 0){
echo '
        background: var(--tema_arkaplani) !important;';
}
if(strlen($tema->yazi_rengi) > 0){
echo '
        color: '.$tema->yazi_rengi.' !important;';
}
    
    echo '
    }';
if(strlen($tema->beyaz_arkaplan_yazi) > 0){
    echo ' 
    .bg-light, .login-box .card{
        color: '.$tema->beyaz_arkaplan_yazi.' !important;
    }';
}
if(strlen($tema->arkaplan) > 0){
    echo ' 
    .dropdown-menu, .login-box{
        background: var(--tema_arkaplani) !important;
    }';
}
if(strlen($tema->menu_icon_rengi) > 0){
    echo '
    .navbar-light .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 30 30\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba%28'.$tema->menu_icon_rengi.'%29\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 7h22M4 15h22M4 23h22\'/%3E%3C/svg%3E");
    }';
}
if(strlen($tema->arkaplan) > 0){
    echo '.wrapper, 
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
    }';
}
if(strlen($tema->yazi_rengi) > 0){
    list($kirmizi, $yesil, $mavi) = sscanf($tema->yazi_rengi, "#%02x%02x%02x");
    
    echo '
    .paginate_button a, .breadcrumb-item.active, .nav-tabs .nav-link.active{
        color: '.$tema->yazi_rengi.' !important;
    }
    input[type="search"], select{
        border-color: '.$tema->yazi_rengi.' !important;
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
        color: '.$tema->yazi_rengi.' !important;
    }
    .navbar .collapse .nav-item.active .nav-link,
    .dropdown-item.active a{
        color: rgba('.$kirmizi.', '.$yesil.', '.$mavi.', 0.7) !important;
    }
    .musteri_adi_liste .dropdown-item:not(:hover){
        color: '.$tema->yazi_rengi.' !important;
    }';
}
if(strlen($tema->beyaz_arkaplan_yazi) > 0){
   echo '.navbar .dropdown-item:hover:not(.active),
    .navbar .dropdown-item:hover:not(.active) a,
    .navbar .dropdown-item:not(.active) a:hover,
    select option{
        color: '.$tema->beyaz_arkaplan_yazi.' !important;
    }';
}
if(strlen($tema->yazi_rengi) > 0){
   echo '::placeholder {
        color: '.$tema->yazi_rengi.' !important;
        opacity: 0.59 !important;
    }
    ::-ms-input-placeholder { 
        color: '.$tema->yazi_rengi.' !important;
        opacity: 0.5 !important;
    }';

}
echo '.ozel_tema_yok{
        background: #ffffff !important;
        color: black !important;
    }';
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