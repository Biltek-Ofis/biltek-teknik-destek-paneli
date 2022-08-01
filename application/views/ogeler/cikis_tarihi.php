<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?>">
    <input id="cikis_tarihi" autocomplete="one-time-code" class="form-control" type="datetime-local" name="cikis_tarihi" value="<?php if (isset($cikis_tarihi_value)) {
                                                                                                        echo  $this->Islemler_Model->tarihDonusturInput($cikis_tarihi_value);
                                                                                                    } ?>">
</div>