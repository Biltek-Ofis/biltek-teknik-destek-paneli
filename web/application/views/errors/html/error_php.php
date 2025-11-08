<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>Bir PHP hatası oluştu.</h4>

<p>Ciddiyet: <?php echo $severity; ?></p>
<p>Mesaj:  <?php echo $message; ?></p>
<p>Dosya Adı: <?php echo $filepath; ?></p>
<p>Satır: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Hata:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			Dosya: <?php echo $error['file'] ?><br />
			Satır: <?php echo $error['line'] ?><br />
			Fonksiyon: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>