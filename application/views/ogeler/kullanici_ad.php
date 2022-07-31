<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col">
    <label for="kullanici_ad<?php if (isset($id)) {
                                echo $id;
                            } ?>">Ad</label>
    <input id="kullanici_ad<?php if (isset($id)) {
                                echo $id;
                            } ?>" class="form-control" type="text" name="ad" minlength="3" placeholder="Ad" value="<?php if (isset($value)) {
                                                                                                                        echo $value;
                                                                                                                    } ?>" required>
</div>