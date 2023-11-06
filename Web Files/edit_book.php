<?php
include "bootstrap.php";
include "db_connect.php";
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
?>
<title>HTOR BLS - Edit Book</title>
<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
    <div class="container text-center" style="width: 750px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">
    <h1 class="text-center pb-2 display-4">Edit Book</h1>
    <h6 class="text-center text-muted">Note: To change Book ID, you must delete the item and create a new record.</h6>
<?php
$bookId = addslashes($_GET["edit"]);

$sql = "SELECT bookName, bookCategory, additionalNotes FROM booklist WHERE bookId = '$bookId'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  	$bookName = $row["bookName"];
  	$bookCategory = $row["bookCategory"];
  	$additionalNotes = $row["additionalNotes"];
  }
  echo "

<form class='form-horizontal text-start needs-validation' action='book_edit_complete.php' novalidate>

<div class='form-floating mb-3'>
  <input id='bookName' name='bookName' type='text' placeholder='Enter Book Name' class='form-control input-md' required='' value='$bookName'>
  <label for='bookName'>Book Name</label>
</div>

<div class='form-floating mb-3'>
  <input id='bookCategory' name='bookCategory' type='text' placeholder='Book Category' class='form-control input-md' value='$bookCategory'>
  <small class='text-muted'>Optional</small>
  <label for='bookCategory'>Book Category</label>
</div>

<div class='form-floating mb-3'>
  <input id='additionalNotes' name='additionalNotes' type='text' placeholder='Additional Notes' class='form-control input-md' value='$additionalNotes'>
  <small class='text-muted'>Optional</small>
  <label for='additionalNotes'>Additional Notes</label>
</div>

<div class='form-group'>
  <button id='submit' name='submit' class='btn btn-orange' value='$bookId'>Edit</button>
</div>

</form>";

} else {
  echo "<h4>Does Not Exist</h4>";
}
?>
<hr>
<button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange">Return Home</button>

</div>

<script type="text/javascript">
  // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
</body>
<?php
}
else {
  header("Location: login.php");
}
?>