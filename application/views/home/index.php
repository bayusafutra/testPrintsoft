<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f4f8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar .user-info span {
            font-size: 1rem;
        }

        .navbar .logout-btn {
            background-color: #ff4d4d;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .navbar .logout-btn:hover {
            background-color: #cc0000;
        }

        .navbar .hamburger {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 1.5rem;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 60px);
            position: fixed;
            top: 64px;
        }

        .sidebar h3 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 1rem;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 1rem;
            display: block;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #e6f0fa;
            color: #007bff;
        }

		.sidebar ul li a.active {
			background-color: #007bff;
			color: white;
		}

        .content {
            margin-left: 250px;
            padding: 2rem;
            flex: 1;
        }

        .content h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .flash-message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
            max-width: 600px;
        }

        .flash-message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .flash-message.success {
            background-color: #d4edda;
            color: #155724;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .navbar .hamburger {
                display: block;
            }
        }

        @media (max-width: 500px) {
            .content {
                padding: 1rem;
            }

            .sidebar {
                width: 100%;
                top: 60px;
                height: calc(100vh - 60px);
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="brand">Test PrintSoft</div>
        <div class="user-info">
            <span><?= $this->session->userdata('username'); ?></span>
            <button class="logout-btn" onclick="window.location.href='<?= base_url() ?>auth/logout'">Logout</button>
            <div class="hamburger">☰</div>
        </div>
    </div>

    <div class="wrapper">
        <div class="sidebar">
            <h3>Menu</h3>
            <ul>
                <li><a href="<?= base_url() ?>home" class="active">Home</a></li>
                <li><a href="<?= base_url() ?>category">Kategori Produk</a></li>
                <li><a href="<?= base_url() ?>product">Produk</a></li>
                <li><a href="<?= base_url() ?>transaction">Transaksi</a></li>
            </ul>
        </div>

        <div class="content">
            <h2>Dashboard</h2>
            <p>Selamat datang <?= $this->session->userdata('username'); ?> di halaman utama website ini.</p>
        </div>
    </div>

    <script>
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
