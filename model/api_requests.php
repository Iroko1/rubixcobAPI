<?php
include "rubicoob_db.php";
[$success, $userID] = getUserByEmail($_SESSION['email'], $_SESSION['key']);
[$success, $data] = getRecordData($userID['UserID']);
if (!$success) {
    echo "<tr><td colspan='4'>No records found</td></tr>";
} else {
    foreach ($data as $record) {
        echo "<tr>";
        // echo "<td>{$record['RequestID']}</td>";
        echo "<td>{$record['DateRequested']}</td>";
        echo "<td>{$record['RequestData']}</td>";
        echo "<td><a href='./?action=deleteRecord&recordID={$record['RequestID']}'>Delete</a></td>";
        echo "</tr>";
    }
}

?>