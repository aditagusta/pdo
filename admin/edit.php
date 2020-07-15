<?php
// pemgangilan data
try {
    $query = $db->prepare("SELECT * FROM tbl_admin WHERE id_admin=:id");
    $query->bindParam(":id", $_GET['id']);
    $query->execute();
    // cek data di tabel jika kosong
    if ($query->rowCount() == 0) {
        die("Error: Data Tidak Ditemukan");
    } else {
        // jika data di tabel ada
        $data = $query->fetch(PDO::FETCH_OBJ);
    }
    // query update
    if (isset($_POST['edit'])) {
        if ($_FILES['foto']['size'] > 0) {
            $foto = $data->foto;

            unlink("images/" . $foto);
            $namafoto = date('dmyHis') . "-" . $_FILES["foto"]["name"];
            $lokasi = $_FILES["foto"]["tmp_name"];
            move_uploaded_file($lokasi, "images/" . $namafoto);
            $query = $db->prepare("UPDATE tbl_admin SET username = :username, password = :password, nama = :nama, foto = :namafoto WHERE id_admin = :id");
            $query->bindParam(":namafoto", $namafoto);
        } else {
            $query = $db->prepare("UPDATE tbl_admin SET username = :username, password = :password, nama = :nama WHERE id_admin = :id");
        }

        $query->bindParam(":username", $_POST['username']);
        $query->bindParam(":password", $_POST['password']);
        $query->bindParam(":nama", $_POST['nama']);
        $query->bindParam(":namafoto", $namafoto);
        $query->bindParam(":id", $_GET['id']);
        $query->execute();

        echo "<script>
                window.location.href='?page=admin/tampil';
                </script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>

<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="">Username</label>
            <input type="text" value="<?= $data->username ?>" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Password</label>
            <input type="password" value="<?= $data->password ?>" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" value="<?= $data->nama ?>" name="nama" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Foto</label>
            <input type="file" name="foto" class="form-control"><?= $data->foto ?>
        </div>

        <div class="form-group">
            <button class="btn btn-success" type="submit" name="edit">Edit Data</button>
        </div>
    </form>
</div>