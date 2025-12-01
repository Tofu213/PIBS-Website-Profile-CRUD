<?php
// KONEKSI
include 'koneksi.php';

// 1. Tentukan NIM aktif
if (isset($_GET['nim'])) {
    $nim = $DB->real_escape_string($_GET['nim']);
} else {
    $resDefault = $DB->query("SELECT nim FROM tbl_users ORDER BY id_user ASC LIMIT 1");
    $rowDefault = $resDefault ? $resDefault->fetch_assoc() : null;
    $nim = $rowDefault['nim'] ?? '';
}

if ($nim === '') {
    die("Belum ada data user di database.");
}

// 2. Ambil data user utama
$sqlUser = "SELECT * FROM tbl_users WHERE nim = '$nim' LIMIT 1";
$resUser = $DB->query($sqlUser);
$user    = $resUser->fetch_assoc();
if (!$user) {
    die("User dengan NIM $nim tidak ditemukan.");
}

// 3. Query data lain
$biodata     = $DB->query("SELECT * FROM tbl_biodata WHERE nim = '$nim' ORDER BY id_biodata ASC");
$pendidikan  = $DB->query("SELECT * FROM tbl_pendidikan WHERE nim = '$nim' ORDER BY tahun DESC, id_pendidikan DESC");
$pengalaman  = $DB->query("SELECT * FROM tbl_pengalaman WHERE nim = '$nim' ORDER BY id_pengalaman DESC");
$keahlian    = $DB->query("SELECT * FROM tbl_keahlian   WHERE nim = '$nim' ORDER BY id_keahlian ASC");
$aside_items = $DB->query("SELECT * FROM tbl_aside      WHERE nim = '$nim' ORDER BY id_aside ASC");
$footer_data = $DB->query("SELECT * FROM tbl_footer     WHERE nim = '$nim' LIMIT 1");
$footer_data = $footer_data ? $footer_data->fetch_assoc() : null;

// dropdown list user
$list_users  = $DB->query("SELECT nim, nama_lengkap FROM tbl_users ORDER BY id_user ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa | <?= htmlspecialchars($user['nama_lengkap']); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Lato:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="page-container">

    <!-- DROPDOWN GANTI PROFIL (bebas, bukan bagian layout tugas) -->
    <div class="user-switcher">
        <span>Profil:</span>
        <form method="get">
            <select name="nim" onchange="this.form.submit()">
                <?php while($u = $list_users->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($u['nim']); ?>"
                        <?= $u['nim'] == $nim ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($u['nama_lengkap']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
    </div>

    <!-- HEADER (100% di semua device) -->
    <header>
        <div class="header-content">
            <img src="<?= !empty($user['foto_profil']) ? 'uploads/'.$user['foto_profil'] : 'laurensius.png'; ?>"
                 alt="Foto Profil" class="header-profile-pic">
            <div class="header-text">
                <h1>My Profile!</h1>
                <p><?= htmlspecialchars($user['nama_lengkap']); ?></p>
            </div>
        </div>
    </header>

    <!-- MAIN: mengikuti layout pdf (nav, section, aside) -->
    <main class="main-content">

        <!-- NAV (menu biodata, pendidikan, dll) -->
        <nav>
            <ul>
                <li><a href="#biodata"    class="nav-link">Biodata</a></li>
                <li><a href="#pendidikan" class="nav-link">Pendidikan</a></li>
                <li><a href="#pengalaman" class="nav-link">Pengalaman</a></li>
                <li><a href="#keahlian"   class="nav-link">Keahlian</a></li>
            </ul>
        </nav>

        <!-- SECTION: isi konten -->
        <section>

            <!-- BIODATA -->
            <article id="biodata" class="page-content visible">
                <h2>Biodata</h2>
                <hr>
                <div class="biodata-grid">
                    <?php if($biodata && $biodata->num_rows > 0): ?>
                        <?php while($row = $biodata->fetch_assoc()): ?>
                            <p><strong><?= htmlspecialchars($row['judul']); ?>:</strong> <?= nl2br(htmlspecialchars($row['isi'])); ?></p>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p><strong>Belum ada biodata.</strong></p>
                    <?php endif; ?>
                </div>
            </article>

            <!-- PENDIDIKAN -->
            <article id="pendidikan" class="page-content">
                <h2>Riwayat Pendidikan</h2>
                <hr>
                <?php if($pendidikan && $pendidikan->num_rows > 0): ?>
                    <?php while($edu = $pendidikan->fetch_assoc()): ?>
                        <div class="timeline-item">
                            <strong><?= htmlspecialchars($edu['institusi']); ?></strong>
                            <?php if(!empty($edu['tahun'])): ?>
                                <span> (<?= htmlspecialchars($edu['tahun']); ?>)</span>
                            <?php endif; ?>
                            <?php if(!empty($edu['jurusan'])): ?>
                                <div><?= htmlspecialchars($edu['jurusan']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Belum ada data pendidikan.</p>
                <?php endif; ?>
            </article>

            <!-- PENGALAMAN -->
            <article id="pengalaman" class="page-content">
                <h2>Pengalaman Proyek</h2>
                <hr>
                <?php if($pengalaman && $pengalaman->num_rows > 0): ?>
                    <?php while($exp = $pengalaman->fetch_assoc()): ?>
                        <div class="project-card">
                            <strong><?= htmlspecialchars($exp['judul']); ?></strong>
                            <p><?= nl2br(htmlspecialchars($exp['isi'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Belum ada data pengalaman.</p>
                <?php endif; ?>
            </article>

            <!-- KEAHLIAN -->
            <article id="keahlian" class="page-content">
                <h2>Keahlian</h2>
                <hr>
                <ul class="skills-list">
                    <?php if($keahlian && $keahlian->num_rows > 0): ?>
                        <?php while($skill = $keahlian->fetch_assoc()): ?>
                            <li>
                                <i class="fa-solid fa-check-circle"></i>
                                <?= htmlspecialchars($skill['judul']); ?>
                                <?php if(!empty($skill['isi'])): ?>
                                    - <?= htmlspecialchars($skill['isi']); ?>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li><i class="fa-solid fa-circle-info"></i> Belum ada data keahlian.</li>
                    <?php endif; ?>
                </ul>
            </article>

        </section>

        <!-- ASIDE: hobi / info samping -->
        <aside>
            <div class="info-card">
                <h3>Hobi</h3>
                <ul>
                    <?php if($aside_items && $aside_items->num_rows > 0): ?>
                        <?php while($h = $aside_items->fetch_assoc()): ?>
                            <?php if(!empty($h['nama_kegiatan'])): ?>
                                <li>
                                    <i class="fa-solid fa-star"></i>
                                    <?= htmlspecialchars($h['nama_kegiatan']); ?>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li><i class="fa-solid fa-code"></i> Coding</li>
                        <li><i class="fa-solid fa-gamepad"></i> Bermain Game</li>
                        <li><i class="fa-solid fa-headphones"></i> Musik</li>
                        <li><i class="fa-solid fa-burger"></i> Memasak</li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </main>

    <!-- FOOTER (100% di semua device) -->
    <footer>
        <div class="footer-content">
            <?php if($footer_data): ?>
                <div>
                    <?php if(!empty($footer_data['instagram'])): ?>
                        Instagram: <a href="<?= htmlspecialchars($footer_data['instagram']); ?>" target="_blank"><?= htmlspecialchars($footer_data['instagram']); ?></a> |
                    <?php endif; ?>
                    <?php if(!empty($footer_data['spotify'])): ?>
                        Spotify: <a href="<?= htmlspecialchars($footer_data['spotify']); ?>" target="_blank"><?= htmlspecialchars($footer_data['spotify']); ?></a> |
                    <?php endif; ?>
                    <?php if(!empty($footer_data['linkedin'])): ?>
                        LinkedIn: <a href="<?= htmlspecialchars($footer_data['linkedin']); ?>" target="_blank"><?= htmlspecialchars($footer_data['linkedin']); ?></a>
                    <?php endif; ?>
                </div>
                <div><?= htmlspecialchars($footer_data['copyright'] ?? ''); ?></div>
            <?php else: ?>
                <div>&copy; <?= date('Y'); ?> Sistem Profil Mahasiswa</div>
            <?php endif; ?>
        </div>
    </footer>

</div>

<!-- JS kecil: ganti tab section saat klik menu -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.nav-link');
    const pages = document.querySelectorAll('.page-content');

    function showPage(id) {
        pages.forEach(p => p.classList.remove('visible'));
        const target = document.querySelector(id);
        if (target) target.classList.add('visible');
    }

    links.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            showPage(link.getAttribute('href'));
        });
    });

    // set awal: biodata aktif
    const firstLink = document.querySelector('.nav-link');
    if (firstLink) firstLink.classList.add('active');
});
</script>
</body>
</html>
