<?php
session_start();

if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'Customer') {
    header('Location: Login_page.php');
    exit();
}

$name = $_SESSION['username'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$address = $_SESSION['address'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Dashboard</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Leckerli+One&family=Poppins:wght@100;400;600&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(-45deg, #a7cec8, #1daa5f, #88d9b3, #68b684);
            background-size: 400% 400%;
            animation: gradientFlow 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .dashboard-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            background: #ffffffd9;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .sidebar {
            width: 260px;
            background-color: #165c38;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            color: #fff;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            font-family: 'Leckerli One', cursive;
            text-align: center;
        }

        .nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .nav-links li button {
            background: none;
            border: none;
            color: #ffffffcc;
            font-size: 16px;
            text-align: left;
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .nav-links li button i {
            margin-right: 10px;
        }

        .nav-links li button:hover {
            background: #117a4f;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .overview h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #117a4f;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
            color: #333;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .nav-links {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 10px;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">💼 Dashboard</div>
            <ul class="nav-links">
                <li><button><i class="fa-regular fa-user"></i> Edit Profile</button></li>
                <li><button><i class="fa-solid fa-ticket"></i> Balance Check</button></li>
                <li><button><i class="fa-solid fa-money-bill-transfer"></i> Fund Transfer</button></li>
                <li><button onclick="window.location.href='Customer_Transaction_History.php'"><i class="fa-solid fa-clock-rotate-left"></i> Transaction Report</button></li>
                <li><button onclick="window.location.href='logout.php'"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</button></li>
                <li><button><i class="fa-solid fa-circle-info"></i> Help</button></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <section class="overview">
                <h2>Welcome, <span><?= htmlspecialchars($name) ?></span> 👋</h2>
                <div class="info">
                    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($address) ?></p>
                </div>
            </section>
        </main>
    </div>
</body>

</h