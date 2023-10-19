<!-- INCLUDES -->
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
	<!-- Bootstrap 4 -->
	<link rel="stylesheet" href="../css/adminAssessmentBootstrap.css">
	<link rel="stylesheet" href="../css/adminAssessmentStyle.css">
	<?php include 'header.php'; ?>
  <title>Edit Assessment Form</title>
</head>

<body style="background: #eee;">
	<div class="head-title">
		<div class="left">
			<h1>Assessment</h1> </div>
	</div>
	<!-- Form Outer Container -->
	<div class="text-center" id="bodyhtml">
		<!-- Form -->
		<form action="" name="ass_form" class="" id="assform">
			<!-- Form Inner Container -->
			<div id="form-container">
				<!-- Form Title and Description -->
				<div class="container">
					<div class="card">
						<div class="card-body">
							<input id="form_title" class="col-lg-12" type="text" name="form_title" placeholder="Untitled Form" required>
							<input id="form_desc" class="col-lg-12" type="text" name="form_description" placeholder="Form Description" required> </div>
					</div>
				</div>
				<div class="container">
					<div id="question_template-" class="card">
						<div class="card-body">
							<div class="question0">
								<div class="question-title0 float-left">Email:</div>
								<br> </div>
						</div>
					</div>
				</div>
				<!-- Created/Cloned Elements will be inserted here -->
			</div>
			<div class="addIcon"> <i id="btn_addQuestion" class="fa-solid fa-plus" style="cursor: pointer;"></i> </div>
			<div class="btnDown">
				<button type="" class="btn bg-danger" id="btn_cancel">Cancel</button>
				<button type="" class="btn bg-primary" id="btn_save">Save Form</button>
			</div>
		</form>
	</div>
</body>
<!-- Question Template -->
<!-- Copied when adding a new question -->
<div id="question_template" class="card question" hidden>
	<div class="container">
		<div class="card-body">
			<input id="" class="col-lg-8 card-title" type="text" name="question_titles" placeholder="Untitled question">
			<select id="select_type" class="col-lg-3" onchange="selected_type(this.id)">
				<option value="null">--</option>
				<option value="1">Short Answer</option>
				<option value="2">Paragraph</option>
				<option value="3">Linear Scale</option>
				<option value="4">Multiple Choice</option>
			</select>
			<!-- this div changes depending on the selected type -->
			<div id="type_options"></div>
		</div> <i id="btn_deleteQuestion" class="fa-solid fa-trash" style="cursor: pointer;"></i> </div>
</div>
<!-- short template -->
<div id="type_options_short" hidden>
	<label id="short" class="col-lg-2 " type="text" name="question_choices">Short Answer</label>
	<!-- <input type="number" name="" id="" hidden> -->
</div>
<!-- long template -->
<div id="type_options_long" hidden>
	<label id="long" class="col-lg-2 " type="text" name="question_choices">Long Answer</label>
	<!-- <input type="number" name="" id="" hidden> -->
</div>
<!-- linear template -->
<div id="type_options_linear" hidden>
	<input id="linear_first" type="number" min="0" max="1" name="question_range">&nbsp;to
	<input id="linear_last" type="number" min="2" max="5" name="question_range">
	<br>
	<input id="ip_first" type="text" name="question_choices" placeholder="First">
	<br>
	<input id="ip_last" type="text" name="question_choices" placeholder="Last"> </div>
<!-- multiple choice template -->
<div id="type_options_multiple" hidden> <i id="btn_add_opt" class="fa-solid fa-plus" style="cursor: pointer;"> OPTION</i>
	<br>
	<br> </div>
<!-- Radio Option tempate -->
<div id="radio_temp" class="mc_option" hidden>
	<input id="" type="text" name="question_choices" placeholder="Option"> <i id="del_opt" class="fa-solid fa-close" style="cursor: pointer;"></i>
	<br> </div>

</html>

<!-- SCRIPTS -->

<script>

let url = window.location.href
let code = url.split('?')
// count used for differentiating created element
// container is a div inside the form where created element are created inside
var count = 0
const container = document.getElementById('form-container')
//function to display the selected question type
function selected_type(el_id) {
  var type_el = document.getElementById(el_id) // get the dropdown element of the specific question
  var type_val = type_el.value // get the value of the selector
  var type_parent = type_el.parentNode // get the parent of that selector
  // clear options div
  var type_option = type_parent.querySelectorAll('#type_options')[0]
  // set value of the specific id demo based on the specific dropdown value
  if(type_val == 1) {
    var rep = document.getElementById('type_options_short').cloneNode(true);
    rep.id = "type_options"
    rep.removeAttribute('hidden')
    type_parent.replaceChild(rep, type_option)
  } else if(type_val == 2) {
    var rep = document.getElementById('type_options_long').cloneNode(true);
    rep.id = "type_options"
    rep.removeAttribute('hidden')
    type_parent.replaceChild(rep, type_option)
  } else if(type_val == 3) {
    var rep = document.getElementById('type_options_linear').cloneNode(true);
    rep.id = "type_options"
    rep.removeAttribute('hidden')
    type_parent.replaceChild(rep, type_option)
  } else if(type_val == 4) {
    var rep = document.getElementById('type_options_multiple').cloneNode(true);
    rep.id = "type_options"
    rep.removeAttribute('hidden')
    type_parent.replaceChild(rep, type_option)
  }
}
// used for icon clicks / button clicks (add, delete)
window.onclick = function() {
  // if the id of the clicked element is btn_deleteQuestion
  if(event.target.id == 'btn_deleteQuestion') {
  //remove the parent node so the whole element disappears
    event.target.parentNode.parentNode.remove()
  }
  // if the id of the clicked element is btn_addQuestion
  if(event.target.id == 'btn_addQuestion') {
    count++; // increment count
    let qtemp = document.getElementById('question_template') // qtemp = template to be copied
    let q = qtemp.cloneNode(true) // q = cloned node of qtemp
    q.removeAttribute('hidden') // remove the hidden attribute so the clone is visible
    q.setAttribute('id', 'question' + count) // set specific id to differentiate from other question
    s = q.querySelectorAll('#select_type')[0] // get the dropdown in that element
    s.setAttribute('id', 'select_type' + count) // set specific id to differentiate from other dropdowns
    container.appendChild(q) // append into the container to add the question element
  }
  if(event.target.id == 'btn_add_opt') {
    count++
    var new_opt = document.getElementById('radio_temp').cloneNode(true)
    var btn_parent = event.target.parentNode
    new_opt.id = 'radio_temp' + count
    new_opt.removeAttribute('hidden')
    btn_parent.appendChild(new_opt)
  }
  if(event.target.id == 'del_opt') {
    event.target.parentNode.remove()
  }
}
const form = document.querySelector('#assform');
const btn_save = document.getElementById('btn_save')
const btn_cancel = document.getElementById('btn_cancel')
//Save Form
btn_save.onclick = async function(event) {
  event.preventDefault()
  var q_count = 0
  const formQuestions = form.querySelectorAll('.question')
  var form_title = document.getElementById('form_title').value
  var form_desc = document.getElementById('form_desc').value
  var types = []
  var range = []
  var titles = []
  var choices = []
  let submission = {}
  formQuestions.forEach(element => {
    let selectType = element.childNodes[1].childNodes[1].childNodes[3].value
    let qTitle = element.childNodes[1].childNodes[1].childNodes[1].value
      //Short Answer
    if(selectType == 1) {
      types[q_count] = selectType
      range[q_count] = 0
      titles[q_count] = qTitle
      choices[q_count] = 0
    }
    //Long Answer
    if(selectType == 2) {
      types[q_count] = selectType
      range[q_count] = 0
      titles[q_count] = qTitle
      choices[q_count] = 0
    }
    //Linear Scale
    if(selectType == 3) {
      var qRange = "" + element.querySelector('#linear_first').value + "_" + element.querySelector('#linear_last').value
      var qChoice = element.querySelector('#ip_first').value + "_" + element.querySelector('#ip_last').value
      types[q_count] = selectType
      range[q_count] = qRange
      titles[q_count] = qTitle
      choices[q_count] = qChoice
    }
    //Multiple choice
    if(selectType == 4) {
      var mc_val = element.querySelectorAll('.mc_option')
      var mc_count = 0
      var mc_choices
      mc_val.forEach(element => {
        // console.log(element.childNodes[1].value)
        if(mc_count < 1) {
          mc_choices = element.childNodes[1].value
        } else {
          mc_choices += "~" + element.childNodes[1].value
        }
        mc_count++
      })
      types[q_count] = selectType
      range[q_count] = mc_count
      titles[q_count] = qTitle
      choices[q_count] = mc_choices
    }
    q_count++
  })
  // parse data
  for(var i = 0; i < q_count; i++) {
  if(i < 1) {
    // 1$2$3$4
    submission['question_types'] = types[i]
    submission['question_range'] = range[i]
    submission['question_titles'] = titles[i]
    submission['question_choices'] = choices[i]
  } else {
    submission['question_types'] += "$" + types[i]
    submission['question_range'] += "$" + range[i]
    submission['question_titles'] += "$" + titles[i]
    submission['question_choices'] += "$" + choices[i]
  }
  }
  submission['question_count'] = q_count
  submission['form_title'] = form_title
  submission['form_description'] = form_desc
  submission['id'] = code[1]
  console.log(submission)
  var {
  error, data
  } = await supabase.from('assessments').upsert([submission])
  location.href = 'admin_webinar-list.php'
}
btn_cancel.onclick = function() {
location.href = 'admin_webinar-list.php'
}

</script>
