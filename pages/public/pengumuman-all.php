<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['id_pengguna'])) {
    echo "<script>document.location.href = '../view/index.php';</script>";
    exit;
}

require '../../src/functions.php';

// Ambil id_alumni (bukan id_user) jika alumni
$id_siswa = 0;
if ($_SESSION['level'] == 'alumni') {
    $id_user = intval($_SESSION['id_pengguna']);
    $q = mysqli_query($conn, "SELECT kode_pengguna FROM user WHERE id_user = $id_user");
    $row = mysqli_fetch_assoc($q);
    if ($row) {
        $kode_alumni = $row['kode_pengguna'];
        $q2 = mysqli_query($conn, "SELECT id_alumni FROM alumni WHERE kode_alumni = '$kode_alumni'");
        $row2 = mysqli_fetch_assoc($q2);
        if ($row2) {
            $id_siswa = intval($row2['id_alumni']);
        }
    }
}

$pengumuman = [];
$q = mysqli_query($conn, "
    SELECT * FROM pengumuman
    WHERE ditujukan='semua'
       OR (ditujukan='khusus' AND id_siswa=$id_siswa)
    ORDER BY tanggal DESC, id_pengumuman DESC
");
while ($row = mysqli_fetch_assoc($q)) {
    $pengumuman[] = $row;
}

// Hitung pengumuman baru
$last_viewed = $_SESSION['last_viewed_pengumuman'] ?? 0;
$new_pengumuman = 0;
foreach ($pengumuman as $p) {
    if (strtotime($p['tanggal']) > $last_viewed) {
        $new_pengumuman++;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    $title = "Pengumuman";
    include '../../src/template/headers.php';
    ?>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #f8f9fa;
        }

        .pengumuman-card {
            margin-bottom: 1.5rem;
        }

        .tgl {
            font-size: 15px;
        }

        .notification-badge {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1);}
            50% { transform: scale(1.2);}
            100% { transform: scale(1);}
        }
        @media (max-width: 768px) {
            .judul {
                font-size: .94rem;
            }

            .tgl {
                font-size: .85rem;
            }

            .isi {
                font-size: .85rem;
            }
            .btn-C {
                font-size: .8rem;
            }
        }

        @media (max-width: 576px){
            .judul {
                font-size: .9rem;
            }
            .tgl {
                font-size: .8rem;
            }
            .isi {
                font-size: .82rem;
            }
            .btn-C {
                font-size: .75rem;
            }
        }

        @media (max-width: 535px){
            .judul {
                font-size: .7rem;
            }
            .tgl {
                font-size: .65rem;
                transform: translate(0,30%);
            }
            .isi {
                font-size: .67rem;
            }
            .btn-C {
                font-size: .65rem;
            }
        }
    </style>
</head>
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
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6 d-flex">
                            <h3 class="mb-0">Pengumuman</h3>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid">
                    <!--begin::Row-->
                    <?php if (empty($pengumuman)): ?>
                        <div class="alert alert-info">Belum ada pengumuman.</div>
                    <?php else: ?>
                        <?php foreach ($pengumuman as $p): ?>
                            <div class="card pengumuman-card position-relative">
                                <div class="card-header bg-primary text-white position-relative align-items-center">
                                    <strong class="judul"><?= htmlspecialchars($p['judul']) ?></strong>
                                    <?php if ($p['ditujukan'] === 'khusus' && isset($p['id_siswa']) && $p['id_siswa'] == $id_siswa) : ?>
                                        <span class="tgl float-end me-4">
                                            <?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?>
                                        </span>
                                        <a href="../../src/config/hapus-pengumuman.php?id=<?= $p['id_pengumuman']; ?>" class="btn-C btn btn-sm text-white position-absolute m-2" style="top: -10%; right: -1%;">
                                            <i class="fas fa-x"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="tgl float-end">
                                            <?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body">
                                    <div class="isi"><?= $p['isi'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
    <?php include '../../src/template/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPengumuman = <?= $new_pengumuman ?>;
    // Pastikan badge sudah ada di DOM, jika belum tunggu sebentar
    function updateBadge() {
        var badge = document.getElementById('badgePengumuman');
        if (badge) {
            if (newPengumuman > 0) {
                badge.classList.remove('d-none');
                badge.textContent = newPengumuman;
                badge.classList.add('notification-badge');
                // Tandai sudah dilihat
                fetch(window.location.pathname + '?viewed=true');
            } else {
                badge.classList.add('d-none');
                badge.textContent = '0';
                badge.classList.remove('notification-badge');
            }
        } else {
            // Coba lagi setelah 200ms jika badge belum ada
            setTimeout(updateBadge, 200);
        }
    }
    updateBadge();
});
</script>
</body>
<!--end::Body-->
</html>