<?php
require_once('secret.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta name="description" content="One Time Passoword">
    <meta name="keywords" content="One Time Passoword">
    <meta name="author" content="Rizal Toha">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>OTP</title>
    <link rel="icon" href="https://www.eventhits.id/assets/images/logo.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">                 
			<div class="card mb-3">
				<div class="card-header text-center bg-primary text-white">OTP</div>
                <div class="card-body">

                <form>
					<div class="form-group">
						<label for="secret">Secret (base32)</label>
						<input id="secret" type="text" class="form-control" name="secret" value="<?php echo $secret_base32;?>" required autofocus>
					</div>
					<div class="form-group">
						<label>Secret (hex)</label>
						<br>
						<span class="badge badge-secondary" id="secretHex"></span>
					</div>
					<div class="form-group">
						<label>Unix epoch div 30 (padded hex)</label>
						<br>
						<span class="badge badge-dark" id="time"></span>
					</div>
					<div class="form-group">
						<label>HMAC(secret,time)</label>
						<br>
						<span class="badge badge-info" id="hmac"></span>
					</div>
					<div class="form-group">
						<label>One-time Password</label>
						<br>
						<span id="otpe" class="badge badge-success" style="font-size:20px;"></span>
					</div>
					<div class="form-group">
						<label>Updating in</label>
						<br>
						<div class="input">
							<span id="updatingIn" class="badge badge-primary"></span>
						</div>
					</div>                       
                </form>
                </div>
			</div>
		</div>
		
		<div class="col-md-6">                 
			<div class="card mb-3">
				<div class="card-header text-center bg-success text-white">Masukkan Kode Verifikasi</div>
                <div class="card-body">

                <form method="POST" action="verifikasi.php">							 
						<div class="form-group">
							<input id="otp" type="text" class="form-control" name="otp" required autofocus>
							<input id="secretkey" type="text" class="form-control" name="secret" hidden>
						</div>
						
						<div class="form-group no-margin">
							<input id="verifikasi" type="submit" class="btn btn-success btn-block" name="verifikasi" value="Verifikasi" />
						</div>
					</form>		
                </div>
			</div>
		</div>
	</div>
</div>

<!-- jquery -->
<script src="jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		function updateOtp() {
			var secret = $('#secret').val();
			$('#secretkey').val(secret); 
			$.ajax({
            	type : 'POST',
           		url : 'hitung.php',
            	data :  {'secret':secret},
				success: function (data) {
					var obj = $.parseJSON(data);
					var otpe = obj.otp; 
					var secretHex = obj.secretHex; 
					var time = obj.time; 
					var hmac = obj.hmac; 	
					$('#otpe').text(otpe);
					$('#secretHex').text(secretHex);
					$('#time').text(time);
					$('#hmac').text(hmac);					
				}
			});
			
		}
		
		function timer(){
			var epoch = Math.round(new Date().getTime() / 1000.0);
			var countDown = 30 - (epoch % 30);
			if (epoch % 30 == 0) updateOtp();
			$('#updatingIn').text(countDown);
		}

		$(function () {
			updateOtp();
			$('#secret').keyup(function () {
				updateOtp();
			});
			setInterval(timer, 1000);
		});
	});
</script>
</body>
</html>