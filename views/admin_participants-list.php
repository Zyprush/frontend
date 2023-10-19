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
	<link rel="stylesheet" href="../css/participantListStyle.css">
	<?php include 'header.php'; ?>
	<!-- Data Tables Initialization -->
	<script>
	// get data from db
	async function accessDB() {
		const {
			error, data
		} = await supabase.from('userregistration').select('*');
		return data;
	}
	// ready function, runs at the load time of the page
	$(document).ready(function() {
		//get returned data from accessDB()
		let x = accessDB()
		console.log(x)
			//get promised result form returned data
		x.then((a) => {
			//plug data into DataTable
			$('#participant_table').dataTable({
				data: a,
				columns: [{
						data: 'studentid'
					}, {
						data: 'name'
					}, {
						data: 'school'
					}, {
						data: 'organization'
					}, {
						data: 'program'
					}, {
						data: 'position'
					}, {
						data: 'webinar_id'
					},
					// {data: 'duration_mins'},
				]
			});
		});
	});
	</script>
	<title>Admin - Participant Management</title>
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
						<h1>Participant Management</h1> </div>
				</div>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Participant List</h3> </div>
						<table id="participant_table" class="table table-striped stripe table-bordered table-hover">
							<thead>
								<tr>
									<th>Student ID</th>
									<th>Name</th>
									<th>School</th>
									<th>Organization</th>
									<th>Program</th>
									<th>Position</th>
									<th>Webinar ID</th>
									<!-- <th>Duration</th> -->
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</main>
			<!-- MAIN -->
		</section>
		<!-- CONTENT -->
</body>

</html>
<!-- Scripts -->
<!-- Sidebar -->
<script src="../js/sidebar.js"></script>
<script>
$(document).ready(function() {
	$('#participantMgtItem').addClass('active')
});
</script>
