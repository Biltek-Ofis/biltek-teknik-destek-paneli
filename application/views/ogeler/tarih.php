<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?>">
    <input class="form-control" type="datetime-local" name="<?= $isim; ?>" value="<?php if (isset($value)) {
                                                                                    echo  $this->Islemler_Model->tarihDonusturInput($value);
                                                                                } ?>">
</div>