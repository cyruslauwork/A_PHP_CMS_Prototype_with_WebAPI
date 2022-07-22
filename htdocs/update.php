<?php session_start();?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>CMS</title>
</head>

<body>

    <?php
    require('db_connection.php');

    $title = $img_path = $theme_id = "";

    try {
        // Set the PDO error mode for throwing exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['administrator'] == "true") {
            if ($_POST['title'] && $_POST['img_path'] && $_POST['theme_id']) {
                $title = test_input($_POST['title']);
                $img_path = test_input($_POST['img_path']);
                $theme_id = test_input($_POST['theme_id']);

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
            } elseif ($_POST['theme_id']) {
                $theme_id = test_input($_POST['theme_id']);

                // sql to delete a record
                $stmt = $conn->prepare("DELETE FROM index_content WHERE theme_id=?");
                $stmt->execute([$theme_id]);

                echo "Record deleted successfully<br>";
            } else {
                echo "A section is missing required value(s)<br>";
            }
        } elseif ($_SESSION['administrator'] == "true") {
            echo "Administrator privileges granted<br>";
        } else {
            echo "Administrator privileges required<br>";
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    function test_input($data)
    {
        // $data = trim($data);
        // $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $conn = null;
    ?>

    <h2>Add</h2>
    <p>Insert new content into MySQL database</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Title: <input type="text" name="title" value="<?php echo $title; ?>">
        Image Path: <input type="text" name="img_path" value="<?php echo $img_path; ?>">
        Theme ID: <input type="text" name="theme_id" value="<?php echo $theme_id; ?>">
        <input type="submit" name="submit" value="Submit">
    </form>

    <hr>
    <h2>Delete</h2>
    <p>Remove all content from the Theme ID</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Theme ID: <input type="text" name="theme_id" value="<?php echo $theme_id; ?>">
        <input type="submit" name="submit" value="Submit">
    </form>

</body>

</html>