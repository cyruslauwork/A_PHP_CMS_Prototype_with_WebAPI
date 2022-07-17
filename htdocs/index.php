<?php
    include('db_connection.php');

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = $conn->query("SELECT * FROM index_content")->fetchAll();

        $WebAPI = intval($_GET['WebAPI']); // echo parameter from URL, e.g. .../index.php?WebAPI=1 or .../index.php?WebAPI=0

        if ($WebAPI == 2) {
            // Method 1 – Array
            $arr;
            foreach ($data as $row => $el) {
                // 1.1 – To be converted into an string array by Swift/Java
                // echo $el['title'] . ',' . $el['img_path'] . ',' . $el['theme_id'];
                // if ($row !== array_key_last($data)) {
                //     echo ',';
                // }
                // 1.1.1 – Get data in Swift:
                // HTTPRequest...
                // let responseData = Array(String(data:receivedData, encoding:String.Encoding.utf8)!)
                // responseData[0]...

                // 1.2 – Converted into an string array
                if ($row === array_key_first($data)) {
                    $arr = '[';
                }
                $arr = $arr . '"' . $el['title'] . '","' . $el['img_path'] . '","' . $el['theme_id'] . '"';
                if ($row !== array_key_last($data)) {
                    $arr = $arr . ',';
                } else {
                    $arr = $arr . ']';
                }
            }
            // 1.2.1
            echo $arr;
        } elseif ($WebAPI == 1) {
            // Method 2 – JSON
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
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
