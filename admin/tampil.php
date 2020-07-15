<?php
try {
    $query = $db->prepare("SELECT * FROM tbl_admin");
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            Admin <a href="?page=admin/tambah" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $tampil) : ?>
                        <tr>
                            <td><?= $tampil->username; ?></td>
                            <td><?= $tampil->password ?></td>
                            <td><?= $tampil->nama ?></td>
                            <td><img src="images/<?php echo $tampil->foto ?>" class="img-fluid" alt=""></td>
                            <td>
                                <a href="?page=admin/edit&id=<?= $tampil->id_admin ?>" class="btn btn-warning"> Edit</a> |
                                <a href="?page=admin/hapus&id=<?= $tampil->id_admin ?>" class="btn btn-danger"> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>