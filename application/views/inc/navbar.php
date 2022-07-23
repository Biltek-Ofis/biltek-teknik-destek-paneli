<?php

/*
$aktifSayfa
  anasayfa
  cihazlar
*/

?>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/"><?=$_SESSION["KULLANICI"] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?php if($aktifSayfa == "anasayfa"){ echo " active";}?>" href="<?=base_url();?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Anasayfa
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if($aktifSayfa == "cihazlar"){ echo " active";}?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cihazlar
          </a>
          <ul class="dropdown-menu">
            <?php
            foreach($cihazTurleri as $cihazTuru){
              echo '<li><a class="dropdown-item" href="'.base_url("cihazlar/".$cihazTuru->id).'">'.$cihazTuru->isim.'</a></li>';
						}
            ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?=base_url("cikis");?>">Çıkış Yap</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Ürün ve ya müşteri ara" aria-label="Ara">
        <button class="btn btn-outline-success" type="submit">Ara</button>
      </form>
    </div>
  </div>
</nav>