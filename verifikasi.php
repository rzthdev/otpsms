<?php
require_once('lib/rfc6238.php');
$secretkey = filter_input(INPUT_POST, 'secret', FILTER_SANITIZE_STRING);
$currentcode = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta name="description" content="One Time Passoword">
    <meta name="keywords" content="One Time Passoword">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>OTP</title>
    <link rel="icon" href="https://www.eventhits.id/assets/images/logo.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
	<div class="row">
		<div class="col-md-12">
		  <div class="card my-4">
			<h5 class="card-header text-center bg-success text-white">Hasil Verifikasi</h5>
            <div class="card-body">
				<p id="hasil" align="center">
				<?php				
echo 'Secret (base32): '.$secretkey.'<br>';
echo 'OTP: '.$currentcode.'<br>';
if (TokenAuth6238::verify($secretkey,$currentcode)) {
	echo '<strong><font color="green">Code is valid</font></strong>';
} else {
	echo '<strong><font color="red">Invalid code</font></strong>';
}
				?>
				<br><br>
				<a class="btn btn-success btn-block col-md-3" href="./">Kembali</a>
				</p>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- jquery -->
<script src="jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>