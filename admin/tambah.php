<?php
require_once "./vendor/autoload.php";


$pesan_error = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = new GUMP_Extended();

    // 1. Buat aturan validasinyo dulu
    $user->column("username")
        ->setValidation("required", "Username harus diisi!")
        ->setValidation("alpha_numeric", "Username tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("password")
        ->setValidation("required", "Password harus diisi!")
        ->setValidation("alpha_numeric", "Password tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("nama")
        ->setValidation("required", "Nama harus diisi!")
        ->setValidation("alpha", "Nama tidak valid!")
        ->setFilter("trim")
        ->setFilter("sanitize_string");

    $user->column("img1")
        ->setValidation("required_file", "Foto harus diisi!")
        ->setValidation("extension,jpg;gif;png", "Format harus jpg png gif!");



    // 2. lakukan validasi data
    if ($user->checkData(array_merge($_POST, $_FILES))->isError()) {
        // JIKA VALIDASI ERROR, MAKA JALAN KODE INI
        $pesan_error = $user->getErrorsArray(); // mengambil pesan error dan memasukkannya ke variabel $pesan_error
    } else {
        // JIKA DATA LOLOS VALIDASI, MAKA JALAN KODE INI
        $data = $user->getValidatedData(); // data yang sudah divalidasi dan difilter dimasukan ke variabel data, untuk selanjutnya dimasukan kedatabase


        try {
            $vimage1 = date('dmyHis') . "-" . $_FILES["img1"]["name"];
            $lokasi = $_FILES["img1"]["tmp_name"];
            move_uploaded_file($lokasi, "images/" . $vimage1);

            $query = $db->prepare("INSERT INTO tbl_admin (username,password, nama,foto) VALUES (:username,:password,:nama,:vimage1)");
            $query->bindParam(":username", $data['username']);
            $query->bindParam(":password", $data['password']);
            $query->bindParam(":nama", $data['nama']);
            $query->bindParam(':vimage1', $data['img1']['name']);
            $query->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
        echo "<script>
    window.location.href='?page=admin/tampil';
    </script>";
    }
}
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            Tambah Data Admin
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control" name="username">
                            <span style="color: red;"><?= $pesan_error['username'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control " name="password">
                            <span style="color: red;"><?= $pesan_error['password'] ?? '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama">
                            <span style="color: red;"><?= $pesan_error['nama'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="img1">
                            <span style="color: red;"><?= $pesan_error['foto'] ?? '' ?></span>
                        </div>
                        <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>