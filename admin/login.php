<?php include '../functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="../assets/images/favicon.ico" />
	<title>LOGIN</title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/css/signin.css" rel="stylesheet" />
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
</head>

<body style="background: url('../assets/images/bgr.png'); background-size: cover;">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Silahkan masuk
					</div>
					<div class="panel-body">
						<form action="?act=login" method="post" class="text-center">
							<img src="../assets/images/login.png" />
							<?php
							if ($_POST) {
								$user = esc_field($_POST['user']);
								$pass = esc_field($_POST['pass']);

								$row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass=MD5('$pass')");
								if ($row) {
									$_SESSION['adm_id'] = $row->id_admin;
									$_SESSION['adm_nama'] = $row->nama_admin;
									$_SESSION['adm_username'] = $row->user;
									$_SESSION['level'] = $row->level;
									redirect_js("index.php");
								} else
								print_msg("Salah kombinasi username dan password.");
							} ?>
							<div class="form-group">
								<input type="text" class="form-control input-sm" placeholder="Username" name="user" autofocus />
							</div>
							<div class="form-group">
								<input type="password" class="form-control input-sm" placeholder="Password" name="pass" />
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block btn-sm" type="submit">Masuk</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>