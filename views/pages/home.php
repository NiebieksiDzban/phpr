<?php
    require "config/database.php";
    $sql = "SELECT id FROM `test`";

    /**
     * @var $conn
     */

    $result = $conn->query($sql);

    foreach ($result as $row) {
        echo $row['id'] . " ";
    }

