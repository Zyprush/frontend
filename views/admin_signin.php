<!-- HTML -->
<!DOCTYPE html>
<?php
  session_start();
  // Everytime user go to sign in, log out user
  unset($_SESSION['adminName']);
  unset($_SESSION['adminEmail']);
  // Check If already Logged In and Who is logged in
	if (!isset($_SESSION['adminName'])){
    if (isset($_GET['name']) && isset($_GET['email'])){
      $_SESSION['adminName'] = $_GET['name'];
      $_SESSION['adminEmail'] = $_GET['email'];
      unset($_GET['name']);
      unset($_GET['email']);
      header('location: admin_dashboard.php');
    }
	}

?>

<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../css/AdminSignInstyle.css" />
	<link rel="stylesheet" href="../css/AdminSignInbootstrap.css" />
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <?php include 'header.php'; ?>
	<script>
  	$(document).ready(function() {
  		$('#icon').click(function() {
  			$('ul').toggleClass('show');
  		});
  	});
	</script>

	<title>Sign In</title>
</head>

<body>
	<!-- navigation bar -->
	<header class="topnav">
		<nav>
			<label class="logo">
				<a href="admin_signin.php" class="logo-img"><img src="../assets/img/logo.png" alt="logo">DICT CertGen</a>
			</label>
			<ul>
				<!-- <li><a href="#">REGISTRATION</a></li>
                    <li><a href="#">ASSESSMENT</a></li> -->
				<li><a class="active" href="#">SIGN IN</a></li>
			</ul>
			<label id="icon"> <i class="fa fa-bars"></i> </label>
		</nav>
	</header>
	<!-- Sign In -->
	<section class="main" style="z-index: 1;">
		<div class="login-container align-items-center justify-content-center py-5">
			<form class="login-form text-center pt-5" action="" name="signin_form" id="form_signin">
				<h1 class="mb-5 font-weight-normal text-uppercase">Sign In</h1> <span id="signNotif"></span>
				<div class="form-group">
					<input id="ip_email" type="text" name="email" class="form-control form-control-md" placeholder="Email"> </div>
				<div class="form-group">
					<input id="ip_pass" type="password" name="password" class="form-control form-control-md" placeholder="Password"> </div>
				<div class="forgot-link d-flex align-items-center justify-content-between">
					<!-- <div class="form-check">
						<input type="checkbox" class="form-check-input" id="remember">
						<label for="remember">Remember Password</label>
					</div> -->
					<!-- <div><a href="#">Forgot Password?</a></div> -->
				</div>
				<button type="submit" class="btn btn-dark btn-block btn-sm mt-4">Sign In</button>
				<p class="mt-4 font-weight-normal">Don't have an account? <a href="#" data-toggle="modal" data-target="#myModal"><strong>Sign Up</strong></a></p>
			</form>
		</div>
		<!-- The Modal Sign Up-->
		<div class="modal py-5 mt-5" id="myModal">
			<div class="modal-dialog mt-5">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header text-center">
						<h4 class="modal-title font-weight-bold w-100">Sign Up</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body">
						<form class="login-form text-center" action="" name="signup_form" id="form_signup"> <span id="notif"></span>
							<div class="form-group">
								<input id="ip_email1" type="text" name="email" class="form-control form-control-md" placeholder="Email"> </div>
							<div class="form-group">
								<input id="ip_name1" type="text" name="name" class="form-control form-control-md" placeholder="Name"> </div>
							<div class="form-group">
								<input id="ip_pass1" type="password" name="password" class="form-control form-control-md" placeholder="Password"> </div>
							<button type="submit" class="btn btn-dark btn-block btn-sm mt-3">Sign Up</button>
						</form>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
<!-- SCRIPTS -->
<script>
const form = document.querySelector('#form_signin');
form.addEventListener('submit', async(event) => {
	event.preventDefault()
	const formInputs = form.querySelectorAll('input')
	let submission = {}
	formInputs.forEach(element => {
		const {
			value, name
		} = element
		if(value) {
			submission[name] = value
		}
	})
	let signNotif = document.getElementById('signNotif')
	try {
		// get password from db
		var {
			error, data
		} = await supabase.from('administrator').select('*').match({
			email: submission['email']
		})
		if(data[0] != null) {
			fetched_pass = data[0]['password']
				// adminName = data[0]['name']
		} else {
			signNotif.innerHTML = 'Invalid. Please check your email/password.'
			signNotif.style.color = '#ff8888'
			return
		}
	} catch(e) {
		console.log(e)
	}
	// hash password before comparing from fetched data
	submission['password'] = sha256(submission['password'])
		// Check if match
	if(fetched_pass == submission['password']) {
		notif.innerHTML = 'Success.'
		notif.style.color = '#71c562'
    // submit the posted value in the same page
		location.href = 'admin_signin.php?name=' + data[0]['name'] + '&email=' + submission['email']
	} else {
		signNotif.innerHTML = 'Invalid. Please check your email/password.'
		signNotif.style.color = '#ff8888'
	}
})
const form1 = document.querySelector('#form_signup');
form1.addEventListener('submit', async(event) => {
	event.preventDefault()
	const formInputs = form1.querySelectorAll('input')
	let submission = {}
	formInputs.forEach(element => {
		const {
			value, name
		} = element
		if(value) {
			submission[name] = value
		}
	})
	let notif = document.getElementById('notif')
	try {
		var {
			error, data
		} = await supabase.from('administrator').select('*').match({
			email: submission['email']
		})
		if(data[0] != null) {
			notif.innerHTML = 'Sorry. This email is already registered.'
			notif.style.color = '#ff8888'
		} else {
			var {
				error, data
			} = await supabase.from('whitelist').select('*').match({
				email: submission['email']
			})
			if(data[0] != null) {
				// hash password before inserting into db
				submission['password'] = sha256(submission['password'])
					// insert to database
				var {
					error, data
				} = await supabase.from('administrator').insert([submission])
				notif.innerHTML = 'Success. You can sign in now.'
				notif.style.color = '#71c562'
			} else {
				notif.innerHTML = 'Sorry. This email is not whitelisted.'
				notif.style.color = '#ff8888'
			}
		}
	} catch(e) {
		console.log(e)
	}
})
</script>
