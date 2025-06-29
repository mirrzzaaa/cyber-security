<?php include 'config.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999);


    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, otp_code) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $otp]);


    sendOTP($email, $otp);


    session_start();
    $_SESSION['pending_email'] = $email;

    header('Location: verify.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f9e6e7, #f7dede);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background: #fce7f0;
            /* soft pastel pink */
            padding: 50px 50px;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(234, 144, 154, 0.35);
            width: 420px;
            max-width: 90vw;
            text-align: center;
            border: 2px solid #f4b6c2;
            transition: box-shadow 0.3s ease;
        }

        .register-card:hover {
            box-shadow: 0 18px 50px rgba(234, 144, 154, 0.55);
        }

        .register-card h2 {
            color: #d987a0;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2.2rem;
            letter-spacing: 1.2px;
        }

        .register-card input[type="text"],
        .register-card input[type="email"],
        .register-card input[type="password"] {
            width: 100%;
            padding: 18px 22px;
            margin-bottom: 22px;
            border: 2.5px solid #f4b6c2;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background: #ffeaf1;
            color: #a94f67;
            font-weight: 600;
        }

        .register-card input[type="text"]:focus,
        .register-card input[type="email"]:focus,
        .register-card input[type="password"]:focus {
            outline: none;
            border-color: #d987a0;
            background: #ffdae4;
        }

        .register-card button {
            width: 100%;
            padding: 18px;
            background-color: #d987a0;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 18px;
            font-weight: 800;
            cursor: pointer;
            transition: background-color 0.3s ease;
            letter-spacing: 1.1px;
        }

        .register-card button:hover {
            background-color: #b15e70;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-card {
                width: 90%;
                padding: 40px 25px;
            }

            .register-card h2 {
                font-size: 1.8rem;
            }

            .register-card input[type="text"],
            .register-card input[type="email"],
            .register-card input[type="password"] {
                font-size: 14px;
                padding: 16px 18px;
            }

            .register-card button {
                font-size: 16px;
                padding: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="register-card">
        <h2>Register</h2>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Nama" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Daftar</button>
        </form>
    </div>

</body>

</html>