<?php 
    // pemgangilan data
    try{
    $query = $db->prepare("SELECT * FROM tbl_siswa WHERE nis=:nis");
    $query->bindParam(":nis", $_GET['nis']);
    $query->execute();
    // cek data di tabel jika kosong
    if($query->rowCount() == 0){
        die("Error: NIS Tidak Ditemukan");
    }else{
        // jika data di tabel ada
        $data = $query->fetch(PDO::FETCH_OBJ);
    }
    // query update
    if(isset($_POST['edit'])){
            
            $query = $db->prepare("UPDATE `tbl_siswa` SET `nama`=:nama,`alamat`=:alamat,`kelas`=:kelas WHERE nis=:nis");
            $query->bindParam(":nama", $_POST['nama']);
            $query->bindParam(":alamat", $_POST['alamat']);
            $query->bindParam(":kelas", $_POST['kelas']);
            $query->bindParam(":nis", $_GET['nis']);
            $query->execute();
            
                echo"<script>
                window.location.href='?page=siswa/tampil';
                </script>";
            }
        }
        catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
        exit;
    }

?>

<div class="container">
<form action="" method="POST">

<div class="form-group">
<label for="">Nama</label>
<input type="text" value="<?= $data->nama?>" name="nama" class="form-control">
</div>

<div class="form-group">
<label for="">Alamat</label>
<input type="text" value="<?= $data->alamat?>" name="alamat" class="form-control">
</div>

<div class="form-group">
<label for="">Kelas</label>
<input type="number" value="<?= $data->kelas?>" name="kelas" class="form-control">
</div>

<div class="form-group">
<button class="btn btn-success" type="submit" name="edit">Edit Data</button>
</div>
</form>
</div>