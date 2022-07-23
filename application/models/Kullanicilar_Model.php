<?php
class Kullanicilar_Model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function girisUyari($konum){
        echo '<script>
        var r = confirm("Bu işlemi gerçekleştirmek için gerekli yetkiniz bulunmuyor!");
        if (r == true) {
            window.location.replace("'.base_url($konum).'");
        }else{
            window.location.replace("'.base_url($konum).'");
        }</script>';
    }
}
?>