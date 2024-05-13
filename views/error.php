<?php

session_start();


if (isset($_GET['message'])) {

    $msgDiplay = "";
    switch ($_GET['message']) {
        case 'url_error':
            $msgDiplay = "It seems you have a problem with URL";
            break;
        case 'emp_id_error':
            $msgDiplay = "Employee ID missing";
            break;
        case 'pro_id_error':
            $msgDiplay = "Proctor ID missing";
            break;
        case 'training_id_error':
            $msgDiplay = "Training ID missing";
            break;
        case 'user_id_error':
            $msgDiplay = "User ID missing";
            break;

        default:
            # code...
            break;
    }
} else {
    return "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>

<body style="height: 100vh;">
    <div class="container text-center w-100 h-100 d-flex align-items-center justify-content-center flex-column">
        <h1> <?= $msgDiplay; ?> </h1>
        <a href="../dashboard.php">Back to dashboard</a>
    </div>

</body>

</html>