<?php 
try{
    if(isset($_GET["nis"])){
    $query = $db->prepare("DELETE FROM tbl_siswa WHERE nis=:nis");
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