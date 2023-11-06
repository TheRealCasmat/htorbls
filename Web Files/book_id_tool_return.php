<?php
include "bootstrap.php";
include "db_connect.php";
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
?>

<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
    <div class="container text-center" style="width: 750px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">
<?php
$bookId = addslashes($_GET["return"]);

if(array_key_exists('confirm', $_POST)) {
  $sql = "SELECT patronName, contactInfo, bookId, issueDate, dueDate, fineAmount FROM librarylog WHERE bookId = '$bookId'";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
      $patronName = $row['patronName'];
      $contactInfo = $row['contactInfo'];
      $issueDate = $row['issueDate'];
      $dueDate = $row['dueDate'];
        $sql = "INSERT INTO libraryarchive (patronName, contactInfo, bookId, issueDate, dueDate, returnDate) VALUES ('$patronName', '$contactInfo', '$bookId', '$issueDate', '$dueDate', CURRENT_DATE)";
        $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
      	$sql = "DELETE FROM librarylog WHERE bookId = '$bookId'";
        $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
        echo "<h4>Item Returned</h4>";
      }
  }
else {

$sql = "SELECT fineAmount FROM librarylog WHERE bookId = '$bookId'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $fineCheck = $row["fineAmount"];
  }
  if($fineCheck > "0")
  {
  	echo "<h4>This Item Has a Outstanding Fine of: $$fineCheck Are You Sure You Want to Return This Item?</h4>";
  	echo "
    <form method='post'>
    <button id='confirm' name='confirm' class='btn btn-orange' value='yes'>Yes</button>
    </form>
  	";
  }
  else
  {
    $sql = "SELECT patronName, contactInfo, bookId, issueDate, dueDate, fineAmount FROM librarylog WHERE bookId = '$bookId'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $patronName = $row['patronName'];
      $contactInfo = $row['contactInfo'];
      $issueDate = $row['issueDate'];
      $dueDate = $row['dueDate'];
        $sql = "INSERT INTO libraryarchive (patronName, contactInfo, bookId, issueDate, dueDate, returnDate) VALUES ('$patronName', '$contactInfo', '$bookId', '$issueDate', '$dueDate', CURRENT_DATE)";
          $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
          $sql = "DELETE FROM librarylog WHERE bookId = '$bookId'";
          $result = $mysqli->query($sql) or die(mysqli_error($mysqli));
          echo "<h4>Item Returned</h4>";
    }
  }
} else {
  echo "<h4>Error: Item Doesn't Exist Anymore</h4>";
}
}
?>
<button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange">Return Home</button>
</div>
</body>
<?php
}
else {
  header("Location: login.php");
}
?>