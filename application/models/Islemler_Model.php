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
                return "ANLAŞMALI KAPSAMINDA BAKIM/ONARIM";
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
        "Hasarsız",
    );
    public function hasarDurumu($index)
    {
        return $this->arrayGetir($this->hasarDurumu, $index);
    }
    public $evetHayir = array(
        "Belirtilmemiş",
        "Evet",
        "Hayır",
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
        "Diğer",
    );
    public function cihazdakiHasar($index)
    {
        return $this->arrayGetir($this->cihazdakiHasar, $index);
    }

    public $cihazDurumu = array(
        "Sırada Bekliyor",
        "Arıza Tespiti Yapılıyor",
        "Yedek Parça Bekleniyor",
        "Fiyatlandırıldı Onay Bekleniyor",
        "<span class='text-success'>Fiyat Onaylandı</span>",
        "<span class='text-danger'>Fiyat Onaylanmadı</span>",
        "Teslim Edilmeye Hazır",
        "Teslim Edildi",
    );
    public function cihazDurumu($index)
    {
        return $this->arrayGetir($this->cihazDurumu, $index);
    }
    public function arrayGetir($arr, $index)
    {
        if ($index > count($arr) - 1) {
            return $arr[0];
        } else {
            return $arr[$index];
        }
    }
    public function datatablesAyarlari($siralama)
    {
        return '
        {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            order: [
              [' . $siralama[0] . ', "' . $siralama[1] . '"]
            ],
            "info": true,
            "autoWidth": false,
            "responsive": true,
            initComplete: function() {
      
            },
            "oLanguage": {
              "sSearch": "Ara:",
              "sInfo": "Toplam _TOTAL_ sonuçtan _START_ ile _END_ arası gösteriliyor.",
              "sInfoEmpty": "0 sonuç gösteriliyor.",
              "sInfoFiltered": "(toplam _MAX_ sonuç içinden)",
              "sZeroRecords": "Sonuç bulunamadı.",
              "oPaginate": {
                "sFirst": "İlk",
                "sPrevious": "Önceki",
                "sLast": "Son",
                "sNext": "Sonraki",
              },
            },
            columnDefs: [{
              "defaultContent": "-",
              "targets": "_all"
            }]
          }';
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
        'I',
    );
    public $buyukHarfler = array(
        'Ğ',
        'Ş',
        'Ü',
        'İ',
        'Ö',
        'Ç',
        'I',
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
        'Ş',
    );
    public $aramaSemboller = array(
        'Ý',
        'Ý',
        'Ð',
        'Ð',
        'Þ',
        'Þ',
    );
    public function turkceKarakterArama($str)
    {
        return str_replace($this->aramaKarakterler, $this->aramaSemboller, $str);
    }
}
