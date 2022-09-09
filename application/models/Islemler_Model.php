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
            "ek_css" => $ek_css
        );
    }
    public $sqlTarihFormati = "Y-m-d H:i:s.v";
    public function tarih()
    {
        $suankiTarih = new DateTime();
        //Örnek SQL tarih 2022-07-29 11:13:46.150
        return $suankiTarih->format($this->sqlTarihFormati);
    }
    public function tarihDonusturSQL($tarih)
    {
        return $tarih == "" ? "" : date($this->sqlTarihFormati, strtotime($tarih));
    }
    public function guncelTarih()
    {
        return date($this->sqlTarihFormati, time());
    }
    public function tarihDonustur($tarih)
    {
        return $tarih == "" ? "" : date("d.m.Y H:i", strtotime($tarih));
    }

    public function tarihDonusturSiralama($tarih)
    {
        return $tarih == "" ? "" : date("Y-m-d H:i", strtotime($tarih));
    }
    public function tarihDonusturInput($tarih)
    {
        return $tarih == "" ? "" : date('Y-m-d\TH:i', strtotime($tarih));
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
                return "ANLAŞMALI BAKIM/ONARIM";
            case 3:
                return "ÜCRETLİ BAKIM/ONARIM";
            case 4:
                return "ÜCRETLİ ARIZA TESPİTİ";
            default:
                return "Belirtilmemiş";
        }
    }
    public $hasarDurumu = array(
        "Yok",
        "Hasarlı",
        "Hasarsız"
    );
    public function hasarDurumu($index)
    {
        return $this->arrayGetir($this->hasarDurumu, $index);
    }
    public $evetHayir = array(
        "Belirtilmemiş",
        "Evet",
        "Hayır"
    );
    public function evetHayir($index)
    {
        return $this->arrayGetir($this->evetHayir, $index);
    }
    public $cihazdakiHasar = array(
        "Belirtilmemiş",
        "Çizik",
        "Kırık",
        "Çatlak",
        "Diğer"
    );
    public function cihazdakiHasar($index)
    {
        return $this->arrayGetir($this->cihazdakiHasar, $index);
    }

    public $cihazDurumu = array(
        "Sırada Bekliyor",
        "Arıza Tespiti Yapılıyor",
        "Yedek Parça Bekleniyor",
        "Merkez Servise Gönderildi",
        "Fiyat Onayı Bekleniyor",
        "Fiyat Onaylandı",
        "Fiyat Onaylanmadı",
        "Teslim Edilmeye Hazır",
        "Teslim Edildi / Ödeme Alınmadı",
        "Teslim Edildi"
    );

    public $cihazDurumuSiralama = array(
        "1",
        "2",
        "3",
        "5",
        "4",
        "6",
        "7",
        "8",
        "9",
        "10"
    );
    public $cihazDurumuClass = array(
        "bg-warning",
        "bg-warning",
        "bg-warning",
        "bg-pink",
        "bg-warning",
        "bg-primary",
        "bg-danger",
        "bg-primary",
        "bg-danger",
        "bg-success"
    );
    public function cihazDurumu($index)
    {
        return $this->arrayGetir($this->cihazDurumu, $index);
    }
    public function cihazDurumuClass($index)
    {
        return $this->arrayGetir($this->cihazDurumuClass, $index);
    }
    public $tahsilatSekli = array(
        "",
        "Nakit",
        "Kredi Kartı",
        "Mail Order",
        "Açık Hesap"
    );
    public function tahsilatSekli($index)
    {
        return $this->arrayGetir($this->tahsilatSekli, $index);
    }
    public function arrayGetir($arr, $index)
    {
        if ($index > count($arr) - 1) {
            return $arr[0];
        } else {
            return $arr[$index];
        }
    }
    public function datatablesAyarlari($siralama, $paging = "true", $digerAyarlar = "", $initcomplete = "")
    {
        $ayar = '
        {';

        if (strlen($digerAyarlar) > 0) {
            $ayar .= "
                " . $digerAyarlar;
        }
        $ayar .= '
            "paging": ' . $paging . ',
            "lengthChange": false,
            "pageLength": 50,
            "searching": true,
            "ordering": true,
            order: '.$siralama.',
            "info": true,
            "autoWidth": false,
            "responsive": true,
            initComplete: function() {
                ' . $initcomplete . '
            },
            "language": {
                url: "' . base_url("plugins/datatables-i18n/tr.json") . '"
            },
            columnDefs: [{
              "defaultContent": "-",
              "targets": "_all"
            }]';
        $ayar .= '
    }';
        return $ayar;
    }
    public function sifrele($sifre)
    {
        return password_hash($sifre, PASSWORD_DEFAULT);
    }
    public $bozukHarfler = array(
        '\u00d0',
        '\u00de',
        '\u00dc',
        '\u00dd',
        '\u00d6',
        '\u00c7',
        'I'
    );
    public $buyukHarfler = array(
        'Ğ',
        'Ş',
        'Ü',
        'İ',
        'Ö',
        'Ç',
        'I'
    );
    public function turkceKarakter($str)
    {
        return str_replace($this->bozukHarfler, $this->buyukHarfler, $str);
    }
    public $aramaKarakterler = array(
        'i',
        'İ',
        'ğ',
        'Ğ',
        'ş',
        'Ş'
    );
    public $aramaSemboller = array(
        'Ý',
        'Ý',
        'Ð',
        'Ð',
        'Þ',
        'Þ'
    );
    public function turkceKarakterArama($str)
    {
        return str_replace($this->aramaKarakterler, $this->aramaSemboller, $str);
    }
    public function tutarGetir($numara)
    {
        return number_format((float)$numara, 2, '.', '');
    }
    public function sozcukBul($str, $ara)
    {
        if (!function_exists('str_contains')) {
            function str_contains(string $haystack, string $needle): bool
            {
                return '' === $needle || false !== strpos($haystack, $needle);
            }
        }
        return str_contains($str, $ara);
    }
}
