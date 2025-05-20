<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="' . base_url("dist/css/style.css") . '">
';
$ayarlar = $this->Ayarlar_Model->getir();
echo '  
<style>
    .dt-column-title .nav-item a,
    .dt-column-title ul li.dropdown-item a{
        color: var(--bs-table-color) !important;
    }
    .dt-column-title ul li.dropdown-item.active a,
    .dt-column-title ul li.dropdown-item:focus-within,
    .dt-column-title ul li.dropdown-item:focus{
        color: var(--bs-dropdown-link-active-color) !important;
        background-color: var(--bs-dropdown-link-active-bg) !important;
    }
    svg.patternlock g.lock-lines line {
        stroke-width: 1.5;
        stroke: black !important;
        opacity: 0.5;
    }
    svg.patternlock g.lock-actives circle,
    svg.patternlock g.lock-dots circle {
        fill: black") !important;
    }
    .ozel_tema_yok{
        background: #ffffff !important;
        color: black !important;
    }
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