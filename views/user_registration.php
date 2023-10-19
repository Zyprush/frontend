<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../css/userRegistrationStyle.css" />
	<link rel="stylesheet" href="../css/userRegistrationBootstrap.css" />
	<?php include 'header.php'; ?>
		<script>
		$(document).ready(function() {
			$('#icon').click(function() {
				$('ul').toggleClass('show');
			});
		});
		</script>
		<title>Registration</title>
</head>

<body>
	<!-- navigation bar -->
	<header class="topnav">
		<nav>
			<label class="logo">
				<a href="u" class="logo-img"><img src="../assets/img/logo.png" alt="logo">DICT CertGen</a>
			</label>
			<ul>
				<li><a class="active" href="#">REGISTRATION</a></li>
				<!-- <li><a href="#">ASSESSMENT</a></li>
                    <li><a href="#">SIGN IN</a></li> -->
			</ul>
			<label id="icon"> <i class="fa fa-bars"></i> </label>
		</nav>
	</header>
	<!-- Registration -->
	<section class="main">
		<div class="container py-5">
			<div class="row">
				<div class="pt-5 col-lg-5 offset-1 col-md-11 col-sm-11 col-11">
					<div class="row pt-2">
						<div class="col-lg-2 col-md-2 col-sm-2 col-2"> <span style="font-size: 35px; color: #342E37">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </span> </div>
						<div class="col-lg-10 col-lg-10 col-sm-10 col-10">
							<h3 class="font-weight-light">Go Digital For Everyone</h3>
							<p class="font-weight-light pb-5">We deliver digital certificates to all recepients. Engage and you will be rewarded.</p>
						</div>
					</div>
					<div class="row pt-2">
						<div class="col-lg-2 col-md-2 col-sm-2 col-2"> <span style="font-size: 35px; color: #342E37">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span> </div>
						<div class="col-lg-10 col-lg-10 col-sm-10 col-10">
							<h3 class="font-weight-light">Get Real Time Attendance</h3>
							<p class="font-weight-light pb-5">Real time data for real time monitoring. You matter.</p>
						</div>
					</div>
					<div class="row pt-2">
						<div class="col-lg-2 col-md-2 col-sm-2 col-2"> <span style="font-size: 35px; color:#342E37">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                </span> </div>
						<div class="col-lg-10 col-lg-10 col-sm-10 col-10">
							<h3 class="font-weight-light">Stay Connected</h3>
							<p class="font-weight-light pb-5">Join anywhere. Experience real time interactions. We facilitate greater connections.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-1 col-md-11 col-sm-11 col-11">
					<div class="card py-2 px-2">
						<div class="card-body text-center">
							<h2 class="font-weight-light pb-3">Register</h2> <strong><h6 class="font-weight-light pb-3" id="webinarTitle"></h6></strong>
							<div class="form">
								<form action="" name="reg_form" id="regform">
									<input id="ip_name" class="form-control my-3" placeholder="Name" type="text" name="name">
									<input id="ip_position" class="form-control my-3" placeholder="Email" type="text" name="email">
									<input id="ip_studentid" class="form-control my-3" placeholder="Student ID" type="text" name="studentid">
									<input id="ip_school" class="form-control my-3" placeholder="School" type="text" name="school">
									<input id="ip_organization" class="form-control my-3" placeholder="Organization" type="text" name="organization">
									<input id="ip_program" class="form-control my-3" placeholder="Program" type="text" name="program">
									<input id="ip_position" class="form-control my-3" placeholder="Position" type="text" name="position">
									<button type="submit" class="btn btn-dark btn-block btn-sm mt-4">Register</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

</html>


<!-- SCRIPTS -->

<script>
    var url
    const page = document.querySelector('body')

    page.onload = async function(){
        url = window.location.href.split('?')
        if (window.location.href.includes('?') == false){
            window.location.href = '404.php'
        }
        else if (url[1] != ''){
            try{
                const {error, data} = await supabase.from('webinars').select('*').match({id: url[1]})
                if (data[0] != null){
                    console.log('valid')
                    document.getElementById('webinarTitle').innerHTML = data[0]['title']
                }
                else{
                  window.location.href = '404.php'
                }
            }
            catch(e){
                console.log(e)
            }
        }
        else{
            window.location.href = '404.php'
        }

    }

    // ****** FORM SUBMISSION ******
    const form = document.querySelector('#regform');

    form.addEventListener('submit', async (event)=> {
        event.preventDefault()

        const formInputs = form.querySelectorAll('input')

        let submission = {}
        let user_link
        let webinar_title
        let webinar_date

        formInputs.forEach(element => {
            const { value, name} = element
            if (value){
                submission[name] = value
            }
        })

        submission['webinar_id'] = url[1]
        // console.log(url[1])
				try {
					  var {error, data} = await supabase.from('userregistration').insert([submission])
						if (data[0] != null){
								var {error, data} = await supabase.from('webinars').select('*').match({id: submission['webinar_id']})
								webinar_title = data[0]['title']
								webinar_date = data[0]['edate']
								if (data[0] != null){
										let oldNum = data[0]['participants']
										let newNum = oldNum + 1
										var {error, data} = await supabase.from('webinars').update([{participants: newNum}]).match({id: submission['webinar_id']})
								}
								// Generate Unique User Link

								let temp_link = sha256(submission['name']+submission['webinar_id']);
								let hashLink = url[0].replace('user_registration', 'redirector') + '?WID' + temp_link
								user_link = hashLink
								var {error, data} = await supabase.from('user_links').insert({participantName: submission['name'],hashString: hashLink,status: 'UNUSED', webinarID: submission['webinar_id']})
						}
				}
				catch (e){
					alert('That email is already registered!');
					return;
				}

        // if success, add to participant count



        let message = 'Thank you for registering for the webinar <strong>"' + webinar_title + '"</strong> through our system!<br><br>Kindly use this link only on the day of the event.<br><br>Webinar Link:<br><a href="'+user_link+'">'+webinar_title+' - Zoom Link</a><br>Day of event:<br>' + webinar_date
				let subject = webinar_title + ' Registration Successful!';

				console.log(submission['email'])

				jQuery.ajax({
					type: "POST",
					url: 'emailsending.php',
					dataType: 'json',
					data: {functionname: 'sendEmail', arguments: [submission['email'], message, subject]},

					success: function (obj, textstatus) {
												if( !('error' in obj) ) {
														yourVariable = obj.result;

												}
												else {
														console.log(obj.error);
												}

									}
				});

			window.location.href = 'registration_success.php';


    })



</script>
