-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jul 2025 pada 15.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah_bkk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `kode_admin` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `kode_admin`, `nama`, `email`, `telepon`) VALUES
(34, 'A001', 'admin', 'admin@gmail.com', '0818-7866-7658');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `kode_alumni` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `tahun_lulus` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `kode_alumni`, `nama`, `nisn`, `jurusan`, `tahun_lulus`, `email`, `telepon`, `alamat`) VALUES
(7, 'S001', 'Daffa', '293385934', 'rpl', '2025-04-30', 'daffa@gmail.com', '0819-3584-7682', 'Lowayu'),
(8, 'S002', 'Yazid', '318426324', 'rpl', '2025-06-01', 'murid@gmail.com', '0874-5397-8236', 'Banyurip'),
(10, 'S003', 'Sauqi', '04935873', 'kuliner', '2025-02-05', 'puqi123@gmail.com', '0896-4587-6546', 'Banyurip');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `tanggal_lamar` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lamaran`
--

INSERT INTO `lamaran` (`id_lamaran`, `id_siswa`, `id_lowongan`, `tanggal_lamar`, `status`) VALUES
(26, 8, 70, '2025-07-25', 'Diterima Kerja'),
(27, 8, 69, '2025-07-25', 'Tidak Diterima Kerja'),
(28, 7, 69, '2025-07-26', 'Tidak Diterima Kerja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan`
--

CREATE TABLE `lowongan` (
  `id_lowongan` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `persyaratan` varchar(255) NOT NULL,
  `gaji` varchar(255) NOT NULL,
  `tanggal_dibuka` date NOT NULL,
  `tanggal_ditutup` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lowongan`
--

INSERT INTO `lowongan` (`id_lowongan`, `id_perusahaan`, `judul`, `deskripsi`, `persyaratan`, `gaji`, `tanggal_dibuka`, `tanggal_ditutup`) VALUES
(30, 2, 'Dev', 'Harus semangat', 'Lulusan IT,Bisa HTML CSS dan JS', 'Rp         2.500.000', '2025-06-01', '2025-06-25'),
(69, 6, 'Kasir', 'Semangat Kerja', 'Harus Good Loking', 'Rp  1.000.000', '2025-07-25', '2025-08-01'),
(70, 2, 'Dev', 'Tidak ada deskripsi', 'Jago Ngoding', 'Rp 10.000.000', '2025-07-25', '2025-07-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `ditujukan` enum('semua','khusus') DEFAULT 'semua',
  `id_siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi`, `tanggal`, `ditujukan`, `id_siswa`) VALUES
(1, 'Lowongan Dihapus', 'Lowongan <b>Web Dev</b> di perusahaan <b>PT Teknologi Indonesia</b> telah dihapus oleh admin.', '2025-07-18 17:32:53', 'semua', NULL),
(2, 'Lowongan Dihapus', 'Lowongan <b>Market Digital</b> di perusahaan <b>Indomaret</b> telah dihapus oleh admin.', '2025-07-18 17:33:01', 'semua', NULL),
(3, 'Lowongan Dihapus', 'Lowongan <b>Game Dev</b> di perusahaan <b>PT Teknologi Indonesia</b> telah dihapus oleh admin.', '2025-07-18 17:33:03', 'semua', NULL),
(4, 'Lowongan Baru Dibuka', 'Telah dibuka Lowongan baru di Perusahaan <b>Indomaret</b> dengan Judul : <b>Kasir</b>.', '2025-07-20 19:35:07', 'semua', NULL),
(5, 'Lowongan Dihapus', 'Lowongan <b>Kasir</b> di perusahaan <b>Indomaret</b> telah dihapus oleh admin.', '2025-07-25 08:05:39', 'semua', NULL),
(6, 'Lowongan Baru (Segera Dibuka)', 'Lowongan <b>Kasir</b> di perusahaan <b>Indomaret</b> akan dibuka <b>1 hari lagi</b> pada tanggal <b>2025-07-26</b>.', '2025-07-25 08:06:45', 'semua', NULL),
(7, 'Lowongan Baru Dibuka', 'Telah dibuka Lowongan baru di Perusahaan <b>PT Teknologi Indonesia</b> dengan Judul : <b>Dev</b>.', '2025-07-25 08:21:51', 'semua', NULL),
(8, 'Selamat! Lamaran Diterima', 'Lamaran anda untuk posisi <b>Dev</b> telah <b>DITERIMA</b>.', '2025-07-25 08:25:53', 'khusus', 8),
(9, 'Maaf, Lamaran Tidak Diterima', 'Lamaran anda untuk posisi <b>Kasir</b> <b>TIDAK DITERIMA</b>.', '2025-07-25 08:27:15', 'khusus', 8),
(22, 'Loker Dev Telah Berakhir', 'Lowongan kerja <b>Dev</b> di perusahaan <b>PT Teknologi Indonesia</b> telah berakhir hari ini.', '2025-07-26 19:47:29', 'semua', NULL),
(23, 'Maaf, Lamaran Tidak Diterima', 'Lamaran anda untuk posisi <b>Kasir</b> <b>TIDAK DITERIMA</b>.', '2025-07-26 20:33:20', 'khusus', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman_viewed`
--

CREATE TABLE `pengumuman_viewed` (
  `id` int(11) NOT NULL,
  `id_pengumuman` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `tanggal_dibaca` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman_viewed`
--

INSERT INTO `pengumuman_viewed` (`id`, `id_pengumuman`, `id_user`, `id_siswa`, `tanggal_dibaca`) VALUES
(1, 1, 35, NULL, '2025-07-18 17:33:06'),
(2, 2, 35, NULL, '2025-07-18 17:33:06'),
(3, 3, 35, NULL, '2025-07-18 17:33:06'),
(4, 1, 38, 7, '2025-07-18 17:33:36'),
(5, 2, 38, 7, '2025-07-18 17:33:37'),
(6, 3, 38, 7, '2025-07-18 17:33:37'),
(7, 1, 40, 8, '2025-07-20 18:43:35'),
(8, 2, 40, 8, '2025-07-20 18:43:36'),
(9, 3, 40, 8, '2025-07-20 18:43:36'),
(10, 1, 42, 10, '2025-07-20 18:44:05'),
(11, 2, 42, 10, '2025-07-20 18:44:05'),
(12, 3, 42, 10, '2025-07-20 18:44:05'),
(19, 4, 35, NULL, '2025-07-20 19:36:02'),
(23, 4, 38, 7, '2025-07-20 19:36:10'),
(27, 4, 40, 8, '2025-07-25 07:11:50'),
(48, 5, 35, NULL, '2025-07-25 08:06:47'),
(49, 6, 35, NULL, '2025-07-25 08:06:47'),
(56, 7, 35, NULL, '2025-07-25 08:22:03'),
(61, 5, 40, 8, '2025-07-25 08:22:32'),
(62, 6, 40, 8, '2025-07-25 08:22:32'),
(63, 7, 40, 8, '2025-07-25 08:22:32'),
(78, 8, 40, 8, '2025-07-25 13:47:25'),
(79, 9, 40, 8, '2025-07-25 13:47:25'),
(114, 22, 35, NULL, '2025-07-26 19:47:33'),
(124, 22, 40, 8, '2025-07-26 19:48:46'),
(129, 5, 38, 7, '2025-07-26 20:24:54'),
(130, 6, 38, 7, '2025-07-26 20:24:54'),
(131, 7, 38, 7, '2025-07-26 20:24:55'),
(132, 22, 38, 7, '2025-07-26 20:24:55'),
(141, 23, 38, 7, '2025-07-26 20:33:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `bidang_usaha` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `email`, `telepon`, `alamat`, `bidang_usaha`, `logo`) VALUES
(2, 'PT Teknologi Indonesia', 'perusahaan@gmail.com', '0929-4935-7487', 'Jln Lowokwaru No 16.', 'Teknologi &amp; Marketing', '681d9a91e5865.jpg'),
(6, 'Indomaret', 'perusahaan2@gmail.com', '0843-6398-5673', 'Ujung Pangkah', 'Marketing', '681c93f322ab6.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `kode_pengguna` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `kode_pengguna`, `username`, `password`, `level`) VALUES
(35, 'A001', 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(38, 'S001', 'daffa', '7b1e852330575c92c8d918377b30726a', 'alumni'),
(40, 'S002', 'Yazid', '837ae4833bde0dc2f5825bbdf0bd646b', 'alumni'),
(42, 'S003', 'Sauqi', '25d55ad283aa400af464c76d713c07ad', 'alumni');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `kode_admin` (`kode_admin`);

--
-- Indeks untuk tabel `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`),
  ADD KEY `kode_alumni` (`kode_alumni`);

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`),
  ADD KEY `id_siswa` (`id_siswa`,`id_lowongan`),
  ADD KEY `id_lowongan` (`id_lowongan`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id_lowongan`),
  ADD KEY `id_perusahaan` (`id_perusahaan`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `pengumuman_viewed`
--
ALTER TABLE `pengumuman_viewed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pengumuman` (`id_pengumuman`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `kode_pengguna` (`kode_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id_lowongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `pengumuman_viewed`
--
ALTER TABLE `pengumuman_viewed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pengumuman_viewed`
--
ALTER TABLE `pengumuman_viewed`
  ADD CONSTRAINT `pengumuman_viewed_ibfk_1` FOREIGN KEY (`id_pengumuman`) REFERENCES `pengumuman` (`id_pengumuman`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengumuman_viewed_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
