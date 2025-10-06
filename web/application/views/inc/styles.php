<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php
$this->load->view("inc/ortak/styles");
?>
<style>
    input[type="date"],
    input[type="date-local"],
    input[type="datetime"],
    input[type="datetime-local"] {
        position: relative;
    }

    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="date-local"]::-webkit-calendar-picker-indicator,
    input[type="datetime"]::-webkit-calendar-picker-indicator,
    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        padding: 0;
        color: transparent;
        background: transparent;
    }
</style>