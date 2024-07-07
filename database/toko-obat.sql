-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Jul 2024 pada 23.58
-- Versi server: 10.6.18-MariaDB-cll-lve
-- Versi PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raig8214_toko-obat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `golongan-obat`
--

CREATE TABLE `golongan-obat` (
  `id_golongan` int(11) NOT NULL,
  `golongan_obat` varchar(60) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `golongan-obat`
--

INSERT INTO `golongan-obat` (`id_golongan`, `golongan_obat`, `catatan`, `created_at`, `last_updated`) VALUES
(1, 'B', '', '2023-07-20 22:27:05', '2023-07-20 22:27:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis-obat`
--

CREATE TABLE `jenis-obat` (
  `id_jenis` int(11) NOT NULL,
  `jenis_obat` varchar(60) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jenis-obat`
--

INSERT INTO `jenis-obat` (`id_jenis`, `jenis_obat`, `catatan`, `created_at`, `last_updated`) VALUES
(1, 'Kapsul', '', '2023-07-20 22:22:53', '2023-07-20 22:22:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori-obat`
--

CREATE TABLE `kategori-obat` (
  `id_kategori` int(11) NOT NULL,
  `kategori_obat` varchar(60) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori-obat`
--

INSERT INTO `kategori-obat` (`id_kategori`, `kategori_obat`, `catatan`, `created_at`, `last_updated`) VALUES
(1, 'Obat Bebas', '', '2023-07-20 22:27:28', '2023-07-20 22:27:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `nama_obat` varchar(60) NOT NULL,
  `tgl_kadaluarsa` date NOT NULL,
  `qty` int(11) NOT NULL,
  `status` varchar(60) NOT NULL,
  `pendapatan` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `log`
--

INSERT INTO `log` (`id_log`, `nama_obat`, `tgl_kadaluarsa`, `qty`, `status`, `pendapatan`, `created_at`) VALUES
(11, 'Panadol', '2025-07-09', 1, 'terjual', 5000, '2023-07-31 22:37:11'),
(12, 'Panadol', '2025-07-09', 1, 'terjual', 5000, '2023-07-31 23:10:26'),
(13, 'Panadol', '2025-07-09', 4, 'terjual', 20000, '2023-07-31 23:10:26'),
(17, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-01 09:05:51'),
(18, 'Panadol', '2025-07-09', 1, 'rusak', -10000, '2023-08-01 09:11:09'),
(19, 'Bodrex', '2023-08-18', 2, 'terjual', 10000, '2023-08-01 12:57:06'),
(20, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-07 21:21:50'),
(21, 'Bodrex', '2023-08-18', 2, 'rusak', 0, '2023-08-07 21:54:25'),
(22, 'Panadol', '2025-07-09', 1, 'terjual', 5000, '2023-08-07 22:13:01'),
(23, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-07 22:13:01'),
(24, 'Panadol', '2023-12-19', 1, 'rusak', 0, '2023-08-07 22:13:31'),
(25, 'Panadol', '2025-07-09', 1, 'rusak', 0, '2023-08-07 22:16:26'),
(26, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-07 22:44:46'),
(27, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-07 22:46:46'),
(28, 'Panadol', '2023-08-06', 1, 'kadaluarsa', 0, '2023-08-07 22:53:23'),
(32, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-08 23:28:01'),
(33, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-09 08:24:18'),
(34, 'Panadol', '2023-08-31', 4, 'terjual', 20000, '2023-08-17 13:43:32'),
(35, 'Panadol', '2023-08-31', 1, 'terjual', 5000, '2023-08-20 07:19:19'),
(36, 'Panadol', '2023-08-16', 1, 'kadaluarsa', 0, '2023-08-23 06:59:12'),
(37, 'Bodrex', '2023-08-31', 1, 'terjual', 5000, '2023-08-23 07:33:48'),
(38, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-08-23 07:33:48'),
(39, 'Bodrex', '2023-09-29', 1, 'terjual', 5000, '2023-09-22 14:00:00'),
(40, 'Panadol', '2023-12-19', 1, 'terjual', 5000, '2023-09-22 14:00:00'),
(41, 'Panadol', '2025-07-09', 2, 'terjual', 10000, '2024-05-29 14:52:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(60) NOT NULL,
  `satuan` varchar(60) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok_minimal` int(11) NOT NULL,
  `jenis_obat` varchar(60) NOT NULL,
  `kategori` varchar(60) NOT NULL,
  `golongan` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `satuan`, `harga_beli`, `harga_jual`, `stok_minimal`, `jenis_obat`, `kategori`, `golongan`, `created_at`, `last_updated`) VALUES
(12, 'Panadol', 'Pcs', 10000, 15000, 10, 'Kapsul', 'Obat Bebas', 'B', '2023-07-24 22:15:56', '2023-07-24 22:16:07'),
(13, 'Bodrex', 'Pcs', 10000, 15000, 5, '', '', '', '2023-08-17 09:57:50', '2023-08-17 09:57:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan-obat`
--

CREATE TABLE `satuan-obat` (
  `id_satuan` int(11) NOT NULL,
  `satuan_obat` varchar(60) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `satuan-obat`
--

INSERT INTO `satuan-obat` (`id_satuan`, `satuan_obat`, `catatan`, `created_at`, `last_updated`) VALUES
(2, 'Pcs', '', '2023-07-20 22:23:16', '2023-07-20 22:23:16'),
(3, 'Biji', '', '2023-07-21 18:12:47', '2023-07-21 18:12:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok-obat`
--

CREATE TABLE `stok-obat` (
  `id_stok` int(11) NOT NULL,
  `nama_obat` varchar(60) NOT NULL,
  `stok_obat` int(11) NOT NULL,
  `tgl_kadaluarsa` date NOT NULL,
  `status` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `stok-obat`
--

INSERT INTO `stok-obat` (`id_stok`, `nama_obat`, `stok_obat`, `tgl_kadaluarsa`, `status`, `created_at`, `last_updated`) VALUES
(1, 'Panadol', 11, '2025-07-09', 'tersedia', '2023-07-24 17:00:15', '2023-08-20 07:21:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp-penjualan`
--

CREATE TABLE `tmp-penjualan` (
  `id_tmp_penjualan` int(11) NOT NULL,
  `tgl_kadaluarsa` date NOT NULL,
  `nama_obat` varchar(60) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `subtotal_harga_beli` int(11) NOT NULL,
  `subtotal_harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tmp-penjualan`
--

INSERT INTO `tmp-penjualan` (`id_tmp_penjualan`, `tgl_kadaluarsa`, `nama_obat`, `qty`, `harga_beli`, `harga_jual`, `subtotal_harga_beli`, `subtotal_harga_jual`) VALUES
(39, '2025-07-09', 'Panadol', 1, 10000, 15000, 10000, 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tgl_waktu_transaksi` datetime NOT NULL,
  `berkas` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_waktu_transaksi`, `berkas`) VALUES
(3, '2023-08-08 23:28:01', '20230808232801.pdf'),
(4, '2023-08-09 08:24:18', '20230809082418.pdf'),
(5, '2023-08-17 13:43:32', '20230817134332.pdf'),
(6, '2023-08-20 07:19:19', '20230820071919.pdf'),
(7, '2023-08-23 07:33:48', '20230823073348.pdf'),
(8, '2023-09-22 14:00:00', '20230922140000.pdf'),
(9, '2024-05-29 14:52:46', '20240529145246.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(1, 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `golongan-obat`
--
ALTER TABLE `golongan-obat`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indeks untuk tabel `jenis-obat`
--
ALTER TABLE `jenis-obat`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `kategori-obat`
--
ALTER TABLE `kategori-obat`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `satuan-obat`
--
ALTER TABLE `satuan-obat`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `stok-obat`
--
ALTER TABLE `stok-obat`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indeks untuk tabel `tmp-penjualan`
--
ALTER TABLE `tmp-penjualan`
  ADD PRIMARY KEY (`id_tmp_penjualan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `golongan-obat`
--
ALTER TABLE `golongan-obat`
  MODIFY `id_golongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jenis-obat`
--
ALTER TABLE `jenis-obat`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori-obat`
--
ALTER TABLE `kategori-obat`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `satuan-obat`
--
ALTER TABLE `satuan-obat`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stok-obat`
--
ALTER TABLE `stok-obat`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tmp-penjualan`
--
ALTER TABLE `tmp-penjualan`
  MODIFY `id_tmp_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
