<?php
// Syarat menggunakan session
session_start();

// Cek apakah sudah ada session login, jika sudah kembalikan
if (!isset($_SESSION['id_pengguna'])) {
    echo "
        <script>
            document.location.href = '../view/index.php';
        </script>
    ";
}

//cek apakah level pengguna adalah admin
if ($_SESSION['level'] !== 'admin') {
    echo "
        <script>
            document.location.href = 'index.php';
        </script>
    ";
}

// Penghubung antar file di PHP
require '../../src/functions.php';

// Buat variabel untuk menampung hasil query
$admins = [];
$query = mysqli_query($conn, "SELECT * FROM admin, user WHERE kode_admin = kode_pengguna ORDER BY kode_admin ASC");

while ($row = mysqli_fetch_assoc($query)) {
    $admins[] = $row;
}

if (isset($_GET['email']) && $_GET['email'] === 'duplikat') {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'PERINGATAN!',
                text: 'Email Yang Anda Masukkan Sudah Terdaftar!',
                confirmButtonText: 'OK'
            }).then(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menambahkan',
                    text: 'Silahkan Gunakan Email Lain!',
                }).then(() => {
                    window.location.href = '../../pages/public/data-admin.php';
                });
            });
        });
    </script>";
}

// Cek apakah tombol tambah di klik
if (isset($_POST['tambah'])) {

    if (tambahAdmin($_POST) > 0) {
        // SweetAlert untuk berhasil
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Admin berhasil ditambahkan!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../../pages/public/data-admin.php';
                });
            });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data Admin gagal ditambahkan!',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}

// Cek apakah tombol setting akun di klik
if (isset($_POST['settingAkun'])) {

    if (settingAkunAdmin($_POST) > 0) {
        // SweetAlert untuk berhasil
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Setting Akun berhasil!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../../pages/public/data-admin.php';
                });
            });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Setting Akun gagal!',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}

// Cek apakah tombol edit di klik
if (isset($_POST['edit'])) {
    if (editAdmin($_POST) !== false) {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data Admin berhasil diubah!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../../pages/public/data-admin.php';
            });
        });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data Admin gagal diubah!',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    }
}
?>

<!doctype html>
<html lang="en">
<!--begin::Head-->
<?php
$title = "Admin";
include '../../src/template/headers.php'
?>

<!--begin::Stylesheet-->
<style>
    body,
    .swal2-popup {
        font-family: "Poppins", sans-serif;
    }

    .dataTables_length {
        margin-top: 1rem;
    }

    .dataTables_filter {
        margin: 1rem;
    }
</style>
<link rel="stylesheet" href="../../src/assets/css/styletable.css">
<!-- end::Stylesheet -->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar sticky-top navbar-expand bg-primary-subtle shadow" data-bs-theme="dark">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list" style="color: white;"></i>
                        </a>
                    </li>
                </ul>
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img
                                src="../../src/assets/img/logo.png"
                                class="user-image rounded-circle shadow"
                                alt="User Image" />
                            <span class="d-none d-md-inline"><?= $_SESSION["nama"]; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Image-->
                            <li class="user-header text-bg-primary">
                                <?php if ($_SESSION["gambar"] !== "") : ?>
                                    <img
                                        src="../../dist/assets/img/user2-160x160.jpg"
                                        class="rounded-circle shadow"
                                        alt="User Image" />
                                <?php endif; ?>
                                <p>
                                    <?= $_SESSION["nama"]; ?>
                                    <small><?= $_SESSION["level"]; ?></small>
                                </p>
                            </li>
                            <!--end::User Image-->
                            <!--begin::Menu Body-->
                            <li class="user-body">
                                <!--begin::Row-->
                                <!-- <div class="row">
                                    <div class="col-4 text-center"><a href="#">Followers</a></div>
                                    <div class="col-4 text-center"><a href="#">Sales</a></div>
                                    <div class="col-4 text-center"><a href="#">Friends</a></div>
                                </div> -->
                                <!--end::Row-->
                            </li>
                            <!--end::Menu Body-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                <a href="./pengumuman-all.php" class="btn btn-default btn-flat" data-bs-trigger="hover" data-bs-placement="right" data-bs-custom-class="custom-tooltip-Bell" data-bs-title="Pengumuman"><i class="bi bi-bell"></i><span class="badge bg-danger float-end d-none badgePengumuman">0</span></a>
                                <a href="../view/logout.php" class="btn btn-default btn-flat float-end btn-logout" data-bs-trigger="hover" data-bs-placement="left" data-bs-custom-class="custom-tooltip-logout" data-bs-title="LogOut ( Keluar )"><i class="bi bi-box-arrow-right"></i></a>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <?php include('../../src/template/menu.php'); ?>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header my-3">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h3 class="mb-0 fw-bold font-monospace fs-1">Data Admin</h3>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div>
                            <!--begin::Card-->
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <div class="card-title mt-1">
                                        <i class="fa-solid fa-id-card-clip me-1"></i>
                                        Data Admin
                                    </div>
                                    <!-- Tombol Tambah Data -->
                                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        <i class="fas fa-plus me-1"></i>
                                        Tambah Data
                                    </button>
                                </div>
                                <div class="card-body">
                                    <!-- Tabel Data Admin -->
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-hover" style="width:100%">
                                            <thead class="table table-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Email</th>
                                                    <th>Nama</th>
                                                    <th>No Telepon</th>
                                                    <th class="pe-none">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider text-nowrap">
                                                <?php
                                                $no = 1;
                                                foreach ($admins as $admin) : ?>
                                                    <tr>
                                                        <td class="text-center fw-bold"><?= $no++; ?></td>
                                                        <td><?= $admin['email']; ?></td>
                                                        <td><?= $admin['nama']; ?></td>
                                                        <td><?= $admin['telepon']; ?></td>
                                                        <td>
                                                            <a href="" class="btn btn-sm btn-info text-white mb-1" data-bs-toggle="modal" data-bs-target="#modalUser<?= $admin['kode_admin']; ?>" data-bs-trigger="hover" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-User" data-bs-title="Account ( Akun )">
                                                                <i class="fas fa-user"></i>
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $admin['id_admin']; ?>" data-bs-trigger="hover" data-bs-placement="top" data-bs-custom-class="custom-tooltip-Edit" data-bs-title="Edit ( Ubah )">
                                                                <i class="fas fa-gear"></i>
                                                            </a>
                                                            <a href="../../src/config/hapus-dataadmin.php?id=<?= $admin['id_admin']; ?>" class="btn btn-sm btn-danger btn-hapus mb-1" data-bs-trigger="hover" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip-Delete" data-bs-title="Delete ( Hapus )">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->

                    <!-- /.row (main row) -->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">
            <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <!--end::To the end-->
            <!--begin::Copyright-->
            <strong>
                <?php
                $tahun_sekarang = date("Y");
                ?>
                Copyright &copy; <?= $tahun_sekarang; ?>&nbsp;
                <a href="#" class="text-decoration-none">SMK MAMBA'UL IHSAN</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Modal Tambah Data-->
    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahLabel">Tambah Data Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="input-group my-3">
                                <div class="input-group-text px-3"><span class="fas fa-envelope"></span></div>
                                <div class="form-floating">
                                    <input id="email" type="email" name="email" class="form-control" placeholder="" required autocomplete="off" />
                                    <label for="email" class="form-label">Email</label>
                                </div>
                            </div>
                            <!-- <div class="input-group my-3">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="" minlength="8" required autocomplete="off">
                                    <label for="password" class="form-label">Password</label>
                                </div>
                            </div> -->
                            <div class="input-group my-3">
                                <!-- <div class="form-floating">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="" required autocomplete="off">
                                    <label for="username" class="form-label">UserName</label>
                                </div> -->
                                <div class="input-group-text px-3"><span class="fas fa-user"></span></div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="" required autocomplete="off">
                                    <label for="nama" class="form-label">Nama</label>
                                </div>
                            </div>
                            <div class="input-group my-3">
                                <div class="input-group-text px-3"><span class="fas fa-phone"></span></div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="telepon" id="telepon" maxlength="14" placeholder="" required autocomplete="off">
                                    <label for="telepon" class="form-label">No Telepon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end::Modal Tambah Data -->

    <?php foreach ($admins as $admin) : ?>

        <div class="modal fade" id="modalUser<?= $admin["kode_admin"]; ?>" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">Setting Akun</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="kode_admin" id="kode_admin" value="<?= $admin["kode_admin"]; ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-group my-3">
                                    <div class="input-group-text px-3"><span class="fas fa-user"></span></div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="" value="<?= $admin["username"]; ?>" required autocomplete="off">
                                        <label for="username" class="form-label">Username</label>
                                    </div>
                                </div>
                                <div class="input-group my-3">
                                    <div class="input-group-text px-3"><span class="fas fa-lock"></span></div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="" minlength="8" autocomplete="off">
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="settingAkun" class="btn btn-primary">Simpan!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit<?= $admin["id_admin"]; ?>" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">Edit Data Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="id_admin" id="id_admin" value="<?= $admin["id_admin"]; ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-group my-3">
                                    <div class="input-group-text px-3"><span class="fas fa-envelope"></span></div>
                                    <div class="form-floating">
                                        <input id="email<?= $admin["id_admin"]; ?>" type="email" name="email" class="form-control" placeholder="" required value="<?= $admin["email"]; ?>" autocomplete="off" />
                                        <label for="email<?= $admin["id_admin"]; ?>" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="input-group my-3">
                                    <div class="input-group-text px-3"><span class="fas fa-user"></span></div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nama" id="nama<?= $admin["id_admin"]; ?>" placeholder="" required value="<?= $admin["nama"]; ?>" autocomplete="off">
                                        <label for="nama<?= $admin["id_admin"]; ?>" class="form-label">Nama</label>
                                    </div>
                                </div>
                                <div class="input-group my-3">
                                    <div class="input-group-text px-3"><span class="fas fa-phone"></span></div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="telepon" id="telepon<?= $admin["id_admin"]; ?>" maxlength="14" placeholder="" required value="<?= $admin["telepon"]; ?>" autocomplete="off">
                                            <label for="telepon<?= $admin["id_admin"]; ?>" class="form-label">No Telepon</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-primary">Simpan!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!--begin::Script-->
    
    <?php
    include '../../src/template/footer.php';
    ?>

    <!-- OPTIONAL SCRIPTS -->

    <!--begin::Validation-->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Reset form validation when modal is closed
        const modalTambah = document.getElementById('modalTambah');

        modalTambah.addEventListener('hidden.bs.modal', function() {
            const form = modalTambah.querySelector('form');
            form.classList.remove('was-validated'); // Hapus kelas validasi
            form.reset(); // Reset semua input di dalam form
        });
    </script>
    <!--end::Validation-->

    <!-- begin::Form -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    // Reset form di dalam modal
                    const form = modal.querySelector('form');
                    if (form) {
                        form.reset();
                    }

                    // Kalau kamu pakai value dari PHP, perlu di-*refresh* datanya via AJAX atau reload
                    // Tapi kalau isiannya dari value HTML langsung, cukup pakai form.reset()
                });
            });
        });
    </script>
    <!-- end::Form -->

    <!--begin::No Phone-->
    <script>
        document.getElementById('telepon').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); // Hanya angka
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if ((i === 4 || (i > 4 && (i - 4) % 4 === 0)) && formattedValue.split('-').length <= 4) {
                    formattedValue += '-';
                }
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });
    </script>
    <!--end::No Phone-->

    <!-- Mencagah SweetAlert Infinite Loop -->
    <script>
        if (window.location.search.includes("email=duplikat")) {
            history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>