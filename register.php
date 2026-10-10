<?php
session_start();

$errors = [];

$username = "";
$email = "";
$phone = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm-password"] ?? "";


    if ($username === "") {
        $errors["username"] = "Please enter your username.";
    } elseif (!preg_match("/^[a-zA-Z ]{6,}$/", $username)) {
        $errors["username"] =
            "Username must contain at least 6 characters.";
    }

    if ($email === "") {
        $errors["email"] = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    }

    if ($phone === "") {
        $errors["phone"] = "Please enter your phone number.";
    } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
        $errors["phone"] =
            "Phone number must contain exactly 11 digits.";
    }

    if ($password === "") {
        $errors["password"] = "Please enter your password.";
    } elseif (!preg_match("/^.{8,}$/s", $password)) {
        $errors["password"] =
            "Password must be at least 8 characters.";
    }

    if ($confirm_password === "") {
        $errors["confirm-password"] =
            "Please confirm your password.";
    } elseif ($password !== $confirm_password) {
        $errors["confirm-password"] =
            "Passwords do not match.";
    }

    if (empty($errors)) {

        $_SESSION["registered_user"] = [
            "username" => $username,
            "email" => $email,
            "phone" => $phone,
            "password" => password_hash(
                $password,
                PASSWORD_DEFAULT
            )
        ];

        header("Location: login.php?registered=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link rel="stylesheet" href="style1.css">
</head>

<body>

    <main class="register-container">

        <section class="register-box">

            <h1><em>Register</em></h1>

            <p class="description">
                Welcome! Register now to create your account and get started.
            </p>

            <form method="POST" action="register.php" novalidate>

                <div class="input-group">
                    <input type="text" id="username" name="username" placeholder="Username"
                        value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>">

                    <?php if (isset($errors["username"])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors["username"], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email Address"
                        value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">

                    <?php if (isset($errors["email"])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors["email"], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="tel" id="phone" name="phone" placeholder="Phone Number"
                        value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>">

                    <?php if (isset($errors["phone"])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors["phone"], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password">

                    <?php if (isset($errors["password"])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors["password"], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">

                    <?php if (isset($errors["confirm-password"])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors["confirm-password"], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>
                </div>

                <button type="submit">
                    Register
                </button>

                <p class="account-text">
                    Already have an account?
                    <a href="login.php">Login Here</a>
                </p>

            </form>

        </section>

    </main>

</body>

</html>