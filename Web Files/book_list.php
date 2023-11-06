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
<title>HTOR BLS - Book List</title>
</head>

  <div class="modal fade" id="reg-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100" id="modal-title">Confirm</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this item? Any associated entries of this item in the log will also be deleted. This action cannot be undone.</p>
          <form name='deleteform' class='text-center' id='deleteform' method='post'>
            <button id='delete' name='delete' class='btn btn-danger' value='idHolder'>Delete Item</button>
          </form>
        </form>
        </div>
      </div>
    </div>
  </div>

<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
    <div class="container text-center" style="width: 1200px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">
      <h1 class="text-center pb-2 display-4">Book List</h1>

  <button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange mb-3">Return Home</button>

  <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
  <thead>
    <tr>
      <th>Book ID</th>
      <th>Book Name</th>
      <th>Book Category</th>
      <th>Additional Notes</th>
      <th>Quick Tools</th>
    </tr>
  </thead>
  <tbody>
<?php
if(array_key_exists('delete', $_POST)) {
  $bookId = addslashes($_POST["delete"]);
  $sql = "DELETE FROM booklist WHERE bookId = '$bookId'";
  $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
  echo "<div class='alert alert-danger' role='alert'>Item <b>$bookId</b> Deleted from Book List</div>";
}

$sql = "SELECT bookId, bookName, bookCategory, additionalNotes FROM booklist";
$result = $mysqli->query($sql);

if(!empty($result)) {
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $bookId = $row['bookId'];
    echo "<tr><td>". $row["bookId"] ."</td><td>". $row["bookName"] ."</td><td>". $row["bookCategory"] ."</td><td>". $row["additionalNotes"] ."</td><td>". "
      <div class='btn-group' role='group'>

      <form action='book_id_tool.php'>
      <button id='bookId' name='bookId' class='btn btn-orange btn-sm' value='$bookId'><i class='bi bi-tools'></i></button>
      </form>

      &nbsp;

      <form action='edit_book.php'>
      <button id='edit' name='edit' class='btn btn-orange btn-sm' value='$bookId'><i class='bi bi-pencil-square'></i></button>
      </form>

      &nbsp;

      <button class='delete-click btn btn-danger btn-sm' data-id='$bookId' data-bs-toggle='modal' data-bs-target='#reg-modal'><i class='bi bi-trash-fill'></i></button>

      </div>" ."</td></tr>";
  }
}
}
echo "</tbody>";
echo "</table>";
echo "</div>";
?>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
$(document).on("click", ".delete-click", function () {
     var eventId = $(this).data('id');
     document.deleteform.delete.value = eventId;
});

$('#example').DataTable( {
  dom: 'Blfrtip',
  columnDefs: [
    { orderable: false, targets: 4 }
  ],
  order: [[1, 'asc']]
});
</script>
</body>

 <?php
}
else {
  header("Location: login.php");
}
?>