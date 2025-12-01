<?php
// koneksi ke database_profil
include 'koneksi.php';

/*
   KONFIGURASI TABEL
   ------------------
   title  : judul yang tampil di halaman
   pk     : nama kolom primary key
   fields : kolom yang diedit/tampil (form & tabel)
            type: text | textarea | select | file
*/
$config_tables = [
    'tbl_users' => [
        'title' => 'Users',
        'pk'    => 'id_user',
        'fields'=> [
            'nim'             => ['label' => 'NIM',              'type' => 'text'],
            'nama_lengkap'    => ['label' => 'Nama Lengkap',    'type' => 'text'],
            'foto_profil'     => ['label' => 'Foto Profil',     'type' => 'file'],
            'foto_background' => ['label' => 'Foto Background', 'type' => 'file'],
        ]
    ],
    'tbl_biodata' => [
        'title' => 'Biodata',
        'pk'    => 'id_biodata',
        'fields'=> [
            'nim'   => ['label' => 'NIM',   'type' => 'text'],
            'judul' => ['label' => 'Judul', 'type' => 'text'],
            'isi'   => ['label' => 'Isi',   'type' => 'textarea'],
        ]
    ],
    'tbl_pendidikan' => [
        'title' => 'Pendidikan',
        'pk'    => 'id_pendidikan',
        'fields'=> [
            'nim'       => ['label' => 'NIM',       'type' => 'text'],
            'institusi' => ['label' => 'Institusi', 'type' => 'text'],
            'jurusan'   => ['label' => 'Jurusan',   'type' => 'text'],
            'tahun'     => ['label' => 'Tahun',     'type' => 'text'],
        ]
    ],
    'tbl_pengalaman' => [
        'title' => 'Pengalaman',
        'pk'    => 'id_pengalaman',
        'fields'=> [
            'nim'   => ['label' => 'NIM',   'type' => 'text'],
            'judul' => ['label' => 'Judul', 'type' => 'text'],
            'isi'   => ['label' => 'Isi',   'type' => 'textarea'],
            'foto'  => ['label' => 'Nama File Foto', 'type' => 'text'],
        ]
    ],
    'tbl_keahlian' => [
        'title' => 'Keahlian',
        'pk'    => 'id_keahlian',
        'fields'=> [
            'nim'   => ['label' => 'NIM',   'type' => 'text'],
            'judul' => ['label' => 'Judul', 'type' => 'text'],
            'isi'   => ['label' => 'Isi',   'type' => 'textarea'],
        ]
    ],
    'tbl_konten' => [
        'title' => 'Konten',
        'pk'    => 'id_konten',
        'fields'=> [
            'nim'   => ['label' => 'NIM',   'type' => 'text'],
            'judul' => ['label' => 'Judul', 'type' => 'text'],
            'isi'   => ['label' => 'Isi',   'type' => 'textarea'],
            'foto'  => ['label' => 'Nama File Foto', 'type' => 'text'],
        ]
    ],
    'tbl_aside' => [
        'title' => 'Aside (Hobi / Lagu)',
        'pk'    => 'id_aside',
        'fields'=> [
            'nim'           => ['label' => 'NIM',           'type' => 'text'],
            'foto'          => ['label' => 'Nama File Foto','type' => 'text'],
            'nama_kegiatan' => ['label' => 'Nama Kegiatan', 'type' => 'text'],
            'judul_lagu'    => ['label' => 'Judul Lagu',    'type' => 'text'],
            'keterangan'    => ['label' => 'Keterangan',    'type' => 'text'],
            'lagu'          => ['label' => 'Nama File Lagu','type' => 'text'],
        ]
    ],
    'tbl_footer' => [
        'title' => 'Footer',
        'pk'    => 'id_footer',
        'fields'=> [
            'nim'       => ['label' => 'NIM',       'type' => 'text'],
            'linkedin'  => ['label' => 'Link LinkedIn',  'type' => 'text'],
            'spotify'   => ['label' => 'Link Spotify',   'type' => 'text'],
            'instagram' => ['label' => 'Link Instagram', 'type' => 'text'],
            'copyright' => ['label' => 'Copyright',      'type' => 'text'],
            'quote'     => ['label' => 'Quote',          'type' => 'textarea'],
        ]
    ],
    'tbl_nav_profile' => [
        'title' => 'Nav Profile',
        'pk'    => 'id_nav',
        'fields'=> [
            'nim'   => ['label' => 'NIM',   'type' => 'text'],
            'menu'  => ['label' => 'Nama Menu',  'type' => 'text'],
            'aktif' => [
                'label'   => 'Aktif?',
                'type'    => 'select',
                'options' => ['1' => 'Aktif', '0' => 'Tidak Aktif']
            ],
        ]
    ],
];

// tabel aktif
$tabel_aktif = isset($_GET['tabel']) ? $_GET['tabel'] : 'tbl_users';
if (!isset($config_tables[$tabel_aktif])) {
    $tabel_aktif = 'tbl_users';
}
$cfg        = $config_tables[$tabel_aktif];
$primaryKey = $cfg['pk'];
$fields     = $cfg['fields'];

$editData = null;
$editId   = "";

// hapus
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $DB->query("DELETE FROM $tabel_aktif WHERE $primaryKey = $id");
    header("Location: admin_profile.php?tabel=" . urlencode($tabel_aktif));
    exit;
}

// ambil data untuk edit
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $res    = $DB->query("SELECT * FROM $tabel_aktif WHERE $primaryKey = $editId");
    if ($res && $res->num_rows > 0) {
        $editData = $res->fetch_assoc();
    }
}

/* ========== SIMPAN / UPDATE (dengan upload file) ========== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_val = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    // kalau update, ambil data lama
    $existingRow = null;
    if ($id_val > 0) {
        $resOld = $DB->query("SELECT * FROM $tabel_aktif WHERE $primaryKey = $id_val");
        if ($resOld && $resOld->num_rows > 0) {
            $existingRow = $resOld->fetch_assoc();
        }
    }

    $setParts   = [];
    $colNames   = [];
    $colValues  = [];

    foreach ($fields as $name => $f) {
        $type = $f['type'];
        $val  = '';

        if ($type === 'file') {
            // handle upload
            if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
                $tmpName  = $_FILES[$name]['tmp_name'];
                $origName = basename($_FILES[$name]['name']);
                $ext      = pathinfo($origName, PATHINFO_EXTENSION);
                $safeName = preg_replace('/[^a-zA-Z0-9_\-]/','', pathinfo($origName, PATHINFO_FILENAME));
                if ($safeName === '') $safeName = $name;
                $newName  = time() . '_' . $safeName . '.' . $ext;

                $targetDir  = __DIR__ . '/uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $targetPath = $targetDir . $newName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $val = $newName;
                } else {
                    $val = $existingRow[$name] ?? '';
                }
            } else {
                $val = $existingRow[$name] ?? '';
            }
        } else {
            $val = isset($_POST[$name]) ? $_POST[$name] : '';
        }

        $val = $DB->real_escape_string($val);

        $colNames[]  = $name;
        $colValues[] = "'$val'";
        $setParts[]  = "$name = '$val'";
    }

    if ($id_val > 0) {
        $sql = "UPDATE $tabel_aktif SET " . implode(', ', $setParts) . " WHERE $primaryKey = $id_val";
        $DB->query($sql);
    } else {
        $sql = "INSERT INTO $tabel_aktif (" . implode(',', $colNames) . ") VALUES (" . implode(',', $colValues) . ")";
        $DB->query($sql);
    }

    header("Location: admin_profile.php?tabel=" . urlencode($tabel_aktif));
    exit;
}

// ambil semua data
$data_result = $DB->query("SELECT * FROM $tabel_aktif ORDER BY $primaryKey ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Profil - <?= htmlspecialchars($cfg['title']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- pakai CSS profil Laurensius -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Lato:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="admin-page">
<div class="page-container">

    <!-- HEADER SAMA STYLE, TULISAN ADMIN -->
    <header>
        <div class="header-content">
            <img src="laurensius.png" alt="Admin" class="header-profile-pic">
            <div class="header-text">
                <h1>Admin Panel</h1>
                <p>Kelola data profil mahasiswa</p>
            </div>
        </div>
    </header>

    <main class="main-content">

        <!-- NAV: daftar tabel (mirip nav biodata/pendidikan dll) -->
        <nav>
            <ul>
                <?php foreach ($config_tables as $tbl => $conf): ?>
                    <li>
                        <a href="admin_profile.php?tabel=<?= urlencode($tbl); ?>"
                           class="<?= $tbl == $tabel_aktif ? 'active' : ''; ?>">
                            <?= htmlspecialchars($conf['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li style="margin-top:1rem;">
                    <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Kembali ke Profil</a>
                </li>
            </ul>
        </nav>

        <!-- SECTION: form + tabel CRUD -->
        <section>
           <article class="page-content visible">
    <h2 data-text="Kelola <?= htmlspecialchars($cfg['title']); ?>">Kelola <?= htmlspecialchars($cfg['title']); ?></h2>

                <div class="crud-grid">
                    <!-- FORM -->
                    <div class="crud-card">
                        <h3>Form Input</h3>
                        <form method="post"
                              enctype="multipart/form-data"
                              action="admin_profile.php?tabel=<?= urlencode($tabel_aktif); ?>">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($editId); ?>">

                            <?php foreach ($fields as $name => $f):
                                $label = $f['label'];
                                $type  = $f['type'];
                                $value = $editData ? $editData[$name] : '';
                            ?>
                                <label class="crud-label" for="<?= $name; ?>"><?= htmlspecialchars($label); ?></label>

                                <?php if ($type === 'textarea'): ?>
                                    <textarea class="crud-input" name="<?= $name; ?>" id="<?= $name; ?>"><?= htmlspecialchars($value); ?></textarea>

                                <?php elseif ($type === 'select'): ?>
                                    <select class="crud-input" name="<?= $name; ?>" id="<?= $name; ?>">
                                        <?php foreach ($f['options'] as $optVal => $optLabel): ?>
                                            <option value="<?= htmlspecialchars($optVal); ?>"
                                                <?= ($value !== '' && $value == $optVal) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($optLabel); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                <?php elseif ($type === 'file'): ?>
                                    <input class="crud-input" type="file" name="<?= $name; ?>" id="<?= $name; ?>" accept="image/*">
                                    <?php if ($editData && !empty($value)): ?>
                                        <small>File sekarang: <?= htmlspecialchars($value); ?></small>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <input class="crud-input" type="text" name="<?= $name; ?>" id="<?= $name; ?>"
                                           value="<?= htmlspecialchars($value); ?>">
                                <?php endif; ?>

                            <?php endforeach; ?>

                            <button type="submit" class="crud-button">
                                <?= $editId ? 'Update Data' : 'Simpan Data'; ?>
                            </button>
                        </form>
                    </div>

                    <!-- TABEL -->
                    <div class="crud-card">
                        <h3>Data <?= htmlspecialchars($cfg['title']); ?></h3>
                        <div class="crud-table-wrapper">
                            <table class="crud-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <?php foreach ($fields as $name => $f): ?>
                                        <th><?= htmlspecialchars($f['label']); ?></th>
                                    <?php endforeach; ?>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($data_result && $data_result->num_rows > 0):
                                    $no = 1;
                                    while ($row = $data_result->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <?php foreach ($fields as $name => $f): ?>
                                            <td><?= htmlspecialchars($row[$name]); ?></td>
                                        <?php endforeach; ?>
                                        <td>
                                            <a class="crud-link"
                                               href="admin_profile.php?tabel=<?= urlencode($tabel_aktif); ?>&edit=<?= $row[$primaryKey]; ?>">
                                                Edit
                                            </a>
                                            <a class="crud-link danger"
                                               href="admin_profile.php?tabel=<?= urlencode($tabel_aktif); ?>&hapus=<?= $row[$primaryKey]; ?>"
                                               onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    endwhile;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="<?= count($fields) + 2; ?>">Belum ada data.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </section>

        <!-- ASIDE: info singkat -->
        <aside>
            <div class="info-card">
                <h3>Tips Admin</h3>
                <ul>
                    <li>Pastikan NIM konsisten di semua tabel.</li>
                    <li>Gunakan tabel Users untuk mengganti foto & nama.</li>
                    <li>Biodata, Pendidikan, Pengalaman, Keahlian akan tampil di halaman profil utama.</li>
                </ul>
            </div>
        </aside>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-copyright">
                &copy; <?= date('Y'); ?> Sistem Profil Mahasiswa - Admin Panel
            </div>
        </div>
    </footer>

</div>
</body>
</html>
