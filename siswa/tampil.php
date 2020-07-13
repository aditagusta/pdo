<?php
try {
    $query = $db->prepare("SELECT * FROM tbl_siswa");
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
            Siswa <a href="?page=siswa/tambah" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">NIS</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">ALAMAT</th>
                        <th scope="col">KELAS</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $tampil) : ?>
                        <tr>
                            <td><?= $tampil->nis; ?></td>
                            <td><?= $tampil->nama ?></td>
                            <td><?= $tampil->alamat ?></td>
                            <td><?= $tampil->kelas ?></td>
                            <td>
                                <a href="?page=siswa/edit&nis=<?= $tampil->nis ?>" class="btn btn-warning"> Edit</a> |
                                <a href="?page=siswa/hapus&nis=<?= $tampil->nis ?>" class="btn btn-danger"> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>