<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kategori Produk</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
			top: 60px;
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

		.form-switch .form-check-input {
			cursor: pointer;
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
		<div class="brand">MyApp</div>
		<div class="user-info">
			<span>Selamat datang, <?= $this->session->userdata('username'); ?>!</span>
			<button class="logout-btn" onclick="window.location.href='<?= base_url() ?>auth/logout'">Logout</button>
			<div class="hamburger">☰</div>
		</div>
	</div>

	<div class="wrapper">
		<div class="sidebar">
			<h3>Menu</h3>
			<ul>
				<li><a href="<?= base_url() ?>home">Dashboard</a></li>
				<li><a href="<?= base_url() ?>category" class="active">Kategori Produk</a></li>
				<li><a href="<?= base_url() ?>product">Produk</a></li>
				<li><a href="<?= base_url() ?>transaction">Transaksi</a></li>
			</ul>
		</div>

		<div class="content">
			<h2 class="mb-4">Kategori Produk</h2>

			<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('error')): ?>
				<div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
			<?php endif; ?>

			<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
				Tambah Kategori
			</button>

			<table id="productTable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($categories)): ?>
						<?php $no = 1; ?>
						<?php foreach ($categories as $category): ?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $category['nama']; ?></td>
								<td>
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch"
											id="status_<?= $category['id']; ?>"
											<?= $category['status'] ? 'checked' : ''; ?>
											onclick="window.location.href='<?= base_url() ?>category/toggle_status/<?= $category['id']; ?>'">
									</div>
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal-<?= $category["id"] ?>"
										data-id="<?= $category['id']; ?>" data-nama="<?= $category['nama']; ?>">
										Edit
									</button>
									<a href="<?= base_url() ?>category/delete/<?= $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
										Hapus
									</a>
								</td>
								<div class="modal fade" id="editCategoryModal-<?= $category["id"] ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<form action="<?= base_url() ?>category/edit/<?= $category['id']; ?>" method="post">
												<div class="modal-body">
													<div class="mb-3">
														<label for="edit_nama" class="form-label">Nama Kategori</label>
														<input type="text" class="form-control" id="edit_nama" name="nama" value="<?= $category['nama']; ?>" required>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
													<button type="submit" class="btn btn-primary">Update</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="4" class="text-center">Tidak ada data kategori.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="<?= base_url() ?>category/add" method="post">
					<div class="modal-body">
						<div class="mb-3">
							<label for="nama" class="form-label">Nama Kategori</label>
							<input type="text" class="form-control" id="nama" name="nama" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#productTable').DataTable({
				responsive: true,
				autoWidth: false,
				language: {
					url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
				}
			});
		});
	</script>
</body>

</html>
