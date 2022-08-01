<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <label for="kullanici_sifre<?php if (isset($id)) {
                                    echo $id;
                                } ?>">Şifre</label>
    <input onClick="this.select();" id="kullanici_sifre<?php if (isset($id)) {
                                    echo $id;
                                } ?>" class="form-control" type="password" name="sifre" minlength="6" placeholder="Şifre" autocomplete="one-time-code" value="<?php if (isset($value)) {
                                                                                                                                                            echo $value;
                                                                                                                                                        } ?>" required>
</div>