<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <label for="kullanici_adi<?php if (isset($id)) {
                                    echo $id;
                                } ?>">Kullanıcı Adı</label>
    <input id="kullanici_adi<?php if (isset($id)) {
                                echo $id;
                            } ?>" class="form-control" type="text" name="kullanici_adi" minlength="3" placeholder="Kullanıcı Adı" autocomplete="off" autocomplete="one-time-code" value="<?php if (isset($value)) {
                                                                                                                                                                                            echo $value;
                                                                                                                                                                                        } ?>" required>
</div>