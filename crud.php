<?php
	include 'connection.php';
	$id 	= isset($_GET['id']) ? $_GET['id'] : '';

	if($id){
		$sql 	= "SELECT * FROM `artikel` WHERE id = ? ";
		$query 	= $pdo->prepare($sql);
		$query->execute(array($id));
		$artikel = $query->fetchAll();
	}

	$sql_select = "SELECT * FROM `artikel`";
	$query = $pdo->prepare($sql_select);
	$query->execute();
	$row = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CRUD</title>
</head>
<body>

<form method="post">
	<div>
		<label for="judul">Judul</label>
		<input type="text" name="judul" value="<?php echo $id ? $artikel[0]['judul'] : ''; ?>">
		<input type="hidden" name="id" value="<?php echo $id ? $artikel[0]['id'] : ''; ?>">	
	</div>
	<div>
		<label for="isi">Isi</label>
		<textarea name="isi" ><?php echo $id ? $artikel[0]['isi'] : ''; ?></textarea>
	</div>
	<button type="submit" name="submit"><?php echo $id ? 'Edit' : 'Tambah' ?> </button>
</form>
<?php
	foreach ($row as $data) { ?>
		<h3> <?php echo $data['judul'] ?> </h3>
		<p> <?php echo $data['isi'] ?> </p>
		<a href="crud.php?id=<?php echo $data['id']?>" > Update</a>
		<a href="delete.php?id=<?php echo $data['id']?>" > Delete</a>
		<hr>
	<?php }
?>
<?php
	if (isset($_POST['submit'])){
		$judul = $_POST['judul'];
		$isi = $_POST['isi'];
		$id = $_POST['id'];
		if($id){
			$sql_update = "UPDATE `artikel` SET `judul` = ?, `isi` = ? WHERE `id` = ?";
			$query = $pdo->prepare($sql_update);
			$query->bindParam(1, $judul);
			$query->bindParam(2, $isi);
			$query->bindParam(3, $id);
			if($query->execute()){
				header('Location: crud.php');
			}
		}else{
			$sql_insert = "INSERT INTO `artikel` (`judul`,`isi`) VALUES (?,?)";
			$query = $pdo->prepare($sql_insert);
			$query->bindParam(1, $judul);
			$query->bindParam(2, $isi);
			if($query->execute()){
				header('Location: crud.php');
			}
		}
		
	}
?>
	
</body>
</html>