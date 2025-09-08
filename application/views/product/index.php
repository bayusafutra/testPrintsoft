<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Produk</title>
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
				<li><a href="<?= base_url() ?>category">Kategori Produk</a></li>
				<li><a href="<?= base_url() ?>product" class="active">Produk</a></li>
				<li><a href="<?= base_url() ?>transaction">Transaksi</a></li>
			</ul>
		</div>

		<div class="content">
			<h2 class="mb-4">Produk</h2>

			<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('error')): ?>
				<div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
			<?php endif; ?>

			<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
				Tambah Produk
			</button>

			<table id="productTable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Kategori</th>
						<th>Jenis Formula</th>
						<th>Harga</th>
						<th>Satuan</th>
						<th>Deskripsi</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($products)): ?>
						<?php $no = 1; ?>
						<?php foreach ($products as $product): ?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $product['nama']; ?></td>
								<td><?= $product['kategori_nama'] ?></td>
								<td><?= $product['jenis_formula'] == 1 ? 'Unit' : 'Area'; ?></td>
								<td><?= $product['harga']; ?></td>
								<td><?= $product['satuan']; ?></td>
								<td><?= $product['deskripsi']; ?></td>
								<td>
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch"
											id="status_<?= $product['id']; ?>"
											<?= $product['status'] ? 'checked' : ''; ?>
											onclick="window.location.href='<?= base_url() ?>product/toggle_status/<?= $product['id']; ?>'">
									</div>
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal-<?= $product["id"] ?>">Edit
									</button>

									<a href="<?= base_url() ?>product/delete/<?= $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
										Hapus
									</a>
								</td>
								<div class="modal fade" id="editProductModal-<?= $product["id"] ?>" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<form action="<?= base_url() ?>product/edit/<?= $product['id']; ?>" method="post">
												<div class="modal-body">
													<div class="mb-3">
														<label for="edit_kategori_id" class="form-label">Kategori</label>
														<select class="form-select" id="edit_kategori_id" name="kategori_id" required>
															<option value="">Pilih Kategori</option>
															<?php foreach ($categories as $category): ?>
																<option value="<?= $category['id']; ?>"
																	<?= ($category['id'] == $product['kategori_id']) ? 'selected' : ''; ?>>
																	<?= $category['nama']; ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
													<div class="mb-3">
														<label for="edit_nama" class="form-label">Nama Produk</label>
														<input type="text" class="form-control" id="edit_nama" name="nama" value="<?= $product['nama']; ?>" required>
													</div>
													<div class="mb-3">
														<label for="jenis_formula" class="form-label">Jenis Formula</label>
														<select class="form-select" id="jenis_formula" name="jenis_formula" required>
															<option value="1" <?= ($product["jenis_formula"] == 1) ? 'selected' : '' ?>>Unit</option>
															<option value="2" <?= ($product["jenis_formula"] != 1) ? 'selected' : '' ?>>Area</option>
														</select>
													</div>
													<div class="mb-3">
														<label for="edit_harga" class="form-label">Harga</label>
														<input type="number" class="form-control" id="harga" name="harga" value="<?= $product['harga']; ?>" required>
													</div>
													<div class="mb-3">
														<label for="edit_satuan" class="form-label">Satuan</label>
														<input type="text" class="form-control" id="satuan" name="satuan" value="<?= $product['satuan']; ?>" required>
													</div>
													<div class="mb-3">
														<label for="edit_deskripsi" class="form-label">Deskripsi</label>
														<textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="5" col="10"><?= $product['deskripsi']; ?></textarea>
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
							<td colspan="6" class="text-center">Tidak ada data produk.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="<?= base_url() ?>product/add" method="post">
					<div class="modal-body">
						<div class="mb-3">
							<label for="kategori_id" class="form-label">Kategori</label>
							<select class="form-select" id="kategori_id" name="kategori_id" required>
								<option value="">Pilih Kategori</option>
								<?php foreach ($categories as $category): ?>
									<option value="<?= $category['id']; ?>"><?= $category['nama']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="mb-3">
							<label for="nama" class="form-label">Nama Produk</label>
							<input type="text" class="form-control" id="nama" name="nama" required>
						</div>
						<div class="mb-3">
							<label for="jenis_formula" class="form-label">Jenis Formula</label>
							<select class="form-select" id="jenis_formula" name="jenis_formula" required>
								<option value="">Pilih Jenis Formula</option>
								<option value="1">Unit</option>
								<option value="2">Area</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="harga" class="form-label">Harga</label>
							<input type="number" class="form-control" id="harga" name="harga" required>
						</div>
						<div class="mb-3">
							<label for="satuan" class="form-label">Satuan</label>
							<input type="text" class="form-control" id="satuan" name="satuan" required>
						</div>
						<div class="mb-3">
							<label for="deskripsi" class="form-label">Deskripsi</label>
							<textarea name="deskripsi" class="form-control" id="deskripsi" rows="5" col="10"></textarea>
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
	<script>
		document.querySelector('.hamburger').addEventListener('click', function() {
			document.querySelector('.sidebar').classList.toggle('active');
		});
	</script>
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
