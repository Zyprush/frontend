<!DOCTYPE html>
<?php
  session_start();
	// Check If already Logged In and Who
	if ($_SESSION['adminName'] == null){
    header('location: admin_signin.php');
	}
?>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/addWebinarStyle.css">
	<?php include 'header.php'; ?>
	<title>Admin - Webinar Management</title>
</head>

<body>
	<?php include 'sidebar.php'; ?>
		<!-- CONTENT -->
		<section id="content">
			<!-- NAVBAR -->
			<nav> <i class='bx bx-menu'></i>
				
			</nav>
			<!-- NAVBAR -->
			<!-- MAIN -->
			<main>
				<div class="head-title">
					<div class="left">
						<h1>Webinar Management</h1> </div>
				</div>
				<div class="container">
					<header>Add Webinar Event</header>
					<form action="#" id="form_addwebinar">
						<div class="form first">
							<div class="details event"> <span class="title">Webinar Details</span>
								<div class="fields">
									<div class="input-field title">
										<label>Title</label>
										<!-- <input type="text" placeholder="Enter your webinar title"> -->
										<input id="ip_webinartitle" type="text" name="title" placeholder="Enter Your Webinar Title"> </div>
								</div>
								<div class="fields">
									<div class="input-field">
										<label>Date</label>
										<!-- <input type="date" placeholder="Enter the date"> -->
										<input id="ip_webinardate" type="date" name="edate"> </div>
									<div class="input-field ">
										<label>Meeting Link</label>
										<!-- <input type="text" placeholder="Enter the meeting link"> -->
										<input id="ip_webinarlink" type="text" name="link" placeholder="Enter the meeting link"> </div>
								</div>
								<div class="fields">
									<div class="input-field">
										<label>Generate Registration Form Link</label>
										<!-- <button>Generate</button>
									<input type="text"> -->
										<button id="btn_genRegLink">Generate</button>
										<input id="ip_generatedreglink" type="text" name="reglink" placeholder="Please save the generated registration link." disabled> </div>
									<div class="input-field">
										<label>Generate Assessment Form Link</label>
										<!-- <button>Generate</button>
									<input type="text"> -->
										<button id="btn_genAssLink">Generate</button>
										<input id="ip_generatedasslink" type="text" name="asslink" placeholder="Please save the generated assessment link." disabled> </div>
								</div>
								<div class="fields">
									<div class="input-field-btn">
										<!-- <button>Save</button> -->
										<button id="btn_submit" type="submit">Submit</button>
										<button id="btn_cancel">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</main>
		</section>
		<!-- CONTENT -->
</body>

</html>


<!-- SCRIPTS -->
<!-- Sidebar -->
<script src="../js/sidebar.js"></script>
<script>
$(document).ready(function() {
$('.sub-menu').toggleClass("show");
$('#addWebinarItem').addClass('active')
});
// ******* FORM SUBMISSION *******
const form = document.querySelector('#form_addwebinar');
const btn_reg = document.getElementById('btn_genRegLink');
const btn_ass = document.getElementById('btn_genAssLink');
const btn_submit = document.getElementById('btn_submit');
const btn_cancel = document.getElementById('btn_cancel');
var webinarID
// Button Clicks
window.onclick = async function(event) {
// Button - Submit
if(event.target == btn_submit) {
  event.preventDefault()
    // Get all inputs
  const formInputs = form.querySelectorAll('input')
  let submission = {}
    // Stack the input values
  formInputs.forEach(element => {
      const {
        value, name
      } = element
      if(value) {
        submission[name] = value
      }
    })
    // Submit to DATABASE
  submission['id'] = webinarID
  submission['webinar_status'] = 'PENDING'
  const {
    error, data
  } = await supabase.from('webinars').insert([submission])
    // This can be replaced to redirect user after saving
  location.href = 'admin_webinar-list.php'
}
// Button - Cancel
if(event.target == btn_cancel) {
  event.preventDefault()
    // Go to the Webinar List instead
  location.href = 'admin_webinar-list.php'
}
// Button - Generate Registration Link
if(event.target == btn_reg) {
  event.preventDefault()
  let reglink = document.getElementById('ip_generatedreglink')
  let webinarLink = document.getElementById('ip_webinarlink').value
  if(webinarLink == '') {
    alert('Please input webinar link before you generate')
    return
  }
  // This gets the ID from the Link provided
  webinarID = webinarLink.substring(webinarLink.lastIndexOf("?") - 11, webinarLink.lastIndexOf("?"));
  let url = window.location.href.split('?')
  reglink.value = url[0].replace('admin_add-webinar', 'user_registration') + '?' + webinarID
}
// Button - Generate Assessment Link
if(event.target == btn_ass) {
  event.preventDefault()
  let asslink = document.getElementById('ip_generatedasslink')
  let webinarLink = document.getElementById('ip_webinarlink').value
  if(webinarLink == '') {
    alert('Please input webinar link before you generate')
    return
  }
  // This gets the ID from the Link provided
  webinarID = webinarLink.substring(webinarLink.lastIndexOf("?") - 11, webinarLink.lastIndexOf("?"));
  let url = window.location.href.split('?')
  asslink.value = url[0].replace('admin_add-webinar', 'user_assessment') + '?' + webinarID
}
}


</script>
