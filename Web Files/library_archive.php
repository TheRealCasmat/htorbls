<?php
include "db_connect.php";
include "bootstrap.php";
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
$sql = "UPDATE librarylog SET fineAmount = CEIL(GREATEST(DATEDIFF(CURRENT_DATE, `dueDate`), 0)/7)*0.25";
$result = $mysqli->query($sql);
?>
<head>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<title>HTOR BLS - Library Archive</title>
</head>
<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
	  <div class="container text-center" style="width: 1200px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">
	  	<h1 class="text-center display-4">Library Archive</h1>
      <small class='text-muted pb-2'>Note: Entries are deleted 6 Months after their return date.</small>
      <br>
      <br>

	<button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange mb-3">Return Home</button>

	<table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
	<thead>
		<tr>
			<th>Patron Name</th>
			<th>Contact Info</th>
			<th>Book ID</th>
			<th>Issue Date</th>
			<th>Due Date</th>
			<th>Return Date</th>
			<th>Quick Tools</th>
		</tr>
	</thead>
	<tbody>
<?php
if(array_key_exists('delete', $_POST)) {
	$bookId = addslashes($_POST["delete"]);
	$sql = "DELETE FROM libraryarchive WHERE bookId = '$bookId'";
  $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
  echo "<div class='alert alert-danger' role='alert'>Item <b>$bookId</b> Deleted from Archive</div>";
}
elseif (array_key_exists('add', $_POST)) {
  $bookId = addslashes($_POST["add"]);
  $sql = "SELECT patronName, contactInfo, issueDate, dueDate FROM libraryarchive WHERE bookId = '$bookId'";
  $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $patronName = $row['patronName'];
    $contactInfo = $row['contactInfo'];
    $issueDate = $row['issueDate'];
    $dueDate = $row['dueDate'];
    $sql = "INSERT INTO librarylog (patronName, contactInfo, bookId, issueDate, dueDate, fineAmount) VALUES ('$patronName', '$contactInfo', '$bookId', '$issueDate', '$dueDate', '0.00')";
    $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
    $sql = "DELETE FROM libraryarchive WHERE bookId = '$bookId'";
    $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
    echo "<div class='alert alert-success' role='alert'>Item <b>$bookId</b> Added to Log</div>";
  }
}

$sql = "SELECT patronName, contactInfo, bookId, issueDate, dueDate, returnDate FROM libraryarchive";
$result = $mysqli->query($sql);

if(!empty($result)) {
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $bookId = $row["bookId"];
    echo "<tr><td>". $row["patronName"] ."</td><td>". $row["contactInfo"] ."</td><td>". $bookId ."</td><td>". $row["issueDate"] ."</td><td>". $row["dueDate"] ."</td><td>". $row["returnDate"] ."</td><td>". "
    	<div class='btn-group' role='group'>

      <form method='post'>
    	<button id='add' name='add' class='btn btn-success btn-sm' value='$bookId'><i class='bi bi-plus-circle-fill'></i></button>
			</form>

			&nbsp;

      <form method='post'>
      <button id='delete' name='delete' class='btn btn-danger btn-sm' value='$bookId'><i class='bi bi-trash-fill'></i></button>
      </form>

      </div>" ."</td></tr>";
  }
}
}
echo "</tbody>";
echo "</table>";
?>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
$('#example').DataTable( {
  columnDefs: [
    { orderable: false, targets: 6 }
  ],
  order: [[1, 'asc']]
} );
</script>
</body>

 <?php
}
else {
  header("Location: login.php");
}
?>