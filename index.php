<?php
session_start();

//jika cookie masih tersimpan maka set session sesuai dgn levelnya
if(isset($_COOKIE['level'])){
	if($_COOKIE['level'] == 'admin'){
		$_SESSION['level'] = 'admin';
	}else if($_COOKIE['level'] == 'dosen'){
		$_SESSION['level'] = 'dosen';
	}else if($_COOKIE['level'] == 'mahasiswa'){
		$_SESSION['level'] = 'mahasiswa';
	}
}

//jika sudah login maka akan dialihkan pada halaman yg sesuai levelnya
if (isset($_SESSION['level'])) {
	if($_SESSION['level'] == 'admin') {
		header('Location: admin/');
		exit;
	}else if($_SESSION['level'] == 'dosen') {
		header('Location: dosen/');
		exit;
	}else if($_SESSION['level'] == 'mahasiswa') {
		header('Location: mahasiswa/');
		exit;
	}
}

$errorMessage = '';
if (isset($_POST['username']) && isset($_POST['password'])) {
	include 'config/konek.php';
 	$username = $_POST['username'];
 	$password = $_POST['password'];

	//mengenkripsi password
	$password = md5($password);

 	$sql = "SELECT * FROM akun
			WHERE username = '$username' AND password ='$password'";
	$result = mysqli_query($conn,$sql);

	//cek apakah username dan password ada pada database
	if (mysqli_num_rows($result) == 1) {
		$data = mysqli_fetch_assoc($result);
		$name = $data['nama'];
		$level = $data['level'];
	
		//cek remember me
		if(isset($_POST['remember'])){
			//buat cookie login
			setcookie('level', $level, time() + (60 * 60 * 24 * 30));
		}

		// buat session login sesuai level
		$_SESSION['level'] = $level;

		// buat cookies nama user
		setcookie('name', $name, time() + (60 * 60 * 24 * 30));
		
		// cek jika user login sebagai admin
		if($data['level']=="admin"){
			// alihkan ke halaman dashboard admin
			header("location:admin/");

		// cek jika user login sebagai dosen
		}else if($data['level']=="dosen"){
			// alihkan ke halaman dashboard dosen
			header("location:dosen/");

		// cek jika user login sebagai mahasiswa
		}else if($data['level']=="mahasiswa"){
			// alihkan ke halaman dashboard mahasiswa
			header("location:mahasiswa/");
		}
		
		exit;
	} else {
		$errorMessage = 'Sorry, wrong username / password';
	}
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/my-login.css">
</head>

<body class="my-login-page">
	<?php
		if ($errorMessage != '') {
	?>
	<p align="center"><strong><font color="#990000"><?php echo
	$errorMessage; ?></font></strong></p>
	<?php
		}
	?>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="assets/images/logo_pens.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form action="" method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="username">Username</label>
									<input id="username" type="text" class="form-control" name="username" value=""
										required autocomplete="off">
								</div>

								<div class="form-group">
									<label for="password">Password
									</label>
									<input id="password" type="password" class="form-control" name="password" required>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

</html>