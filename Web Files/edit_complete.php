<?php
include "bootstrap.php";
include "db_connect.php";
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
?>
<?php
$patronName = trim(addslashes($_GET["patronName"]));
$contactInfo = trim(addslashes($_GET["contactInfo"]));
$bookId = addslashes($_GET["submit"]);
$issueDate = addslashes($_GET["issueDate"]);
$dueDate = addslashes($_GET["dueDate"]);
?>
<body style="width: 100%; min-height: 100vh; display: -webkit-box; display: -webkit-flex; display: -moz-box; display: -ms-flexbox; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; padding: 15px; background: #F4CABC;">
    <div class="container text-center" style="width: 500px; background: #fff; border-radius: 10px; overflow: hidden; padding: 33px 55px 33px 55px; box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -o-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1); -ms-box-shadow: 0 5px 10px 0px rgba(0, 0, 0, 0.1);">

<?php
// search the database for the search parameter
echo "<h2>Edit Complete</h2>";
$sql = "UPDATE librarylog SET patronName = '$patronName', contactInfo = '$contactInfo', issueDate = '$issueDate', dueDate = '$dueDate' WHERE bookId = '$bookId'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));

?>
<button onclick="window.location.href='./library_log.php';" id="showlog" name="showlog" class="btn btn-orange">Show Log</button>
<button onclick="window.location.href='./index.php';" id="showlog" name="showlog" class="btn btn-orange">Return Home</button>
</div>
</body>
<?php
}
else {
  header("Location: login.php");
}
?>