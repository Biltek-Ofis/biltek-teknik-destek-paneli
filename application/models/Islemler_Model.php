<?php
class Islemler_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function tasarimArray($baslik, $icerik, $icerik_array = array(),  $ek_css = "")
    {
        return array(
            "baslik" => $baslik,
            "icerik" => $icerik,
            "icerik_array" => $icerik_array,
            "ek_css" => $ek_css,
        );
    }
    public function tarihDonustur($tarih)
    {
        return date("d/m/Y H:i", strtotime($tarih));
    }
    public function trimle($str)
    {
        $str = trim(preg_replace('/\s+/', ' ', $str));
        return str_replace("  ", "", $str);
    }
    public function cogulEki($yazi)
    {
        $sesliHarfler =
            'A' .
            'a' .
            'E' .
            'e' .
            'I' .
            'ı' .
            'İ' .
            'i' .
            'O' .
            'o' .
            'Ö' .
            'ö' .
            'U' .
            'u' .
            'Ü' .
            'ü';
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $sesliHarf = mb_ereg_replace('[^' . $sesliHarfler . ']', '', $yazi);
        $sonSesliHarf = mb_substr($sesliHarf, -1);
        switch ($sonSesliHarf) {
            case "A":
            case "a":
            case "I":
            case "ı":
            case "O":
            case "o":
            case "U":
            case "u":
                return $yazi . "lar";
            case "E":
            case "E":
            case "İ":
            case "İ":
            case "Ö":
            case "ö":
            case "Ü":
            case "ü":
                return $yazi . "ler";
            default:
                return $yazi;
        }
    }
    public function servisTuru($id)
    {
        switch ($id) {
            case 1:
                return "GARANTİ KAPSAMINDA BAKIM/ONARIM";
            case 2:
                return "ANLAŞMALI KAPSAMINDA BAKIM/ONARIM";
            case 3:
                return "ÜCRETLİ BAKIM/ONARIM";
            case 4:
                return "ÜCRETLİ ARIZA TESPİTİ";
            default:
                return "Belirtilmemiş";
        }
    }
    public function hasarDurumu($id)
    {
        switch ($id) {
            case 0:
                return "Yok";
            case 1:
                return "Hasarlı";
            case 2:
                return "Hasarsız";
            default:
                return "Yok";
        }
    }
    public function evetHayir($id)
    {
        switch ($id) {
            case 1:
                return "Evet";
            case 2:
                return "Hayır";
            default:
                return "Belirtilmemiş";
        }
    }
    public function cihazdakiHasar($id)
    {
        switch ($id) {
            case 1:
                return "Çizik";
            case 2:
                return "Kırık";
            case 3:
                return "Çatlak";
            case 4:
                return "Diğer";
            default:
                return "Belirtilmemiş";
        }
    }
    public function tarih(){
        $suankiTarih = new DateTime();
        //Örnek SQL tarih 2022-07-29 11:13:46.150
        return $suankiTarih->format('Y-m-d H:i:s.v');
    }
}
