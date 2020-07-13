<?php


require_once "./vendor/autoload.php";


$pesan_error = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = new GUMP_Extended();

    // 1. Buat aturan validasinyo dulu
    $user->column("nis")
        ->setValidation("required", "Nis harus diisi!")
        ->setValidation("alpha_numeric", "Nis tidak valid!")
        ->setValidation("exact_len,6", "Nis harus 6 karakter!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("nama")
        ->setValidation("required", "Nama tidak valid!")
        ->setValidation("alpha", "Nama tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("alamat")
        ->setValidation("required", "Alamat tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("kelas")
        ->setValidation("numeric", "Kelas tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");



    // 2. lakukan validasi data
    if ($user->checkData($_POST)->isError()) {
        // JIKA VALIDASI ERROR, MAKA JALAN KODE INI
        $pesan_error = $user->getErrorsArray(); // mengambil pesan error dan memasukkannya ke variabel $pesan_error
    } else {
        // JIKA DATA LOLOS VALIDASI, MAKA JALAN KODE INI
        $data = $user->getValidatedData(); // data yang sudah divalidasi dan difilter dimasukan ke variabel data, untuk selanjutnya dimasukan kedatabase


        try {
            $query = $db->prepare("INSERT INTO tbl_siswa (nis,nama, alamat, kelas) VALUES (:nis,:nama,:alamat,:kelas)");
            $query->bindParam(":nis", $data['nis']);
            $query->bindParam(":nama", $data['nama']);
            $query->bindParam(":alamat", $data['alamat']);
            $query->bindParam(":kelas", $data['kelas']);
            $query->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }

        echo "<script>
            window.location.href='?page=siswa/tampil';
            </script>";
    }
}
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            Tambah Data Siswa
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">NIS</label>
                            <input type="text" class="form-control" name="nis" required>
                            <span style="color: red;"><?= $pesan_error['nis'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control " name="nama">
                            <span style="color: red;"><?= $pesan_error['nama'] ?? '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" name="alamat">
                            <span style="color: red;"><?= $pesan_error['alamat'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Kelas</label>
                            <input type="number" class="form-control" name="kelas">
                            <span style="color: red;"><?= $pesan_error['kelas'] ?? '' ?></span>
                        </div>
                        <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>