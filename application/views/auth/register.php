<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: Arial, sans-serif;
		}

		body {
			background-color: #f0f4f8;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}

		.container {
			background-color: #ffffff;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 400px;
		}

		h2 {
			text-align: center;
			color: #333;
			margin-bottom: 1.5rem;
		}

		.flash-message {
			padding: 1rem;
			margin-bottom: 1rem;
			border-radius: 5px;
			text-align: center;
		}

		.flash-message.error {
			background-color: #f8d7da;
			color: #721c24;
		}

		.flash-message.success {
			background-color: #d4edda;
			color: #155724;
		}

		form {
			display: flex;
			flex-direction: column;
			gap: 1rem;
		}

		input {
			padding: 0.8rem;
			border: 1px solid #ccc;
			border-radius: 5px;
			font-size: 1rem;
			transition: border-color 0.3s;
		}

		input:focus {
			outline: none;
			border-color: #007bff;
			box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
		}

		button {
			padding: 0.8rem;
			background-color: #007bff;
			color: white;
			border: none;
			border-radius: 5px;
			font-size: 1rem;
			cursor: pointer;
			transition: background-color 0.3s;
		}

		button:hover {
			background-color: #0056b3;
		}

		.login-link {
			text-align: center;
			margin-top: 1rem;
			color: #555;
		}

		.login-link a {
			color: #007bff;
			text-decoration: none;
		}

		.login-link a:hover {
			text-decoration: underline;
		}

		@media (max-width: 500px) {
			.container {
				margin: 1rem;
				padding: 1.5rem;
			}
		}
	</style>
</head>

<body>
	<div class="container">
		<h2>Register</h2>
		<?php if ($this->session->flashdata('error')): ?>
			<div class="flash-message error"><?= $this->session->flashdata('error'); ?></div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('success')): ?>
			<div class="flash-message success"><?= $this->session->flashdata('success'); ?></div>
		<?php endif; ?>
		<form action="<?= base_url() ?>auth/store/" method="post">
			<input type="text" name="username" placeholder="Username" required>
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit">Register</button>
		</form>
		<p class="login-link">Sudah punya akun? <a href="<?= base_url() ?>auth/login">Login</a></p>
	</div>
</body>

</html>
