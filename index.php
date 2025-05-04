
<?php
$pengajuan = file_exists("../pengajuan.json") ? json_decode(file_get_contents("../pengajuan.json"), true) : null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pengajuan['status'] = $_POST['aksi'] == "setuju" ? "Disetujui" : "Ditolak";
    file_put_contents("../pengajuan.json", json_encode($pengajuan));
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Gadai</title></head>
<body>
<h2>Panel Admin</h2>
<?php if ($pengajuan): ?>
<form method="POST">
    <h3>Detail Pengajuan</h3>
    Nama: <?= $pengajuan['nama'] ?><br>
    Koin: <?= $pengajuan['koin'] ?><br>
    Jumlah: <?= $pengajuan['jumlah'] ?><br>
    Lama Gadai: <?= $pengajuan['lama'] ?> hari<br>
    Harga: $<?= $pengajuan['harga'] ?><br>
    Status: <?= $pengajuan['status'] ?><br>
    <button type="submit" name="aksi" value="setuju">Setujui</button>
    <button type="submit" name="aksi" value="tolak">Tolak</button>
</form>
<?php else: ?>
<p>Tidak ada pengajuan.</p>
<?php endif; ?>
</body>
</html>
