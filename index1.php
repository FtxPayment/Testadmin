
<?php
$coins = json_decode(file_get_contents("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&per_page=250&page=1"), true);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'nama' => $_POST['nama'],
        'koin' => $_POST['koin'],
        'jumlah' => $_POST['jumlah'],
        'lama' => $_POST['lama'],
        'harga' => $_POST['harga'],
        'status' => 'Menunggu persetujuan'
    ];
    file_put_contents("../pengajuan.json", json_encode($data));
}
$pengajuan = file_exists("../pengajuan.json") ? json_decode(file_get_contents("../pengajuan.json"), true) : null;
?>
<!DOCTYPE html>
<html>
<head><title>Form Gadai Crypto</title></head>
<body>
<h2>Form Gadai Crypto</h2>
<form method="POST">
    Nama: <input type="text" name="nama" required><br>
    Pilih Koin:
    <select name="koin" required onchange="updateHarga(this)">
        <?php foreach ($coins as $coin): ?>
            <option value="<?= $coin['id'] ?>" data-harga="<?= $coin['current_price'] ?>"><?= $coin['name'] ?> - $<?= $coin['current_price'] ?></option>
        <?php endforeach; ?>
    </select><br>
    Jumlah Koin: <input type="number" name="jumlah" step="0.0001" required><br>
    Lama Gadai: <select name="lama">
        <?php for ($i = 7; $i <= 90; $i += 7) echo "<option value='$i'>$i hari</option>"; ?>
    </select><br>
    <input type="hidden" name="harga" id="harga_input" value="">
    <button type="submit">Ajukan</button>
</form>

<script>
function updateHarga(select) {
    var harga = select.options[select.selectedIndex].getAttribute("data-harga");
    document.getElementById("harga_input").value = harga;
}
</script>

<?php if ($pengajuan): ?>
<hr>
<h3>Detail Pengajuan</h3>
Nama: <?= $pengajuan['nama'] ?><br>
Koin: <?= $pengajuan['koin'] ?><br>
Jumlah: <?= $pengajuan['jumlah'] ?><br>
Lama Gadai: <?= $pengajuan['lama'] ?> hari<br>
Status: <?= $pengajuan['status'] ?><br>
<?php if ($pengajuan['status'] == "Disetujui"): ?>
<a href="https://wa.me/628567624130" target="_blank">Hubungi via WhatsApp</a>
<?php endif; ?>
<?php endif; ?>
</body>
</html>
