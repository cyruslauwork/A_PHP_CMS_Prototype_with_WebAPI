<?php
include('db_connection.php');

try {
    // Set the PDO error mode for throwing exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $title = $_POST['title'];
    $img_path = $_POST['img_path'];
    $theme_id = $_POST['theme_id'];

    if (isset($_POST["add"])) {
        // 1. Single insert
        $sql = "INSERT INTO index_content (title, img_path, theme_id) VALUES ('$title', '$img_path', '$theme_id')";
        // Using exec() , no results are returned
        $conn->exec($sql);

        // 2. Multiple insert
        // Begin
        // $conn->beginTransaction();
        // SQL statements
        // $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')");
        // $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Mary', 'Moe', 'mary@example.com')");
        // $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Julie', 'Dooley', 'julie@example.com')");

        echo "Record inserted successfully<br>";

    } elseif (isset($_POST["delete"])) {
        // sql to delete a record
        $stmt = $conn->prepare("DELETE FROM index_content WHERE theme_id=?");
        $stmt->execute([$theme_id]);

        echo "Record deleted successfully";
        
    } else die("data insufficient");
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
