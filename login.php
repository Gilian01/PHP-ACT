<?php
session_start();


if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['locked_until'])) {
    $_SESSION['locked_until'] = 0;
}

$errors = [];
$message = "";
$messageClass = "";

$username = "";
$remaining = 0;


$correctUsername = "admin";
$correctPassword = "12345";


if (time() >= $_SESSION['locked_until']) {
    if ($_SESSION['locked_until'] != 0) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['locked_until'] = 0;
    }
}

$locked = time() < $_SESSION['locked_until'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($locked) {
        $remaining = $_SESSION['locked_until'] - time();
        $message = "Too many failed attempts. Try again in "
            . $remaining . " seconds.";
        $messageClass = "error-message";

    } else {

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === "") {
            $errors['username'] = "Please enter your username.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errors['username'] =
                "Username must be  characters using letters.";
        }

        if ($password === "") {
            $errors['password'] = "Please enter your password.";
        } elseif (!preg_match('/^.{5,}$/s', $password)) {
            $errors['password'] =
                "Password must be at least 5 characters.";
        }

        if (empty($errors)) {

            if (
                $username === $correctUsername &&
                $password === $correctPassword
            ) {

                $_SESSION['login_attempts'] = 0;
                $_SESSION['locked_until'] = 0;

                session_regenerate_id(true);

                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;

                header("Location: index.php");
                exit();

            } else {

                $_SESSION['login_attempts']++;

                if ($_SESSION['login_attempts'] >= 3) {

                    $_SESSION['locked_until'] = time() + 10;

                    $remaining = 10;
                    $message =
                        "Too many failed attempts. Try again in 10 seconds.";
                    $messageClass = "error-message";

                } else {

                    $remaining =
                        3 - $_SESSION['login_attempts'];

                    $message =
                        "Incorrect username or password. "
                        . $remaining
                        . " attempt(s) remaining.";

                    $messageClass = "error-message";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style1.css">
</head>

<body>

    <main class="login-container">

        <section class="login-box">

            <h1><em>Login</em></h1>

            <p class="description">
                Explore some more in The Uncanny Counter Series
            </p>

            <form id="loginForm" method="POST" action="login.php" novalidate>

                <div class="input-group">

                    <input type="text" id="username" name="username" placeholder="Username"
                        value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" autocomplete="username"
                        <?= $locked ? 'disabled' : '' ?>>

                    <?php if (isset($errors['username'])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>

                </div>

                <div class="input-group">

                    <input type="password" id="password" name="password" placeholder="Password"
                        autocomplete="current-password" <?= $locked ? 'disabled' : '' ?>>

                    <?php if (isset($errors['password'])): ?>
                        <label class="error">
                            <?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?>
                        </label>
                    <?php endif; ?>

                </div>

                <div class="save">

                    <label>
                        <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>
                            <?= $locked ? 'disabled' : '' ?>>

                        Remember me
                    </label>

                    <span>Forgot password?</span>

                </div>

                <button type="submit" id="login-button" <?= $locked ? 'disabled' : '' ?>>

                    Login

                </button>

                <?php if ($message !== ""): ?>
                    <p class="<?= htmlspecialchars($messageClass, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

                <p class="account-text">
                    Don't have an account?
                    <a href="register.php">Register</a>
                </p>

            </form>

        </section>

    </main>