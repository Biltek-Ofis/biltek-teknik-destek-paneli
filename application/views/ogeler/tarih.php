<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?>">
    <input id="tarih" autocomplete="off" class="form-control" type="datetime-local" name="tarih" value="<?php if (isset($tarih_value)) {
                                                                                            echo  $this->Islemler_Model->tarihDonusturInput($tarih_value);
                                                                                        } ?>">
</div>