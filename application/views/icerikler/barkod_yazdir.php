<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("inc/meta"); ?>

    <title>Barkod <?= $cihaz->id; ?></title>

    <?php $this->load->view("inc/styles"); ?>
    <?php $this->load->view("inc/scripts"); ?>
    <?php
    $bodyStyle = "width: 100%;
            height: 100%;";
    $pageStyle = "width: 8cm;
            height: 4cm;
            size: 8cm 4cm;";
    ?>
    <style>
        @page {
            margin: 0;
            <?= $pageStyle; ?>
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            <?= $bodyStyle; ?>
        }

        @media print {
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                <?= $bodyStyle; ?>
            }

            @page {
                margin: 0;
                <?= $pageStyle; ?>
            }
        }
    </style>
</head>

<body onafterprint="self.close()">
    <table class="table">
        <tbody>
            <tr>
                <td class="p-1 m-0 font-weight-bold"><?php
                                                        $basamak = 3;
                                                        $sifirSayisi = 3 - strlen($cihaz->id);
                                                        $id = "";
                                                        if ($sifirSayisi > 0) {
                                                            for ($i = 0; $i < $sifirSayisi; $i++) {
                                                                $id .= "0";
                                                            }
                                                        }
                                                        $id .= $cihaz->id;
                                                        echo $id;
                                                        ?></td>
            </tr>
            <tr>
                <td class="p-1 m-0"><?= $cihaz->tarih; ?></td>
            </tr>
            <tr>
                <td class="p-1 m-0"><?= $cihaz->musteri_adi; ?></td>
            </tr>
            <tr>
                <td class="p-1 m-0"><?= $cihaz->cihaz . " " . $cihaz->cihaz_modeli; ?></td>
            </tr>
            <tr>
                <td class="p-1 m-0"><?= $cihaz->ariza_aciklamasi; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>