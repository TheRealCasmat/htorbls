<?php
include "bootstrap.php";
include "db_connect.php";
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
?>
<title>HTOR BLS - New Book</title>
<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
    <div class="container text-center" style="width: 500px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">
<?php
$bookName = trim(addslashes($_GET["bookName"]));
$bookCategory = trim(addslashes($_GET["bookCategory"]));
$additionalNotes = trim(addslashes($_GET["additionalNotes"]));
$bookId = strtoupper(preg_replace('/\s+/', '', trim(addslashes($_GET["bookId"]))));

echo "<h2>Creating a new entry:</h2><br><h4>Book Name: $bookName<br>Book Category: $bookCategory<br>Additional Notes: $additionalNotes<br>Book ID: $bookId</h4>";
$sql = "INSERT INTO booklist (bookId, bookName, bookCategory, additionalNotes) VALUES ('$bookId', '$bookName', '$bookCategory', '$additionalNotes')";
	$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

?>
<button onclick="window.location.href='./book_list.php';" id="showlog" name="showlog" class="btn btn-orange">Show Book List</button>
<button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange">Return Home</button>
</div>
</body>
<?php
}
else {
  header("Location: login.php");
}
?>