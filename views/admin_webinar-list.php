<?php
  session_start();
	// Check If already Logged In and Who
	if ($_SESSION['adminName'] == null){
    header('location: admin_signin.php');
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/WebinarListStyle.css">
	<?php include 'header.php'; ?>
		<!-- Data Tables Initialization -->
		<script>
		var tabledata = null;
		var table = null;
		// ready function, runs at the load time of the page
		$(document).ready(function() {
			//get returned data from accessDB()
			let x = accessDB()
				//get promised result form returned data
			x.then((a) => {
				tabledata = a
				create_table()
			});
		});

		function create_table() {
			table = $('#webinar_table').dataTable({
				data: tabledata,
				columns: [{
						data: 'id'
					}, {
						data: 'title'
					}, {
						data: 'edate'
					},
					// {data: 'link'},
					{
						data: 'participants'
					}, {
						data: 'webinar_status'
					},
					// {data: 'webinar_duration_mins'},
				],
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
				}, {
					targets: '_all',
					className: "dt-center overflow-hidden align-middle"
				}],
			});
			//select row
			$('#list').on('click', 'tr', function() {
				if($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				} else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
		}
		// get data from db
		async function accessDB() {
			const {
				error, data
			} = await supabase.from('webinars').select('*');
			return data;
		}
		</script>
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
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Webinar List</h3>
							<!-- <i class='bx bx-search' ></i>
                                <i class='bx bx-filter' ></i> -->
							<div class="aed-btn">
								<button id="mbtn-add"><a>Add Webinar <i class="fa-solid fa-plus"></i></a></button>
								<button id="mbtn-link"><a>View Links <i class="fa-solid fa-link"></i></a></button>
								<button id="mbtn-edit"><a>Edit <i class="fa-solid fa-edit"></i></a></button>
								<button id="mbtn-remove"><a>Remove <i class="fa-solid fa-trash"></i></a></button>
								<button id="mbtn-edit_assessment"><a>Edit Assessment <i class="fa-solid fa-scroll"></i></a></button>
								<button id="mbtn-send"><a>Send Certificates <i class="fa-solid fa-envelope-circle-check"></i></a></button>
							</div>
						</div>
						<!-- Card Body -->
						<div class="card-body">
							<table id="webinar_table" class="table table-striped stripe" style="width: 100%;">
								<colgroup>
									<col width="15%">
										<col width="50%">
											<col width="10%">
												<!-- <col width="20%"> -->
												<col width="10%">
													<col width="10%">
														<!-- <col width="10%"> -->
								</colgroup>
								<thead>
									<tr>
										<th>Webinar ID</th>
										<th>Webinar Title</th>
										<th>Webinar Date</th>
										<!-- <th>Webinar Link</th> -->
										<th>Participants</th>
										<th>Status</th>
										<!-- <th>Duration (mins)</th> -->
									</tr>
								</thead>
								<tbody id="list"> </tbody>
							</table>
						</div>
					</div>
				</div>
			</main>
			<!-- MAIN -->
		</section>
		<!-- CONTENT -->
</body>
<style>
a:hover {
	text-decoration: none;
}

tr:hover {
	cursor: pointer;
}

.modal {
	display: none;
	/* Hidden by default */
	position: fixed;
	/* Stay in place */
	z-index: 2000;
	/* Sit on top */
	padding-top: 100px;
	/* Location of the box */
	left: 0;
	top: 0;
	width: 100%;
	/* Full width */
	height: 100%;
	/* Full height */
	overflow: auto;
	/* Enable scroll if needed */
	background-color: rgb(0, 0, 0);
	/* Fallback color */
	background-color: rgba(0, 0, 0, 0.4);
	/* Black w/ opacity */

}


/* Modal Title */

.modal-title {
  color: white !important;
	font-weight: 500;
	font-size: 1.5rem;
}


/* Modal Content */

.modal-content {
	background-color: #fefefe;
	margin: auto;
	width: 50%;
  border-top: none;
}


/* The Close Button */

.close {
	color: #999;
	float: right;
	font-size: 28px;
	font-weight: bold;
}

.close:hover,
.close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
}

.custom-label {
	border: none;
	background-color: #eee;
}
</style>
<!-- MODAL FOR LINKS -->
<div id="modallink" class="modal card">
	<!-- Modal Header -->
	<div class="modal-content">
		<div class="card-header bg-primary"> <span class="modal-title">WEBINAR LINKS</span> <i id="close_link" class="fa-solid fa-xmark close"></i> </div>
		<!-- Modal content -->
		<div class="card-body text-center">
			<form action="" class="text-center" id="form_link">
				<label id="webinar_id-link" for="ip_webinarid" class="form-control">Webinar ID: </label>
				<br>
				<label for="ip_link-link">Webinar Link</label>
				<br>
				<input id="ip_link-link" type="text" name="link" class="form-control" disabled>
				<br>
				<label for="ip_reglink-link">Webinar Registration Link</label>
				<br>
				<input id="ip_reglink-link" type="text" name="reglink" class="form-control" disabled>
				<br>
				<label for="ip_asslink-link">Webinar Assessment Link</label>
				<br>
				<input id="ip_asslink-link" type="text" name="asslink" class="form-control" disabled>
				<br> </form>
		</div>
	</div>
</div>
<!-- The Modal -->
<div id="modaledit" class="modal card">
	<!-- Modal Header -->
	<div class="modal-content">
		<div class="card-header bg-primary"> <span class="modal-title">EDIT</span> <i id="close_edit" class="fa-solid fa-xmark close"></i> </div>
		<!-- Modal content -->
		<div class="card-body text-center">
			<form action="" class="text-center" id="form_edit">
				<label><strong>Webinar ID: </strong></label>
				<br>
				<label id="webinar_id" class="form-control overflow-hidden custom-label"></label>
				<br>
				<label for="ip_title"><strong>Webinar Title: </strong></label>
				<br>
				<input id="ip_title" type="text" name="title" class="form-control">
				<br>
				<label for="ip_date"><strong>Webinar Date: </strong></label>
				<br>
				<input id="ip_date" type="date" name="edate" class="form-control">
				<br>
				<br>
				<!-- Save Button -->
				<button id="btn-save" type="submit" class="btn bg-primary" style="color:white;" value="Save">Save</button>
			</form>
		</div>
	</div>
</div>
<div id="modalremove" class="modal card">
	<!-- Modal Header -->
	<div class="modal-content">
		<div class="card-header bg-primary"> <span class="modal-title">REMOVE</span> <i id="close_remove" class="fa-solid fa-xmark close"></i> </div>
		<!-- Modal content -->
		<div class="card-body text-center">
			<form action="" class="text-center" id="form_remove"> <strong>Are you sure you want to remove this record?</strong>
				<label id="webinar_id-rem" for="ip_webinarid" class="form-control">Webinar ID: </label>
				<br>
				<label for="ip_title-rem">Webinar Title</label>
				<br>
				<input id="ip_title-rem" type="text" name="title" class="form-control" disabled>
				<br>
				<label for="ip_date-rem">Webinar Date</label>
				<br>
				<input id="ip_date-rem" type="date" name="edate" class="form-control" disabled>
				<br>
				<br>
				<!-- Remove Button -->
				<button id="btn-remove" type="submit" class="btn bg-primary" style="color:white;" value="Remove">Remove</button>
			</form>
		</div>
	</div>
</div>
<div id="modalassessment" class="modal card">
	<!-- Modal Header -->
	<div class="modal-content">
		<div class="card-header bg-primary"> <span class="modal-title">Edit Assessment</span> <i id="close_assessment" class="fa-solid fa-xmark close"></i> </div>
		<!-- Modal content -->
		<div class="card-body text-center">
			<form action="" class="text-center" id="form_remove"> <strong>Editing assessment form means starting over. You will not be able to edit/retrieve the previous assessment form (if there are any).<br><br>Continue?</strong>
				<br>
				<!-- Confirm Button -->
				<button id="btn-assessment" type="submit" class="btn bg-primary" style="color:white;" value="Remove">Yes</button>
			</form>
		</div>
	</div>
</div>
<!-- Modal send cert -->
<div id="modalsend" class="modal card">
	<!-- Modal Header -->
	<div class="modal-content">
		<div class="card-header bg-primary"> <span class="modal-title">SEND CERTIFICATES</span> <i id="close_send" class="fa-solid fa-xmark close"></i> </div>
		<!-- Modal content -->
		<div class="card-body text-center">
			<form action="" class="text-center" id="form_remove"> <strong>Sending Certificates will remove all data of the selected webinar. Make sure that the assessment is already closed (if there are any).<br><br>Continue?</strong>
				<br>
				<!-- Confirm Button -->
				<button id="btn-sendCertificates" type="submit" class="btn bg-primary" style="color:white;" value="Remove">Yes</button>
			</form>
		</div>
	</div>
</div>

</html>


<!-- Scripts -->
<!-- Sidebar -->
<script src="../js/sidebar.js"></script>
<script>
    //Toggle at page load
    $(document).ready(function(){
        $('.sub-menu').toggleClass("show");
        $('#webinarListItem').addClass('active')
    });


    // Find ID of edit modal inputs
    const find = document.getElementById('btn-find');
    var webinar_id = document.getElementById('webinar_id');
    var webiinar_link = document.getElementById('webinar_link');
    var wreg_link = document.getElementById('reg_link');
    var ass_link = document.getElementById('ass_link');
    var webinar_title = document.getElementById('ip_title');
    var webinar_date = document.getElementById('ip_date');


    // Find ID of remove modal inputs
    var webinar_id_rem = document.getElementById('webinar_id-rem');
    var webinar_title_rem = document.getElementById('ip_title-rem');
    var webinar_date_rem = document.getElementById('ip_date-rem');

    // Find ID of send cert modal inputs
    var webinar_id_link = document.getElementById('webinar_id-link');
    var webinar_link_link = document.getElementById('ip_link-link');
    var webinar_reglink_link = document.getElementById('ip_reglink-link');
    var webinar_asslink_link = document.getElementById('ip_asslink-link');

    var selected_id = null;

    // Submit changes of edit modal
    const form = document.querySelector('#form_edit');
    const btn_saveEdit =  document.getElementById('btn-save')

    // Confirm Removal of Record
    const btn_removeData = document.getElementById('btn-remove');

    // Confirm Editing of Assessment Form
    const btn_editAssessment = document.getElementById('btn-assessment');

    // Confirm Send certificate
    const btn_sendCertificates = document.getElementById('btn-sendCertificates');


    // MODAL OPEN SCRIPTS
    // Get the modal
    var modal_edit = document.getElementById("modaledit");
    var modal_remove = document.getElementById("modalremove");
    var modal_assessment = document.getElementById('modalassessment')
    var modal_link = document.getElementById("modallink");
    var modal_send = document.getElementById('modalsend');

    // Get the button that opens the modal
    var btn_add = document.getElementById('mbtn-add');
    var btn_edit = document.getElementById("mbtn-edit");
    var btn_remove = document.getElementById("mbtn-remove");
    var btn_send = document.getElementById('mbtn-send');
    var btn_assessment = document.getElementById('mbtn-edit_assessment')
    var btn_link = document.getElementById("mbtn-link");
    var btn_send = document.getElementById('mbtn-send');

    // Get the <span> element that closes the modal
    var close_edit = document.getElementById('close_edit');
    var close_remove = document.getElementById('close_remove');
    var close_assessment = document.getElementById('close_assessment');
    var close_link = document.getElementById('close_link');
    var close_send = document.getElementById('close_send');



    // When the user clicks anywhere outside of the modal, close it
    window.onclick = async function(event) {
        if (event.target == close_edit){
            webinar_id.value = ""
            modal_edit.removeAttribute('style');
        }
        if (event.target == close_remove){
            modal_remove.removeAttribute('style');
        }
        if (event.target == close_assessment){
            modal_assessment.removeAttribute('style');
        }
        if (event.target == close_link) {
        modal_link.removeAttribute('style');
        }
        if (event.target == close_send) {
        modal_send.removeAttribute('style');
        }
    }


    btn_add.onclick = function(){
        window.location.href = 'admin_add-webinar.php'
    }

    btn_edit.onclick = async function(event){
        event.preventDefault()
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML

            //get from database and insert into modal fields
            const {error, data} = await supabase.from('webinars').select('*').match({id: selected_id})
            webinar_id.innerHTML = selected_id
            webinar_title.value = data[0]['title']
            webinar_date.value = data[0]['edate']
        }
        catch(e){
            alert("There is no record selected. Please select a record first.")
            webinar_title.value = ""
            webinar_date.value = ""
            return
        }
        modal_edit.style.display = "block";
    }

    btn_remove.onclick = async function(event){
        event.preventDefault()
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML

            const {error, data} = await supabase.from('webinars').select('*').match({id: selected_id})
            webinar_id_rem.innerHTML = 'Webinar ID: ' + selected_id
            webinar_title_rem.value = data[0]['title']
            webinar_date_rem.value = data[0]['edate']
        }
        catch(e){
            alert("There is no record selected. Please select a record first.")
            webinar_title.value = ""
            webinar_date.value = ""
            return
        }
        modal_remove.style.display = "block";
    }

    btn_saveEdit.onclick = async function (event){
        event.preventDefault()

            const formInputs = form.querySelectorAll('input')

            let submission = {}

            formInputs.forEach(element => {
                const { value, name} = element
                if (value){
                    submission[name] = value
                }
            })

            const {error, data} = await supabase.from('webinars').update([submission]).match({id: selected_id})

            document.getElementById('modaledit').style.display = "none";
            location.reload()
    }


    btn_link.onclick = async function() {
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML

            var {error, data} = await supabase.from('webinars').select('*').match({id: selected_id})
            webinar_id_link.innerHTML = 'Webinar ID:' + selected_id
            webinar_link_link.value = data[0]['link']
            webinar_reglink_link.value = data[0]['reglink']
            webinar_asslink_link.value = data[0]['asslink']


        }
        catch(e){
            alert("There no record selected. Please select a record first.")
            webinar_link_link.value = ""
            webinar_reglink_link.value = ""
            webinar_asslink_link.value = ""
            return
        }
        modal_link.style.display = "block";
    }

    btn_assessment.onclick = function(){
        event.preventDefault()
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML

        }
        catch(e){
            alert("There is no record selected. Please select a record first.")
            return
        }
        modal_assessment.style.display = "block";

    }

    btn_send.onclick = function(){
        event.preventDefault()
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML

        }
        catch(e){
            alert("There is no record selected. Please select a record first.")
            return
        }
        modal_send.style.display = "block";

    }

    btn_removeData.onclick = async function(event){
        event.preventDefault()
        var {error, data} = await supabase.from('webinars').delete('*').match({id: selected_id})
        // Remove the assessment of the selected webinar
        var {error, data} = await supabase.from('assessments').delete('*').match({id: selected_id})
        // Remove the user links of the selected webinar
        var {error, data} = await supabase.from('user_links').delete('*').match({webinarID: selected_id})
        // Remove the activity tracks of the selected webinar
        var {error, data} = await supabase.from('activity_track').delete('*').match({meeting_id: selected_id})
        // Remove participants from database after sending certs
        var {error, data} = await supabase.from('userregistration').delete('*').match({webinar_id: selected_id})
        modal_remove.removeAttribute('style')
        location.reload()
    }
    btn_editAssessment.onclick = function(event){
        event.preventDefault()
        window.location.href = 'admin_assessment.php?'+selected_id
        modal_assessment.removeAttribute('style')
    }


    btn_sendCertificates.onclick = async function(event){
        event.preventDefault()
        let meetDuration = 0
        let webinarTitle
        let webinarDate
        try {
            //get id of selected row
            let selected_row = document.getElementsByClassName('selected')[0];
            selected_id = selected_row.cells[0].innerHTML
            var {error, data} = await supabase.from('webinars').select('*').match({id: selected_id})
            meetDuration = data[0]['webinar_duration_mins']
            webinarTitle = data[0]['title']
            webinarDate = data[0]['edate']

            if (data[0]['webinar_status'] != 'DONE'){
                alert('The webinar is not done yet.')
                return
            }
        }
        catch(e){
            alert("There is no record selected. Please select a record first.")
            return
        }

        var {error, data} = await supabase.from('userregistration').select('*').match({webinar_id: selected_id})
        // console.log(data)

        data.forEach(function(value){
            let to_subject = 'Certificate of Attendance: ' + webinarTitle
            let to_message = 'Thank You for participating in the DICT webinar session. <br><br>Please find attached PDF containing your certificate of attendance.<br><br>Thank You and Stay Safe!'


            if (value['duration_mins'] >= (.80 * meetDuration)){
                // Generate then send email
                generatePDF(value['name'],value['email'],to_subject,to_message,webinarTitle,webinarDate)
            }

        });

        setTimeout(function(){
           window.location.reload();
        }, 5000);
    }


    const { PDFDocument, rgb, degrees } = PDFLib;

    const generatePDF = async (name,emailTo,emailSubject,message,wTitle,wDate) => {
        const existingPdfBytes = await fetch("../assets/templates/COA-Template1.pdf").then((res) =>
            res.arrayBuffer()
        );

        // Load a PDFDocument from the existing PDF bytes
        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        pdfDoc.registerFontkit(fontkit);


        //get font
        const fontBytes = await fetch("../assets/fonts/Aspire.ttf").then((res) =>
            res.arrayBuffer()
        );
        // Embed our custom font in the document
        const SanChezFont  = await pdfDoc.embedFont(fontBytes);
        // Get the first page of the document
        const pages = pdfDoc.getPages();
        const firstPage = pages[0];

        // Draw a string of text diagonally across the first page
        firstPage.drawText(name, {
            x: 250,
            y: 270,
            size: 60,
            font: SanChezFont,
            color: rgb(0, 0, 0),
        });
        var name_length = SanChezFont.widthOfTextAtSize(name, 60)
        console.log(name_length)
        firstPage.drawLine({
            start: { x: 230, y: 250 },
            end: { x: (230+name_length+30), y: 250 },
            thickness: 1,
            color: rgb(0, 0, 0),
        })
        // console.log(firstPage.getPosition())

        var desc = 'for actively participating in the DICT webinar session entitled "' + wTitle +'" held on ' + wDate + ' via virtual platform.';
        // console.log(d)
        firstPage.drawText(desc, {
            x: 230,
            y: 225,
            size: 14,
            color: rgb(0, 0, 0),
            maxWidth: 480,
        });

        // Serialize the PDFDocument to bytes (a Uint8Array)
        const pdfDataUri = await pdfDoc.saveAsBase64({ dataUri: true });


        let filename = name + '-Certificate of Attendance.pdf';
				let subject = emailSubject;
				let pdfURI = pdfDataUri.replace('data:application/pdf;base64,', '')

				jQuery.ajax({
					type: "POST",
					url: 'emailsending.php',
					dataType: 'json',
					data: {functionname: 'sendEmail', arguments: [emailTo, message, subject], attachment: [pdfURI, filename]},

					success: function (obj, textstatus) {
												if( !('error' in obj) ) {
														yourVariable = obj.result;

												}
												else {
														console.log(obj.error);
												}

									}
				});
        // Remove participants from database after sending certs
        var {error, data} = await supabase.from('userregistration').delete('*').match({webinar_id: selected_id})
        // Remove selected webinar from database after sending all certs
        var {error, data} = await supabase.from('webinars').delete('*').match({id: selected_id})
        // Remove the assessment of the selected webinar
        var {error, data} = await supabase.from('assessments').delete('*').match({id: selected_id})
        // Remove the user links of the selected webinar
        var {error, data} = await supabase.from('user_links').delete('*').match({webinarID: selected_id})
        // Remove the activity tracks of the selected webinar
        var {error, data} = await supabase.from('activity_track').delete('*').match({meeting_id: selected_id})


    };
</script>
