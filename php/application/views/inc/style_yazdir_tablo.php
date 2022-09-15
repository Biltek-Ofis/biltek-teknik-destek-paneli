<?php
echo '
    <style>
    @media print {
        .table thead{
            height:0 !important;
        }
        .table thead tr td, .table thead tr th {
            border: 0 !important;
            padding: 0 !important;
            height: 0 !important;
            -webkit-print-color-adjust: exact;
        }

        .table tbody tr td, .table tbody tr th {
            border-width: 1px !important;
            border-style: solid !important;
            border-color: black !important;
            padding: 2px;
            -webkit-print-color-adjust: exact;
        }
        
        .table tbody tr td.alt_cizgi, table tbody tr th.alt_cizgi{
            border: 0 !important;
            border-bottom: 1px solid black !important;
        }
    }
    .table thead tr td, .table thead tr th {
        border: 0 !important;
        padding: 0 !important;
        height: 0 !important;
    }

    .table tbody tr td, .table tbody tr th {
        border-width: 1px !important;
        border-style: solid !important;
        border-color: black !important;
        padding: 2px;
    }
    .table tbody tr td.alt_cizgi,table tbody tr th.alt_cizgi{
        border: 0 !important;
        border-bottom: 1px solid black !important;
    }
    </style>
';
