<?php
class Islemler_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function tasarimArray($baslik, $icerik, $icerik_array = array())
    {
        return array(
            "baslik" => $baslik,
            "icerik" => $icerik,
            "icerik_array" => $icerik_array,
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
                return "ÜCRETLİ BAKIM/ONARIM";
        }
    }
    public function hasarDurumu($id)
    {
        switch ($id) {
            case 1:
                return "Yok";
            case 2:
                return "Hasarlı";
            case 3:
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
            case 0:
                return "Hayır";
            default:
                return "Hayır";
        }
    }
}
