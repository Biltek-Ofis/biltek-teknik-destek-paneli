<?php

class Urunler extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Cihazlar_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Giris_Model");
        $this->load->model("Islemler_Model");
        $this->load->model("Urunler_Model");
	}
    public $kullanici = null;

	public function index($id = "")
	{
        if ($this->Giris_Model->kullaniciGiris()) {
            $kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
            $girebilir = False;
            if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["urunduzenleme"] == 1){
                $girebilir = True;
            }
            if($girebilir){
                $urun_sayfasi = FALSE;
                if(strlen($id) > 0){
                    if(is_numeric($id)){
                        $urun_sayfasi = TRUE;
                    }
                }
                if($urun_sayfasi){
                    $urun = $this->Urunler_Model->urunGetir($id, TRUE);
                    if(count($urun) > 0){
                        $this->load->view("tasarim", $this->Islemler_Model->tasarimArray($urun[0]["isim"], "urunler/duzenle", array("urun_id"=>$id)));
                    }else{
                        redirect(base_url("urunler"));
                    }
                }else{
                    $this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Ürünler", "urunler/anasayfa", [], "inc/datatables"));
                }
            }else{
                redirect(base_url());
            }
		} else {
			$this->Kullanicilar_Model->girisUyari("");
		}
	}
	public function ekle()
	{
        if ($this->Giris_Model->kullaniciGiris()) {
            $kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
            $girebilir = False;
            if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["urunduzenleme"] == 1){
                $girebilir = True;
            }
            if($girebilir){
                $ekle = $this->Urunler_Model->ekle();
                if($ekle){
                    redirect(base_url("urunler"));
                }else{
                    $this->Kullanicilar_Model->girisUyari("urunler", "Ürün eklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");  
                }
            }else{
                redirect(base_url());
            }
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis", "Bu işlemi yapabilmek için giriş yapmalısınız.");  
		}
	}

    public function duzenle($id){
        if ($this->Giris_Model->kullaniciGiris()) {
            $kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
            $girebilir = False;
            if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["urunduzenleme"] == 1){
                $girebilir = True;
            }
            if($girebilir){
                $duzenle = $this->Urunler_Model->duzenle($id);
                if($duzenle){
                    redirect(base_url("urun/" . $id));
                }else{
                    $this->Kullanicilar_Model->girisUyari("urun/".$id, "Ürün düzenlenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");  
                }
            }else{
                redirect(base_url());
            }
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis", "Bu işlemi yapabilmek için giriş yapmalısınız.");  
		}
    }
    
	public function sil($id)
	{
        if ($this->Giris_Model->kullaniciGiris()) {
            $kullanicibilgileri = $this->Kullanicilar_Model->kullaniciBilgileri();
            $girebilir = False;
            if ($kullanicibilgileri["yonetici"] == 1 || $kullanicibilgileri["urunduzenleme"] == 1){
                $girebilir = True;
            }
            if($girebilir){  
                $sil = $this->Urunler_Model->sil($id);
                if($sil){
                    redirect(base_url("urunler"));
                }else{
                    $this->Kullanicilar_Model->girisUyari("urunler", "Ürün silinirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");  
                }
            }else{
                redirect(base_url());
            }
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis", "Bu işlemi yapabilmek için giriş yapmalısınız.");  
		}
	}
    public function komisyon()
	{
        $file_url = base_url("assets/Satış Komisyon Oranları.xlsx");
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
        readfile($file_url); 
    }
}
?>