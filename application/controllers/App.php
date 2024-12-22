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
    public function girisyap()
    {
        $this->headerlar();
        $kullaniciAdi = $this->input->post("kullaniciAdi");
        $sifre = $this->input->post("sifre");
        $token = $this->tokenPost();
        if (isset($kullaniciAdi)) {
            if (isset($sifre)) {
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
                            $this->Kullanicilar_Model->authEkle(
                                array(
                                    "kullanici_id" => $kullaniciBilgileri->id,
                                    "auth" => $auth,
                                    "bitis" => date($this->Kullanicilar_Model->format, $bitis),
                                )
                            );
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
        $id = $this->input->post("id");
        $token = $this->tokenPost();
        if (isset($token)) {
            if ($this->token($token)) {
                if (isset($id)) {
                    $cihaz = $this->Cihazlar_Model->tekCihazApp($id);
                    if($cihaz != null){
                        $cihaz->cihazDurumuID = "0";
                        $cihaz->siralama = "0";
                        echo json_encode($cihaz);
                    }else{
                        echo json_encode($this->hataMesaji(99));
                    }
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
}
