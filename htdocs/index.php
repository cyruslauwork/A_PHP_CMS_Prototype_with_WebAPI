<!DOCTYPE html>
<html>

<body>
    <?php
    include('db_connection.php');

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = $conn->query("SELECT * FROM index_content")->fetchAll();

        $WebAPI = intval($_GET['WebAPI']); // echo parameter from URL, e.g. .../index.php?WebAPI=1

        if ($WebAPI == 1) {
            foreach ($data as $row => $el) {
                // echo $row['title'] . ',' . $row['img_path'] . ',' . $row['theme_id'] . ',';

                echo $el['title'] . ',' . $el['img_path'] . ',' . $el['theme_id'];
                if ($row !== array_key_last($data)) { echo ','; }
            }
        } elseif ($WebAPI == 0) {
            foreach ($data as $row) {
                echo '<table cellspacing="5" cellpadding="5">';
                echo '<tr>
                        <td>Title</td>
                        <td>Image Path</td>
                        <td>Theme ID</td>
                        <tr>';
                echo '<tr> 
                        <td>' . $row['title'] . '</td>
                        <td>' . $row['img_path'] . '</td>
                        <td>' . $row['theme_id'] . '</td>
                        </tr>';
                echo '</table><hr>';
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
</body>

</html>