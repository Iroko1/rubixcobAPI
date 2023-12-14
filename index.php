<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubi coob API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>

<?php
// get login status
session_start();
if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn']) {
        include "view/loggedInNav.php";
    } else {
        include "view/nav.php";
    }
} else {
    include "view/nav.php";
    $loggedIn = false;
}
?>

<div class="container">
    <?php
    // get page content
    $action = filter_input(INPUT_GET, 'action');
    switch ($action) {
        case 'about':
            include "view/about.php";
            break;
        case 'login':
            if (isset($_SESSION['loggedIn'])) {
                if ($_SESSION['loggedIn']) {
                    echo "<h2>Already logged in!</h2>";
                    echo "<p><a href='./'>Home</a></p>";
                    exit();
                }
            }
            if (isset($_POST['email']) && isset($_POST['key'])) {
                include "model/apiKey.php";
                include "model/rubicoob_db.php";
                $email = filter_input(INPUT_POST, 'email');
                $key = filter_input(INPUT_POST, 'key');
                if (validateUser($email, $key)) {
                    include "view/loginSuccess.php";
                    $_SESSION['email'] = $email;
                    $_SESSION['key'] = $key;
                    $_SESSION['loggedIn'] = true;
                    exit();
                } else {
                    include "view/loginFail.php";
                    exit();
                }
            } else {
                include "view/login.php";
            }
            break;

        case 'logOut':
            include "model/rubicoob_db.php";
            destroySession();
            break;
        case 'register':
            if (isset($_POST['email'])) {
                include "model/apiKey.php";
                include "model/rubicoob_db.php";
                $email = filter_input(INPUT_POST, 'email');
                $key = generateApiKey($email);
                [$success, $error] = registerUser($email, $key);
                if ($success) {
                    include "view/registerSuccess.php";
                    exit();
                } else {
                    include "view/registerFail.php";
                    exit();
                }
            } else {
                include "view/register.php";
            
            }
            break;

        case 'API':
            if (isset($_SESSION['loggedIn'])) {
                if ($_SESSION['loggedIn']) {
                    include "view/API.php";
                    break;
                }
            }
            break;

        case "deleteRecord":
            if (isset($_SESSION['loggedIn'])) {
                if ($_SESSION['loggedIn']) {
                    $RequestID = filter_input(INPUT_GET, 'recordID');
                    include "model/rubicoob_db.php";
                    [$success, $error] = deleteRecord($RequestID);
                    if ($success) {
                        include "view/deleteSuccess.php";
                        exit();
                    } else {
                        include "view/deleteFail.php";
                        exit();
                    }
                }
            }
            break;
        default:
            include "view/home.php";
            break;
    }


    ?>


</div>

<?php include "view/footer.php"; ?>


</body>
</html>