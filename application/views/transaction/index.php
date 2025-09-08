<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
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
                <li><a href="<?= base_url() ?>product">Produk</a></li>
                <li><a href="<?= base_url() ?>transaction" class="active">Transaksi</a></li>
            </ul>
        </div>

        <div class="content">
            <h2 class="mb-4">Transaksi</h2>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                Tambah Transaksi
            </button>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Unit</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($transaction['tgltransaksi'])); ?></td>
                                <td><?= $transaction['totalunit']; ?></td>
                                <td>Rp <?= number_format($transaction['totalharga'], 2, ',', '.'); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailTransactionModal" 
                                        data-transaction-id="<?= $transaction['id']; ?>">
                                        Detail
                                    </button>
                                    <a href="<?= base_url() ?>transaction/delete/<?= $transaction['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data transaksi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url() ?>transaction/add" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tgltransaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="tgltransaksi" name="tgltransaksi" required>
                        </div>
                        <div class="mb-3">
                            <h6>Detail Produk</h6>
                            <div id="product-items">
                                <div class="product-item mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Produk</label>
                                            <select class="form-select product-select" name="products[]" required>
                                                <option value="">Pilih Produk</option>
                                                <?php foreach ($products as $product): ?>
                                                    <option value="<?= $product['id']; ?>" 
                                                        data-jenis-formula="<?= $product['jenis_formula']; ?>" 
                                                        data-harga="<?= $product['harga']; ?>">
                                                        <?= $product['nama']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 qty-field">
                                            <label class="form-label">Qty</label>
                                            <input type="number" class="form-control" name="quantities[]" min="1" required>
                                        </div>
                                        <div class="col-md-2 panjang-field" style="display: none;">
                                            <label class="form-label">Panjang</label>
                                            <input type="number" step="0.01" class="form-control" name="panjangs[]">
                                        </div>
                                        <div class="col-md-2 lebar-field" style="display: none;">
                                            <label class="form-label">Lebar</label>
                                            <input type="number" step="0.01" class="form-control" name="lebars[]">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-product-item">Tambah Produk</button>
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

    <div class="modal fade" id="detailTransactionModal" tabindex="-1" aria-labelledby="detailTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTransactionModalLabel">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Panjang</th>
                                <th>Lebar</th>
                            </tr>
                        </thead>
                        <tbody id="detail-table-body"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        function toggleInputFields(selectElement) {
            const productItem = selectElement.closest('.product-item');
            const jenisFormula = selectElement.selectedOptions[0]?.dataset.jenisFormula;
            const qtyField = productItem.querySelector('.qty-field');
            const panjangField = productItem.querySelector('.panjang-field');
            const lebarField = productItem.querySelector('.lebar-field');

            if (jenisFormula == '1') {
                qtyField.style.display = 'block';
                qtyField.querySelector('input').required = true;
                panjangField.style.display = 'none';
                panjangField.querySelector('input').required = false;
                lebarField.style.display = 'none';
                lebarField.querySelector('input').required = false;
            } else if (jenisFormula == '2') {
                qtyField.style.display = 'none';
                qtyField.querySelector('input').required = false;
                panjangField.style.display = 'block';
                panjangField.querySelector('input').required = true;
                lebarField.style.display = 'block';
                lebarField.querySelector('input').required = true;
            }
        }

        document.getElementById('add-product-item').addEventListener('click', function() {
            const productItem = document.querySelector('.product-item').cloneNode(true);
            productItem.querySelector('select').value = '';
            productItem.querySelectorAll('input').forEach(input => input.value = '');
            productItem.querySelector('.qty-field').style.display = 'block';
            productItem.querySelector('.panjang-field').style.display = 'none';
            productItem.querySelector('.lebar-field').style.display = 'none';
            document.getElementById('product-items').appendChild(productItem);
            productItem.querySelector('.product-select').addEventListener('change', function() {
                toggleInputFields(this);
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                if (document.querySelectorAll('.product-item').length > 1) {
                    e.target.closest('.product-item').remove();
                }
            }
        });

		document.querySelectorAll('.product-select').forEach(select => {
            select.addEventListener('change', function() {
                toggleInputFields(this);
            });
        });

        var detailModal = document.getElementById('detailTransactionModal');
        detailModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var transactionId = button.getAttribute('data-transaction-id');
            var tbody = detailModal.querySelector('#detail-table-body');

            fetch('<?= base_url() ?>transaction/get_details/' + transactionId)
                .then(response => response.json())
                .then(data => {
                    tbody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach((item, index) => {
                            tbody.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.product_nama || 'Tidak ada produk'}</td>
                                    <td>${item.qty}</td>
                                    <td>${item.panjang || '-'}</td>
                                    <td>${item.lebar || '-'}</td>
                                </tr>
                            `;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada detail transaksi.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Gagal memuat detail.</td></tr>';
                });
        });
    </script>
</body>
</html>
