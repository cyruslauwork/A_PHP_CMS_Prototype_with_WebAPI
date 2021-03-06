<?php session_start(); ?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>Member</title>
</head>

<body>
    <?php
    require('db_connection.php');

    $username_signin = $password_signin = $username_signup = $password_signup = $admin_signup = "";

    try {
        // Set the PDO error mode for throwing exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['username_signin'] && $_POST['password_signin']) {
                $username_signin = test_input($_POST['username_signin']);
                $password_signin = md5(test_input($_POST['password_signin']));

                // sql to delete a record
                $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
                $stmt->execute([$username_signin]);
                $user = $stmt->fetch();

                if ($user && $password_signin == $user['pw']) {
                    echo "Successfully logged in<br>";
                    sleep(3);

                    if ($user['administrator'] == "true") {
                        $_SESSION['administrator'] = "true";

                        header("Location: /update.php");
                        exit;
                    } else {
                        header("Location: /index.php");
                        exit;
                    }
                } else {
                    echo "Password does not match<br>";
                }
            } elseif ($_POST['username_signup'] && $_POST['password_signup'] && $_POST['admin_signup']) {
                $username_signup = test_input($_POST['username_signup']);
                $password_signup = md5(test_input($_POST['password_signup']));
                $admin_signup = test_input($_POST['admin_signup']);

                // [!]
                // A username check must be added here 
                //...

                $sql = "INSERT INTO user (username, pw, administrator) VALUES ('$username_signup', '$password_signup', '$admin_signup')";
                // Using exec() , no results are returned
                $conn->exec($sql);

                echo "Successfully registered<br>";
                sleep(3);

                $_SESSION['administrator'] = "true";

                header("Location: /update.php");
                exit;
            } else {
                echo "A section is missing required value(s)<br>";
            }
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

    <h2>Sign In</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username_signin" value="">
        Password: <input type="text" name="password_signin" value="">
        <input type="submit" name="submit" value="Submit">
    </form>

    <hr>
    <h2>Sign Up</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username_signup" value="">
        Password: <input type="text" name="password_signup" value="">
        Admin:
        <input type="radio" id="admin" name="admin_signup" value="true">
        <label for="admin">True</label>
        <input type="radio" id="admin" name="admin_signup" value="false" checked>
        <label for="admin">False</label>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>