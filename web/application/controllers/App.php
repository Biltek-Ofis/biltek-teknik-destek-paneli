<?php
class App extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Cihazlar_Model");
        $this->load->model("Islemler_Model");
        $this->load->model("Firma_Model");
    }
    public function index()
    {
        redirect(base_url());
    }
    public function token($token)
    {
        if (isset($token)) {
            if ($token == AUTH_TOKEN) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function HTTPStatus($num)
    {
        $http = array(
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version Not Supported',
        );

        header($http[$num]);

        return
            array(
                'code' => $num,
                'error' => $http[$num],
            );
    }
    public function hataMesaji($kod)
    {
        $sonuc = array(
            "kod" => $kod
        );
        switch ($kod) {
            case 1:
                $sonuc["mesaj"] = "Yetkisiz İşlem";
                break;
            case 2:
                $sonuc["mesaj"] = "Kullanıcı adı boş olamaz!";
                break;
            case 3:
                $sonuc["mesaj"] = "Şifre boş olamaz!";
                break;
            case 4:
                $sonuc["mesaj"] = "Cihaz id gecersiz!";
                break;
            default:
                $sonuc["kod"] = 99;
                $sonuc["mesaj"] = "Bir hata oluştu";
                break;
        }
        return $sonuc;
    }
    public function tokenPost()
    {
        return $this->input->post("token");
    }
    public function ayarlar()
    {
        $this->headerlar();
        $auth = $this->input->post("auth");
        $fcmToken = $this->input->post("fcmToken");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                $ayarlar = $this->Ayarlar_Model->getir();
                echo json_encode($ayarlar);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }
    public function fcmToken()
    {
        $this->headerlar();
        $auth = $this->input->post("auth");
        $fcmToken = $this->input->post("fcmToken");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($auth)) {
                    if (isset($fcmToken)) {
                        $this->Kullanicilar_Model->fcmTokenSifirla($fcmToken);
                        $sonuc = $this->Kullanicilar_Model->authDuzenle($auth, array(
                            "fcmToken" => $fcmToken,
                        ));
                        echo json_encode(array("sonuc" => $sonuc, ));
                    }
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function fcmTokenSifirla()
    {
        $this->headerlar();
        $fcmToken = $this->input->post("fcmToken");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($fcmToken)) {
                    $sonuc = $this->Kullanicilar_Model->fcmTokenSifirla($fcmToken);
                    echo json_encode(array("sonuc" => $sonuc, ));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function girisyap()
    {
        $this->headerlar();
        $kullaniciAdi = $this->input->post("kullaniciAdi");
        $sifre = $this->input->post("sifre");
        $fcmToken = $this->input->post("fcmToken");
        $cihazID = $this->input->post("cihazID");
        $token = $this->tokenPost();
        if (isset($kullaniciAdi)) {
            if (isset($sifre)) {
                if (isset($cihazID)) {
                    if (isset($token)) {
                        if ($this->token($token)) {
                            $durum = $this->Giris_Model->girisDurumu($kullaniciAdi, $sifre);
                            $sonuc = array(
                                "auth" => "",
                                "durum" => FALSE,
                            );
                            if ($durum) {
                                $kullaniciBilgileri = $this->Kullanicilar_Model->tekKullaniciAdi($kullaniciAdi);
                                $auth = random_string('alnum', 50);
                                ///2024-12-22 10:46:21.00000
                                $bitis = time() + $this->Kullanicilar_Model->bitisZamani;
                                $veri = array(
                                    "kullanici_id" => $kullaniciBilgileri->id,
                                    "auth" => $auth,
                                    "bitis" => date($this->Kullanicilar_Model->format, $bitis),
                                    "cihazID" => $cihazID,
                                );
                                if (isset($fcmToken)) {
                                    $this->Kullanicilar_Model->fcmTokenSifirla($fcmToken);
                                    $veri["fcmToken"] = $fcmToken;
                                }
                                $this->Kullanicilar_Model->authEkle($veri);
                                if (isset($kullaniciBilgileri)) {
                                    $sonuc["durum"] = TRUE;
                                    $sonuc["auth"] = $auth;
                                }
                            }
                            echo json_encode($sonuc);
                        } else {
                            echo json_encode($this->hataMesaji(1));
                        }
                    } else {
                        echo json_encode($this->hataMesaji(1));
                    }
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(3));
            }
        } else {
            echo json_encode($this->hataMesaji(2));
        }
    }
    public function kullaniciGetir()
    {
        $this->headerlar();
        $auth = $this->input->post("auth");
        $token = $this->tokenPost();
        $sonuc = array(
            "durum" => FALSE,
            "kullanici" => array(),
        );
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($auth)) {
                    $girisDurumu = $this->Kullanicilar_Model->girisDurumuAuth($auth);
                    $girisDurumu["auth"] = $auth;
                    if (count($girisDurumu) > 0) {
                        $sonuc["durum"] = TRUE;
                        $sonuc["kullanici"] = $girisDurumu;
                    }
                }
            }
        }
        echo json_encode($sonuc);
    }
    public function kullaniciBilgileri()
    {
        $this->headerlar();
        $id = $this->input->post("id");
        $token = $this->tokenPost();
        if (isset($id)) {
            if (isset($token)) {
                if ($this->token($token)) {
                    $kullanici = $this->Kullanicilar_Model->tekKullanici($id);
                    echo json_encode($kullanici);
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazlarTumu()
    {
        $this->headerlar();
        $sorumlu = $this->input->post("sorumlu");
        $arama = $this->input->post("arama");
        $specific = $this->input->post("specific");
        $sira = $this->input->post("sira");
        $limit = $this->input->post("limit");
        if (isset($sorumlu)) {
            $sorumlu = intval($sorumlu);
        } else {
            $sorumlu = 0;
        }
        if (!isset($arama)) {
            $arama = "";
        }
        if (isset($specific)) {
            $specific = json_decode($specific);
        } else {
            $specific = array();
        }
        if (!isset($sira)) {
            $sira = 0;
        }
        if (!isset($limit)) {
            $limit = 50;
        }
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                echo json_encode($this->Cihazlar_Model->cihazlarTumuApp($sorumlu == 0 ? "" : $sorumlu, $specific, $sira, $limit, $arama));
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function tekCihaz()
    {
        $this->headerlar();
        $servis_no = $this->input->post("servis_no");
        if (!isset($servis_no)) {
            $servis_no = "";
        }
        $takip_no = $this->input->post("takip_no");
        if (!isset($takip_no)) {
            $takip_no = "";
        }
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                $cihaz = $this->Cihazlar_Model->tekCihazApp($servis_no, $takip_no);
                if ($cihaz != null) {
                    $cihaz->cihazDurumuID = "0";
                    $cihaz->siralama = "0";
                    echo json_encode($cihaz);
                } else {
                    echo json_encode($this->hataMesaji(99));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function medyalar()
    {
        $this->headerlar();
        $id = $this->input->post("id");
        if (!isset($id)) {
            $id = "";
        }
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (strlen($id)) {
                    $medyalar = $this->Cihazlar_Model->medyalar($id);
                    echo json_encode($medyalar);
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function medyaYukle()
    {
        $this->headerlar();
        $cihaz_id = $this->input->post("id");

        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($cihaz_id)) {
                    $yukle = $this->Cihazlar_Model->medyaYukle($cihaz_id);
                    echo json_encode($yukle);
                }
            } else {
                echo json_encode($this->hataMesaji(4));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function medyaSil()
    {
        $this->headerlar();
        $cihaz_id = $this->input->post("id");

        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($cihaz_id)) {
                    $medya = $this->Cihazlar_Model->medyaBul($cihaz_id);
                    $sil = $this->Cihazlar_Model->medyaSil($cihaz_id);
                    if ($sil) {
                        if ($medya != null) {
                            if (file_exists($medya->konum)) {
                                unlink($medya->konum);
                            }
                        }
                        echo json_encode(array("sonuc" => 1));
                    } else {
                        echo json_encode($this->hataMesaji(99));
                    }
                }
            } else {
                echo json_encode($this->hataMesaji(4));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazEkle()
    {
        $this->headerlar();
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                $ekle = $this->Cihazlar_Model->cihazEkle("POST");
                echo json_encode($ekle);
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazDuzenle()
    {
        $this->headerlar();
        $id = $this->input->post("id");
        $this->headerlar();
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($id)) {
                    $veri = $this->Cihazlar_Model->cihazPost(FALSE);
                    $guncel_durum = $this->input->post("guncel_durum");
                    $guncel_durum_suanki = $this->input->post("guncel_durum_suanki");
                    $tahsilat_sekli = $this->input->post("tahsilat_sekli");
                    $fatura_durumu = $this->input->post("fatura_durumu");
                    $fis_no = $this->input->post("fis_no");
                    $veri["yapilan_islem_aciklamasi"] = $this->input->post("yapilan_islem_aciklamasi");
                    $notlar = $this->input->post("notlar");
                    if (!isset($notlar)) {
                        $notlar = "";
                    }
                    $veri["notlar"] = $notlar;
                    $veri["guncel_durum"] = $guncel_durum;
                    $veri["tahsilat_sekli"] = $tahsilat_sekli;
                    $veri["fatura_durumu"] = $fatura_durumu;
                    $veri["fis_no"] = $fis_no;
                    $tarih = $this->Islemler_Model->tarihDonusturSQL($this->input->post("tarih"));
                    $bildirim_tarihi = $this->input->post("bildirim_tarihi");
                    if (isset($bildirim_tarihi)) {
                        $bildirim_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("bildirim_tarihi"));
                        $veri["bildirim_tarihi"] = strlen($bildirim_tarihi) > 0 ? $bildirim_tarihi : NULL;
                    } else {
                        $veri["bildirim_tarihi"] = $this->Islemler_Model->tarihDonusturSQL($this->Islemler_Model->tarih());
                    }
                    $cikis_tarihi = $this->Islemler_Model->tarihDonusturSQL($this->input->post("cikis_tarihi"));
                    if (strlen($tarih) > 0) {
                        $veri["tarih"] = $tarih;
                    }
                    $veri["cikis_tarihi"] = strlen($cikis_tarihi) > 0 ? $cikis_tarihi : NULL;

                    for ($i = 1; $i <= $this->Islemler_Model->maxIslemSayisi; $i++) {
                        $islem = $this->input->post("islem" . $i);
                        $miktar = $this->input->post("miktar" . $i);
                        $maliyet = $this->input->post("maliyet" . $i);
                        if (isset($maliyet)) {
                            if (strlen($maliyet) == 0) {
                                $maliyet = 0;
                            }
                        } else {
                            $maliyet = 0;
                        }
                        $birim_fiyati = $this->input->post("birim_fiyati" . $i);
                        $kdv = $this->input->post("kdv_" . $i);
                        if (isset($islem) && !empty($islem)) {
                            $yapilanIslemVeri = $this->Cihazlar_Model->yapilanIslemArray(
                                $id,
                                $i,
                                $islem,
                                $maliyet,
                                $birim_fiyati,
                                $miktar,
                                $kdv
                            );
                            $duzenle = $this->Cihazlar_Model->islemDuzenle($id, $yapilanIslemVeri);
                            if (!$duzenle) {
                                echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                                return;
                            }
                        } else {
                            $sil = $this->Cihazlar_Model->islemSil($id, $i);
                            if (!$sil) {
                                echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                                return;
                            }
                        }
                    }
                    $duzenle = $this->Cihazlar_Model->cihazDuzenle($id, $veri);
                    if ($duzenle) {
                        echo json_encode(array("mesaj" => "", "sonuc" => 1));
                    } else {
                        echo json_encode(array("mesaj" => "Düzenleme işlemi gerçekleştirilemedi.<br>" . $this->db->error()["message"], "sonuc" => 0));
                    }
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazDuzenleme()
    {
        $this->headerlar();
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                $cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
                $sorumlular = $this->Kullanicilar_Model->kullanicilar(array("teknikservis" => 1));
                $cihazDurumlari = $this->Cihazlar_Model->cihazDurumlari();
                $tahsilatSekilleri = $this->Cihazlar_Model->tahsilatSekilleri();
                echo json_encode(array(
                    "cihazTurleri" => $cihazTurleri,
                    "sorumlular" => $sorumlular,
                    "cihazDurumlari" => $cihazDurumlari,
                    "tahsilatSekilleri" => $tahsilatSekilleri,
                ));
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cihazTurleri()
    {
        $this->headerlar();
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                $cihazTurleri = $this->Cihazlar_Model->cihazTurleri();
                echo json_encode($cihazTurleri);
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function musteriler()
    {
        $this->headerlar();
        $ara = $this->input->post("ara");
        $this->headerlar();
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($ara)) {
                    echo json_encode($this->Firma_Model->musteriBilgileri("musteri_adi", $ara, 10));
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function version()
    {
        $this->headerlar();
        echo $this->Islemler_Model->app_version();
    }
    public function headerlar()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        header($this->HTTPStatus(201)["error"]);
    }

    public function bilgisayardaAc()
    {
        $this->headerlar();
        $servis_no = $this->input->post("servis_no");
        $kullanici_id = $this->input->post("kullanici_id");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($servis_no)) {
                    if (isset($kullanici_id)) {
                        $this->Cihazlar_Model->bilgisayardaAc($servis_no, $kullanici_id);
                    }
                }
            }
        }
    }
    public function download()
    {

        $detect = new Mobile_Detect();
        if ($detect->isTablet() || $detect->isAndroidOS()) {
            header("Location: " . base_url("app/android"));
        } else {
            echo "Sisteminize uygun uygulama bulunamadı.";
        }
    }
    public function android()
    {
        header("Location: https://play.google.com/store/apps/details?id=tr.com.biltekbilgisayar.teknikservis");
    }
    public function barkod_ozel()
    {
        $this->load->view("icerikler/yazdir/barkod_ozel");
    }
    public function biltekdesk()
    {
        $ayarlar = $this->Ayarlar_Model->getir();
        redirect($ayarlar->biltekdesk_url);
    }

    public function bildirimleriGetir()
    {
        $this->headerlar();
        $kullanici_id = $this->input->post("kullanici_id");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($kullanici_id)) {
                    $sonuc = $this->Kullanicilar_Model->bildirimleriGetir($kullanici_id);
                    echo json_encode($sonuc);
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function bildirimAyarla()
    {
        $this->headerlar();
        $kullanici_id = $this->input->post("kullanici_id");
        $tur = $this->input->post("tur");
        $durum = $this->input->post("durum");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($kullanici_id)) {
                    if (isset($tur)) {
                        if (isset($durum)) {
                            $sonuc = $this->Kullanicilar_Model->bildirimAyarla($kullanici_id, $tur, $durum);
                            echo json_encode(array("sonuc" => $sonuc ? "1" : "0"));
                        } else {
                            echo json_encode($this->hataMesaji(1));
                        }
                    } else {
                        echo json_encode($this->hataMesaji(1));
                    }
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function bildirimAyarlaToplu()
    {
        $this->headerlar();
        $kullanici_id = $this->input->post("kullanici_id");
        $bildirimler = $this->input->post("bildirimler");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($kullanici_id)) {
                    if (isset($bildirimler)) {
                        $bildirimler = json_decode($bildirimler);
                        $sonuc = FALSE;
                        foreach($bildirimler as $bildirim){
                            $sonuc = $this->Kullanicilar_Model->bildirimAyarla($kullanici_id, $bildirim->tur, $bildirim->durum);
                            if(!$sonuc){
                                break;
                            }
                        }
                        echo json_encode(array("sonuc" => $sonuc ? "1" : "0"));
                    } else {
                        echo json_encode($this->hataMesaji(1));
                    }
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
    public function cagriKayitlari(){
        $this->headerlar();
        $token = $this->tokenPost();
        $kullanici_id = $this->input->post("kullanici_id");
        if (isset($token)) {
            if ($this->token($token)) {
                $kayitlar = $this->hataMesaji(1);
                if(isset($kullanici_id)){
                    $kayitlar = $this->Cihazlar_Model->cagriKayitlari($kullanici_id);
                }else{
                    $kayitlar = $this->Cihazlar_Model->cagriKayitlari();
                }
                for( $i = 0; $i < count($kayitlar); $i++){
                    $cihaz = $this->Cihazlar_Model->cagriCihazi($kayitlar[$i]->id);
                    if($cihaz != null){
                        $kayitlar[$i]->cihaz_bilgileri =  $this->Cihazlar_Model->cihazVerileriniDonusturTek($cihaz, TRUE);
                    }
                    $kayitlar[$i]->cihaz_turu_val = $cihaz != null ? $cihaz->cihaz_turu_val : $kayitlar[$i]->cihaz_turu;
                    $kayitlar[$i]->cihaz_turu = $this->Cihazlar_Model->cihazTuru($kayitlar[$i]->cihaz_turu_val);
                }
                echo json_encode($kayitlar);
            } else {
                echo json_encode($this->hataMesaji(1));
            }
        } else {
            echo json_encode($this->hataMesaji(1));
        }
    }
}
