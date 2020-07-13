<?php
	session_start();
	if(empty($_SESSION['admin'])) {
		echo "<script> 
		alert('Anda harus login');
		window.location.href='login.php';
		</script>";
	}
	include "koneksi.php";
?>

<?php
//panggil koneksi terlebih dahulu agar semua file dapat mengakses database
include "koneksi.php";
include "template/header.php";
include "template/menu.php";
?>
<!-- coding dibawah untuk membuat halaman dinamis -->
<div class="container-fluid">
<?php
if(!empty($_GET['page']))
{
    include_once($_GET['page'].".php");
}else{
    include "home.php";
}
?>
</div>
<?php 
include "template/footer.php" 
?>
