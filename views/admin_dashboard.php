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
	<link rel="stylesheet" href="../css/dashboard.css">
	<?php include 'header.php'; ?>
		<!-- Data Tables Initialization -->
	<script>
  var countWebinar = 0
  var countParticipants = 0
  var countPending = 0
  	// get data from db
  async function accessDB() {
  	const {error, data} = await supabase.from('webinars').select('*');
  	return data;
  }
  // ready function, runs at the load time of the page
  $(document).ready(function() {
  	//get returned data from accessDB()
  	let x = accessDB()
  		// console.log(x)
  		//get promised result form returned data
  	x.then((a) => {
  		// Total Webinars Count
  		countWebinar = a.length
  		$('#countWebinar').html(countWebinar)
  			// Loop for counts
  		a.forEach(function(key, value) {
  			if(a[value]['webinar_status'] == 'PENDING') {
  				countPending++
  			}
  			if(a[value]['participants'] != 0) {
  				countParticipants += a[value]['participants']
  			}
  		});
  		// Total Pending Count
  		$('#countPending').html(countPending)
  			// Total Participants Count
  		$('#countParticipants').html(countParticipants)
  			//plug data into DataTable
  		$('#webinar_table').dataTable({
  			data: a,
  			columns: [{
  			data: 'id'
      }, {
  				data: 'title'
  			}, {
  				data: 'edate'
  			}, {
  				data: 'participants'
  			}, {
  				data: 'webinar_status'
  			}, ],
  			destroy: true,
  			responsive: true,
  			columnDefs: [{
  				targets: 4,
  				createdCell: function(td, cellData, rowData, row, col) {
  					if(rowData['webinar_status'] == 'DONE') {
  						$(td).html('<span class="status completed">Completed</span>')
  					}
  					if(rowData['webinar_status'] == 'PENDING') {
  						$(td).html('<span class="status pending">Pending</span>')
  					}
  					if(rowData['webinar_status'] == 'ONGOING') {
  						$(td).html('<span class="status process">Ongoing</span>')
  					}
  				}
  			}],
  		});
  	});
  });
	</script>
	<title>Admin - Dashboard</title>
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
						<h1 id="welcomeHeader">Welcome, <?php echo $_SESSION['adminName'] ?>!</h1>
						<ul class="breadcrumb">
							<li>
								<p class="paragraph"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
							</li>
						</ul>
					</div>
				</div>
				<ul class="box-info">
					<li> <i class='bx bxs-calendar-check'></i> <span class="text">
						<h3 id="countWebinar">0</h3>
						<p>Total Webinars</p>
					</span> </li>
					<li> <i class='bx bxs-group'></i> <span class="text">
						<h3 id="countParticipants">0</h3>
						<p>Participants</p>
					</span> </li>
					<li> <i class='bx bx-calendar-event'></i> <span class="text">
						<h3 id="countPending">0</h3>
						<p>Pending Webinars</p>
					</span> </li>
				</ul>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Webinars</h3> </div>
						<table id="webinar_table" class="table table-striped stripe">
							<thead>
								<tr>
									<th>Webinar ID</th>
									<th>Title</th>
									<th>Event Date</th>
									<th>Participants</th>
									<th>Status</th>
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
	$('#dashboardItem').addClass('active')
});
</script>
