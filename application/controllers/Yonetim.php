<?php
require_once("Varsayilancontroller.php");

class Yonetim extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model("Ayarlar_Model");
	}
	public function index()
	{
		redirect(base_url());
	}
	public function yoneticiler()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Yönetici Hesapları", "yonetim/kullanicilar", array("baslik" => "Yönetici Hesapları"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function personel()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Personel Hesapları", "yonetim/personel", array("baslik" => "Personel Hesapları"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciEkle($tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"])) {
						$sifre = $veri["sifre"];
						$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
						$ekle = $this->Kullanicilar_Model->ekle($veri);
						if ($ekle) {
							redirect(base_url($this->konum($tur)));
						} else {
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Hesap eklenemedi lütfen daha sonra tekrar deneyin");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciDuzenle($id, $tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"]) || $veri["kullanici_adi"] == $this->input->post("kullanici_adi_orj" . $id)) {
						$kullanicilar = $this->Kullanicilar_Model->kullaniciGetir($id);
						if(count($kullanicilar) > 0){
							$kullanici = $kullanicilar[0];
							if ($kullanici->sifre != $veri["sifre"]) {
								$sifre = $veri["sifre"];
								$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
							}
							$duzenle = $this->Kullanicilar_Model->duzenle($id, $veri);
							if ($duzenle) {
								redirect(base_url($this->konum($tur)));
							} else {
								$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Hesap düzenlenemedi lütfen daha sonra tekrar deneyin");
							}
						}else{
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Kullanıcı bulunamadı lütfen daha sonra tekrar deneyin.");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciSil($id, $tur = 0)
	{

		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Kullanicilar_Model->sil($id);
			if ($sil) {
				redirect(base_url($this->konum($tur)));
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur), "Hesap silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function konum($tur = 0)
	{
		$konum = "yonetim/personel";
		if ($tur == 1) {
			$konum = "yonetim/yoneticiler";
		}
		return $konum;
	}
	
	public function musteriler()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Müşteriler", "yonetim/musteriler", array("baslik" => "Müşteriler"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function musteriEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->musteriPost(true);
			if (strlen($veri["musteri_adi"]) >= 3) {
				$ekle = $this->Kullanicilar_Model->musteriEkle($veri);
				if ($ekle) {
					redirect(base_url("yonetim/musteriler"));
				} else {
					$this->Kullanicilar_Model->girisUyari("yonetim/musteriler#yeniMusteriEkleModal", "Müşteri eklenemedi lütfen daha sonra tekrar deneyin");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/musteriler#yeniMusteriEkleModal", "Müşteri adı en az 3 karakter olmalıdır.");
			}
		}
	}
	public function musteriSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			if(isset($id)){
				$sil = $this->Kullanicilar_Model->musteriSil($id);
				if ($sil) {
					redirect(base_url("yonetim/musteriler"));
				} else {
					$this->Kullanicilar_Model->girisUyari("yonetim/musteriler", "Müşteri silinemedi lütfen daha sonra tekrar deneyin");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/musteriler", "Müşteri silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function musteriDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			if(isset($id)){
				$veri = $this->Kullanicilar_Model->musteriPost(true);
				if (strlen($veri["musteri_adi"]) >= 3) {
					$duzenle = $this->Kullanicilar_Model->musteriDuzenle($id, $veri);
					if ($duzenle) {
						$musteri_cihazlarini_guncelle = $this->input->post('musteri_cihazlarini_guncelle');
						if(isset($musteri_cihazlarini_guncelle) && ((int)$musteri_cihazlarini_guncelle) == 1){
							$this->db->reset_query()->where("musteri_kod", $id)->update(
								$this->Cihazlar_Model->cihazlarTabloAdi(),
								array(
									"musteri_adi" => $veri["musteri_adi"],
									"adres" => $veri["adres"],
									"telefon_numarasi" => $veri["telefon_numarasi"]
								)
							);
							$this->db->reset_query();
							redirect(base_url("yonetim/musteriler"));
						}else{
							redirect(base_url("yonetim/musteriler"));
						}
					} else {
						$this->Kullanicilar_Model->girisUyari("yonetim/musteriler#kullaniciDuzenleModal" . $id, "Müşteri düzenlenemedi lütfen daha sonra tekrar deneyin");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari("yonetim/musteriler#kullaniciDuzenleModal" . $id, "Müşteri adı en az 3 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/musteriler#kullaniciDuzenleModal" . $id, "Müşteri düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		}
	}
	public function ayarlar()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Site Ayarları", "yonetim/ayarlar", array("baslik" => "Site Ayarları")));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function ayarDuzenle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = array();
			$SITE_BASLIGI = $this->input->post("db_baslik");
			if(isset($SITE_BASLIGI)){
				$veri["site_basligi"] = $SITE_BASLIGI;
			}
			$FIRMA_URL = $this->input->post("db_anasayfa");
			if(isset($FIRMA_URL)){
				$veri["firma_url"] = $FIRMA_URL;
			}
			
			$SIRKET_UNVANI = $this->input->post("db_unvan");
			if(isset($SIRKET_UNVANI)){
				$veri["sirket_unvani"] = $SIRKET_UNVANI;
			}

			$ADRES = $this->input->post("db_adres");
			if(isset($ADRES)){
				$veri["adres"] = $ADRES;
			}

			$SIRKET_TELEFONU = $this->input->post("db_telefon");
			if(isset($SIRKET_TELEFONU)){
				$veri["sirket_telefonu"] = $SIRKET_TELEFONU;
			}
			$TABLO_OGE = $this->input->post("db_tablo_oge");
			if(isset($TABLO_OGE)){
				$veri["tablo_oge"] = $TABLO_OGE;
			}
			$BARKOD_EN = $this->input->post("db_barkod_en");
			if(isset($BARKOD_EN)){
				$veri["barkod_en"] = $BARKOD_EN;
			}
			$BARKOD_BOY = $this->input->post("db_barkod_boy");
			if(isset($BARKOD_BOY)){
				$veri["barkod_boy"] = $BARKOD_BOY;
			}
			$BARKOD_BOYUTU = $this->input->post("db_barkod_boyutu");
			if(isset($BARKOD_BOYUTU)){
				$veri["barkod_boyutu"] = $BARKOD_BOYUTU;
			}
			$BARKOD_NUMARASI_BOYUTU = $this->input->post("db_barkod_numarasi_boyutu");
			if(isset($BARKOD_NUMARASI_BOYUTU)){
				$veri["barkod_numarasi_boyutu"] = $BARKOD_NUMARASI_BOYUTU;
			}
			$BARKOD_MUSTERI_ADI_BOYUTU = $this->input->post("db_barkod_musteri_adi_boyutu");
			if(isset($BARKOD_MUSTERI_ADI_BOYUTU)){
				$veri["barkod_musteri_adi_boyutu"] = $BARKOD_MUSTERI_ADI_BOYUTU;
			}
			$BARKOD_SIRKET_ADI_BOYUTU = $this->input->post("db_barkod_sirket_adi_boyutu");
			if(isset($BARKOD_SIRKET_ADI_BOYUTU)){
				$veri["barkod_sirket_adi_boyutu"] = $BARKOD_SIRKET_ADI_BOYUTU;
			}

			if(count($veri) > 0){
				$duzenle = $this->Ayarlar_Model->duzenle($veri);
				if ($duzenle) {
					redirect(base_url("yonetim/ayarlar"));
				} else {
					$this->Kullanicilar_Model->girisUyari("yonetim/ayarlar", "Ayarlar düzenlenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
				}
			}else{
				$this->Kullanicilar_Model->girisUyari("yonetim/ayarlar", "Ayarlar düzenlenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function rapor()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Rapor", "yonetim/rapor", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihaz_turleri()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Türleri", "yonetim/cihaz_turleri", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruEkle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri#yeniCihazTuruEkleModal", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruDuzenle($id, $veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri", "Cihaz türü düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Cihazlar_Model->cihazTuruSil($id);
			if ($sil) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri", "Cihaz türü silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	
	public function cihaz_durumlari()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Durumları", "yonetim/cihaz_durumlari", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazDurumuEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazDurumuPost();
			$ekle = $this->Cihazlar_Model->cihazDurumuEkle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari#yeniCihazDurumuEkleModal", "Cihaz durumu eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	
	public function cihazDurumuYukariTasi($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$yukariTasi = $this->Cihazlar_Model->cihazDurumuYukariTasi($id);
			if ($yukariTasi) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari", "Cihaz durumu sırası değiştirilemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazDurumuAltaTasi($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			
			$altaTasi = $this->Cihazlar_Model->cihazDurumuAltaTasi($id);
			if ($altaTasi) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari", "Cihaz durumu sırası değiştirilemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazDurumuVarsayilanYap($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$ekle = $this->Cihazlar_Model->cihazDurumuVarsayilanYap($id);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari", "Cihaz durumu düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazDurumuDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazDurumuPost();
			$duzenle = $this->Cihazlar_Model->cihazDurumuDuzenle($id, $veri);
			if ($duzenle) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari", "Cihaz durumu düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazDurumuSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Cihazlar_Model->cihazDurumuSil($id);
			if ($sil) {
				redirect(base_url("yonetim/cihaz_durumlari"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_durumlari", "Cihaz durumu silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function tahsilat_sekilleri()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Tahsilat Şekilleri", "yonetim/tahsilat_sekilleri", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function tahsilatSekliEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->tahsilatSekliPost();
			$ekle = $this->Cihazlar_Model->tahsilatSekliEkle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/tahsilat_sekilleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/tahsilat_sekilleri#yeniTahsilatSekliEkleModal", "Tahsilat şekli eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function tahsilatSekliDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->tahsilatSekliPost();
			$ekle = $this->Cihazlar_Model->tahsilatSekliDuzenle($id, $veri);
			if ($ekle) {
				redirect(base_url("yonetim/tahsilat_sekilleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/tahsilat_sekilleri", "Tahsilat şekli düzenlenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function tahsilatSekliSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Cihazlar_Model->tahsilatSekliSil($id);
			if ($sil) {
				redirect(base_url("yonetim/tahsilat_sekilleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/tahsilat_sekilleri", "Tahsilat şekli silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
}
