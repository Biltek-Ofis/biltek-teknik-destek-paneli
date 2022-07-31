<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <label for="kullanici_soyad<?php if (isset($id)) {
                                    echo $id;
                                } ?>">Soyad</label>
    <input id="kullanici_soyad<?php if (isset($id)) {
                                    echo $id;
                                } ?>" class="form-control" type="text" name="soyad" minlength="3" placeholder="Soyad" value="<?php if (isset($value)) {
                                                                                                                                    echo $value;
                                                                                                                                } ?>" required>
</div>