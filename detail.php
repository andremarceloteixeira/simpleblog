<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT id, title, data, date FROM posts WHERE id = :id');
$stmt->execute(array(':id' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['id'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['title'];?></title>
</head>
<body>

	<div id="wrapper">

		<h1>Blog</h1>
		<hr />
		<p><a href="./">Blog Index</a></p>


		<?php	
			echo '<div>';
				echo '<h1>'.$row['title'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['date'])).'</p>';
				echo '<p>'.$row['data'].'</p>';				
			echo '</div>';
		?>

	</div>

</body>
</html>