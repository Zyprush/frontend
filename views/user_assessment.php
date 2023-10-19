<html>

<head>
	<!-- Bootstrap 4 -->
	<link rel="stylesheet" href="../css/adminAssessmentBootstrap.css">
	<link rel="stylesheet" href="../css/adminAssessmentStyle.css">
	<?php include 'header.php'; ?>
		<title>Assessment</title>
</head>

<body>
	<style>
	.form-header {
		border-top: 20px solid #134991;
	}

	input[type=text],
	input[type=email] {
		width: 50%;
	}

	textarea {
		outline: none;
		font-size: 14px;
		border: none;
		border-radius: 6px;
		padding: 12px 15px 12px 15px;
		margin: 8px 0;
		width: 100%;
	}

	textarea:is(:focus, :valid) {
		box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
	}

	input[type=radio] {
		border: 1px solid black !important;
		margin: -2 8px 0 8px !important;
		width: 18px;
		height: 18px !important;
		vertical-align: middle;
	}

	input[type=radio]:is(:focus, :valid) {
		box-shadow: none !important;
	}
	</style>
	<!-- Form Outer Container -->
	<div class="" id="bodyhtml">
		<!-- Form -->
		<form action="" name="ass_form" class="" id="form_submitAssessment">
			<!-- Form Inner Container -->
			<div id="form-container">
				<!-- Form Title and Description -->
				<div class="container form-header">
					<div class="card">
						<div class="card-body">
							<h4 for="" id="form_title"></h4>
							<p for="" id="form_desc"></p>
						</div>
					</div>
				</div>
				<div id="question0" class="card question0">
					<div class="container">
						<div class="card-body">
							<div class="question-title0">Email:</div>
							<input id="email" type="email"> </div>
					</div>
				</div>
				<!-- Created/Cloned Elements will be inserted here -->
			</div>
			<div class="btnDown text-center">
				<button id="btn_submit" type="submit" class="btn bg-primary">Submit</button>
			</div>
		</form>
	</div>
</body>
<!-- Question Template -->
<div id="question" class="card question" hidden>
	<div class="container">
		<div class="card-body">
			<div class="question-title col-lg-12"> </div>
		</div>
	</div>
</div>
<!-- Short Answer Template -->
<input id="short_ans" type="text" class="col-lg-12" hidden>
<br>
<!-- Long Answer Template -->
<textarea id="long_ans" type="text" rows="5" style="resize: none;" class="col-lg-12" hidden></textarea>
<br>
<!-- Linear Scale Template -->
<div id="linear_ans" class="col-lg-12 d-flex row text-center" hidden>
	<label id="first" class="col-lg-3" style="color:#555;"></label>
	<div id="radio_div" class="col-lg-6">
		<!-- Radio buttons will be inserted here -->
	</div>
	<label id="last" class="col-lg-3" style="color:#555;"></label>
</div>
<!-- Linear Scale Radio Template -->
<input id="linear_radio" type="radio" name="" value="" class="col-lg-12" hidden>
<br>
<br>
<!-- Multiple Choice Template -->
<div id="multiple_ans" class="col-lg-12" hidden> </div>
<!-- Choices Template -->
<input id="choices" type="radio" class="" hidden>
<label id="choice_name" class="choice-label" hidden></label>

</html>

<!-- Scripts -->
<script>
    var question_count = 0
    var form_title
    var form_desc
    var question_types = []
    var question_range = []
    var question_titles = []
    var question_choices = []
		var code

    const page = document.querySelector('body')

    page.onload = async function(){
        var fetched
        // Get data from the db
        let url = window.location.href
        code = url.split('?')
        if (url.includes('?') == false){
            window.location.href = '404.html'
        }
        else if (code[1] != ''){
            try{
                const {error, data} = await supabase.from('assessments').select('*').match({id: code[1]})
                if (data[0] != null){
                    fetched = [data[0]]
                }
                else{
                    window.location.href = '404.html'
                    return
                }
            }
            catch(e){
                window.location.href = '404.html'
                return
            }
        }
        else{
            window.location.href = '404.html'
        }




        // store the fetched data
        fetched.forEach(element => {
            question_count = element['question_count']
            form_title = element['form_title']
            form_desc = element['form_description']
            question_types = element['question_types'].split("$")
            question_range = element['question_range'].split("$")
            question_titles = element['question_titles'].split("$")
            question_choices = element['question_choices'].split("$")
        });

        document.getElementById('form_title').innerHTML = form_title
        document.getElementById('form_desc').innerHTML = form_desc
        // console.log(form_title + ' ' + form_desc)

        // Clone to the number of questions
        var question_temp = document.getElementsByClassName('question')[0]
        var short_temp = document.getElementById('short_ans')
        var long_temp = document.getElementById('long_ans')
        var linear_temp = document.getElementById('linear_ans')
        var linear_radio = document.getElementById('linear_radio')
        var multiple_temp = document.getElementById('multiple_ans')
        var multiple_choices = document.getElementById('choices')
        var multiple_name = document.getElementById('choice_name')
        var form = document.getElementById('form-container')

        // Clone and append to formcontainer
        for (var i = 0; i < question_count; i++){
            var q = question_temp.cloneNode(true)
            q.id = 'question'+(i+1)
            q.removeAttribute('hidden')
            form.appendChild(q)

            if (question_types[i] == 1){
                q.childNodes[1].childNodes[1].childNodes[1].innerHTML = question_titles[i]
                var input = short_temp.cloneNode(true)
                input.id = 'short_ans' + (i+1)
                input.removeAttribute('hidden')
                input.setAttribute('class','answer')


                q.childNodes[1].childNodes[1].appendChild(input)

            }
            if (question_types[i] == 2){
                q.childNodes[1].childNodes[1].childNodes[1].innerHTML = question_titles[i]
                var input = long_temp.cloneNode(true)
                input.id = 'long_ans' + (i+1)
                input.removeAttribute('hidden')
                input.setAttribute('class','answer')
                q.childNodes[1].childNodes[1].appendChild(input)

            }
            if (question_types[i] == 3){
                q.childNodes[1].childNodes[1].childNodes[1].innerHTML = question_titles[i]

                var div = linear_temp.cloneNode(true)
                div.id = 'linear_ans' + (i+1)
                div.removeAttribute('hidden')
                q.childNodes[1].childNodes[1].appendChild(div)



                var linear_range = question_range[i].split('_').map(Number)
                var linear_choice = question_choices[i].split('_')
                // console.log(linear_range)
                for (var k = linear_range[0]; k < linear_range[1] + 1; k++){
                    var radio = linear_radio.cloneNode(true)
                    radio.value = k
                    radio.id = 'linear'+(i+1) + '_' + 'radio' + k
                    radio.setAttribute('name', 'linear'+(i+1)+'_choices')
                    radio.removeAttribute('hidden')
                    radio.setAttribute('class','answer')

                    div.childNodes[3].appendChild(radio)
                    div.childNodes[1].innerHTML = linear_choice[0]
                    div.childNodes[5].innerHTML = linear_choice[1]
                }

            }
            if (question_types[i] == 4){
                q.childNodes[1].childNodes[1].childNodes[1].innerHTML = question_titles[i]

                var div = multiple_temp.cloneNode(true)
                div.id = 'multiple_ans' + (i+1)
                div.removeAttribute('hidden')
                q.childNodes[1].childNodes[1].appendChild(div)

                var m_choice = question_choices[i].split('~')
                var choice_count = question_count[i]
                for (var k = 0; k < m_choice.length; k++){
                    var choices = multiple_choices.cloneNode(true)
                    choices.value = m_choice[k]
                    choices.id = 'multiple' + (i+1) + '_' + 'choices' + (k+1)
                    choices.setAttribute('name','multiple'+(i+1)+'_choices')
                    choices.removeAttribute('hidden')
                    choices.setAttribute('class','answer')

                    var choice_name = multiple_name.cloneNode(true)
                    choice_name.innerHTML = '&nbsp;' +  m_choice[k]
                    choice_name.id = 'multiple' + (i+1) + '_' + 'choice_name' + (k+1)
                    choice_name.setAttribute('name','multiple'+(i+1)+'_name')
                    choice_name.removeAttribute('hidden')

                    div.appendChild(choices)
                    div.appendChild(choice_name)
                    div.appendChild(document.createElement('br'))

                }
            }
        }

    }


    //Submit function
    const form = document.getElementById('form_submitAssessment')
    const btn_submit =  document.getElementById('btn_submit')
    var answers_array = []

    btn_submit.addEventListener('click', async function(event) {
        event.preventDefault();
        var formInputs = form.querySelectorAll('.answer')
        var input_count = 0
        formInputs.forEach(element => {

            if (element.tagName == 'INPUT'){
                if (element['type'] == 'text'){
                if (element.value != ""){
                    input_count++
                }
            }
            if (element['type'] == 'radio'){
                if (element.checked){
                    input_count++
                }
            }
            }
            if (element.tagName == 'TEXTAREA'){
                if (element.value != ''){
                    input_count++
                }
            }
        })
        // console.log(input_count)
        var assessment_rate = (input_count/question_count) * 100
        if (assessment_rate >= 80 ){
						var webinarID
						var duration
						var to_email
						var userName

            var u_email = document.getElementById('email').value
            if (u_email == ''){
                alert('Your email is required!')
            }
						try{
							var {error, data} = await supabase.from('userregistration').select('*').match({email: u_email, webinar_id: code[1]})
							webinarID = data[0]['webinar_id']
	            duration = data[0]['duration_mins']
	           	to_email = data[0]['email']
							userName = data[0]['name']
						}
            catch{
							alert('There are no registered user with that email. Or the webinar may already be closed.');
							return
						}

            if (webinarID != null){
                // Check attendance first
                var {error, data} = await supabase.from('webinars').select('*').match({id: webinarID})
                var webinarDuration = data[0]['webinar_duration_mins']
                var webinarTitle = data[0]['title']
                var webinarDate = data[0]['edate']
                var attendance_rate = (duration/webinarDuration) * 100
								//
                if (attendance_rate >= 80){
                    console.log('Attendance rate = ' + attendance_rate)
                    // send Email
                    let to_subject = 'Certificate of Completion: ' + webinarTitle
                    let to_message = 'Thank you for participating in the webinar <strong>"'+ webinarTitle +'"</strong> on '+ webinarDate +'. <br><br>Please find attached PDF containing your certificate of completion.<br><br>Thank You and Stay Safe!'

                    //generate PDF
										console.log(userName);
                    generatePDF(userName, to_email, to_subject, to_message, webinarTitle, webinarDate);
                    console.log('You get a COC! Rate = ' + assessment_rate + "%")
                }
                else{
                  location.href = 'assessment_success.php';
								}



            }
            else{
                alert('There are no registered user with that email. Or the webinar may already be closed.');
								return
            }

        }

    });


</script>




<script>
    const { PDFDocument, rgb, degrees } = PDFLib;

    const generatePDF = async (name,emailTo,emailSubject,message,wTitle,wDate) => {
        const existingPdfBytes = await fetch("../assets/templates/COC-Template1.pdf").then((res) =>
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
        // saveAs(pdfDataUri,"Webinar-Certificate.pdf")


				let filename = name + '-Certificate of Completion.pdf';
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
				window.location.href = 'assessment_success.php';


    };

</script>
