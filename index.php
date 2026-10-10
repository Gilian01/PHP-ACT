<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity 1</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-image: url("image/images (2).jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-top: 50px;
            text-align: center;
        }

        hr {
            width: 60%;
            height: 5px;
            margin: 20px auto;
            background-color: #f6e4aa;
            border: none;
        }

        p {
            text-align: center;
            margin: auto;
        }

        .intro-1 {
            line-height: 1.25;
            padding-bottom: 45px;
        }

        .intro-2 {
            line-height: 1.25;
            padding-bottom: 25px;
        }

        .hobbies-1 {
            display: table;
            margin: 0 auto;
        }

        .hobbies-1 p {
            color: blueviolet;
        }

        .name {
            padding-top: 20px;
        }

        .quote-1 {
            text-align: center;
            padding-top: 15px;
        }

        figure {
            text-align: center;
            font-size: medium;
        }

        .footer-1 {
            text-align: center;
        }

        a {
            color: black;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <?php include 'main.php'; ?>

    <?php include 'footer.php'; ?>

</body>
</html>