<?php
include "rubicoob_db.php";
[$success, $userID] = getUserByEmail($_SESSION['email'], $_SESSION['key']);
[$success, $data] = getRecordData($userID['UserID']);
foreach ($data as $record) {
    echo "<tr>";
    echo "<td>{$record['RequestID']}</td>";
    echo "<td>{$record['DateRequested']}</td>";
    echo "<td>{$record['RequestData']}</td>";
    echo "<td><a href='./?action=deleteRecord&recordID={$record['RequestID']}'>Delete</a></td>";
    echo "</tr>";
}

?>