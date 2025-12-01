-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2025 pada 09.14
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
-- Database: `database_profil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_aside`
--

CREATE TABLE `tbl_aside` (
  `id_aside` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `nama_kegiatan` varchar(100) DEFAULT NULL,
  `judul_lagu` varchar(150) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `lagu` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_biodata`
--

CREATE TABLE `tbl_biodata` (
  `id_biodata` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_footer`
--

CREATE TABLE `tbl_footer` (
  `id_footer` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `spotify` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `copyright` varchar(200) DEFAULT NULL,
  `quote` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_keahlian`
--

CREATE TABLE `tbl_keahlian` (
  `id_keahlian` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_konten`
--

CREATE TABLE `tbl_konten` (
  `id_konten` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_nav_profile`
--

CREATE TABLE `tbl_nav_profile` (
  `id_nav` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pendidikan`
--

CREATE TABLE `tbl_pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `institusi` varchar(150) NOT NULL,
  `jurusan` varchar(150) DEFAULT NULL,
  `tahun` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengalaman`
--

CREATE TABLE `tbl_pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `foto_profil` varchar(200) DEFAULT NULL,
  `foto_background` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `nim`, `nama_lengkap`, `foto_profil`, `foto_background`) VALUES
(1, '2024081000', 'Laurensius', '1764507480_laurensius.png', '1764507480_26bc6c322aaa6ea10f9dc9bbdbd6aeb6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_aside`
--
ALTER TABLE `tbl_aside`
  ADD PRIMARY KEY (`id_aside`);

--
-- Indeks untuk tabel `tbl_biodata`
--
ALTER TABLE `tbl_biodata`
  ADD PRIMARY KEY (`id_biodata`);

--
-- Indeks untuk tabel `tbl_footer`
--
ALTER TABLE `tbl_footer`
  ADD PRIMARY KEY (`id_footer`);

--
-- Indeks untuk tabel `tbl_keahlian`
--
ALTER TABLE `tbl_keahlian`
  ADD PRIMARY KEY (`id_keahlian`);

--
-- Indeks untuk tabel `tbl_konten`
--
ALTER TABLE `tbl_konten`
  ADD PRIMARY KEY (`id_konten`);

--
-- Indeks untuk tabel `tbl_nav_profile`
--
ALTER TABLE `tbl_nav_profile`
  ADD PRIMARY KEY (`id_nav`);

--
-- Indeks untuk tabel `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indeks untuk tabel `tbl_pengalaman`
--
ALTER TABLE `tbl_pengalaman`
  ADD PRIMARY KEY (`id_pengalaman`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_aside`
--
ALTER TABLE `tbl_aside`
  MODIFY `id_aside` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_biodata`
--
ALTER TABLE `tbl_biodata`
  MODIFY `id_biodata` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_footer`
--
ALTER TABLE `tbl_footer`
  MODIFY `id_footer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_keahlian`
--
ALTER TABLE `tbl_keahlian`
  MODIFY `id_keahlian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_konten`
--
ALTER TABLE `tbl_konten`
  MODIFY `id_konten` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_nav_profile`
--
ALTER TABLE `tbl_nav_profile`
  MODIFY `id_nav` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengalaman`
--
ALTER TABLE `tbl_pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
