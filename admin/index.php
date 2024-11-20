<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

if (isset($_POST['email'])) {
    $query = 'SELECT *
        FROM users
        WHERE email = "' . $_POST['email'] . '"
        AND password = "' . md5($_POST['password']) . '"
        AND active = "Yes"
        LIMIT 1';
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result)) {
        $record = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $record['id'];
        $_SESSION['email'] = $record['email'];

        header('Location: dashboard.php');
        die();
    } else {
        set_message('Incorrect email and/or password');

        header('Location: index.php');
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
        <h2 class="text-center mb-4">Login to Event Management System</h2>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>