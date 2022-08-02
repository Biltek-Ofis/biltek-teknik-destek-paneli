<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?>">
    <input id="bildirim_tarihi" autocomplete="off" class="form-control" type="datetime-local" name="bildirim_tarihi" value="<?php if (isset($bildirim_tarihi_value)) {
                                                                                                                echo  $this->Islemler_Model->tarihDonusturInput($bildirim_tarihi_value);
                                                                                                            } ?>">
</div>