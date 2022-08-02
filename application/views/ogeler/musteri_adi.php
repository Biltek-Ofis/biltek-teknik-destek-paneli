<div class="form-group<?php if (isset($sifirla)) {
                            echo " p-0 m-0";
                        } ?> col-12">
    <input id="musteri_adi" autocomplete="one-time-code" class="form-control" type="text" name="musteri_adi" placeholder="Müşteri Adı Soyadı *" value="<?php if (isset($musteri_adi_value)) {
                                                                                                                                                                                                echo $musteri_adi_value;
                                                                                                                                                                                            } ?>" required>
    <ul id="musteri_adi_liste" class="typeahead dropdown-menu col" style="max-height:300px;overflow-y: auto;" role="listbox">
       
    </ul>
</div>