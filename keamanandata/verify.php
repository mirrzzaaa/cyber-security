<?php
include 'config.php';
session_start();

if (!isset($_SESSION['pending_email'])) {
    header('Location: register.php');
    exit;
}

$email = $_SESSION['pending_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp_input = $_POST['otp'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND otp_code = ?");
    $stmt->execute([$email, $otp_input]);
    $user = $stmt->fetch();

    if ($user) {
        $pdo->prepare("UPDATE users SET is_verified = 1, otp_code = NULL WHERE email = ?")->execute([$email]);
        unset($_SESSION['pending_email']);
        header('Location: welcome.php');
        exit;
    } else {
        $error = "Kode OTP salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f9e6e7, #f7dede);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .verify-card {
            background: #fce7f0;
            padding: 50px 50px;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(234, 144, 154, 0.35);
            width: 420px;
            max-width: 90vw;
            text-align: center;
            border: 2px solid #f4b6c2;
        }

        .verify-card h2 {
            color: #d987a0;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 1.1px;
        }

        .verify-card input[type="text"] {
            width: 100%;
            padding: 16px 20px;
            margin-bottom: 22px;
            border: 2.5px solid #f4b6c2;
            border-radius: 10px;
            font-size: 16px;
            background: #ffeaf1;
            color: #a94f67;
            font-weight: 600;
            transition: border-color 0.3s ease;
        }

        .verify-card input[type="text"]:focus {
            outline: none;
            border-color: #d987a0;
            background: #ffdae4;
        }

        .verify-card button {
            width: 100%;
            padding: 16px;
            background-color: #d987a0;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 18px;
            font-weight: 800;
            cursor: pointer;
            transition: background-color 0.3s ease;
            letter-spacing: 1px;
        }

        .verify-card button:hover {
            background-color: #b15e70;
        }

        .verify-card p.error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .verify-card {
                padding: 40px 25px;
                width: 90%;
            }

            .verify-card h2 {
                font-size: 1.6rem;
            }

            .verify-card button {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="verify-card">
        <h2>Verifikasi OTP</h2>
        <?php if (!empty($error))
            echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <input type="text" name="otp" placeholder="Masukkan Kode OTP" required />
            <button type="submit">Verifikasi</button>
        </form>
    </div>
</body>

</html>