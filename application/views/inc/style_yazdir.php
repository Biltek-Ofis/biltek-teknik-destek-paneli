<?php
echo '<style>
    div.portre,
    div.dondur {
        margin: 10px auto;
        padding: 10mm;
        border: solid 1px black;
        overflow: hidden;
        page-break-after: always;
        background: white;
    }

    div.portre {
        width: '.A4_GENISLIK.'mm;
        height: '.A4_YUKSEKLIK.'mm;
    }

    div.dondur {
        width: '.A4_YUKSEKLIK.'mm;
        height: '.A4_GENISLIK.'mm;
    }
    @media print {
        body {
            background: none;
            -ms-zoom: 1.665;
        }
        div.portre,
        div.dondur {
            border: none;
            background: none;
            page-break-inside: avoid;
            break-inside: avoid;
            page-break-before: always;
            break-before: always;
        }

        div.dondur {
            transform: rotate(270deg) translate(-'.(A4_YUKSEKLIK).'mm, 0);
            transform-origin: 0 0;
        }
    }
</style>';
