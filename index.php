<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog frontend</title>
</head>
<body>
	<div id="wrapper">
		<h1>Frontend</h1>
		<hr />
		<?php
			try {

				$stmt = $db->query('SELECT id, title, data, date FROM posts ORDER BY id DESC LIMIT 5');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="detail.php?id='.$row['id'].'">'.$row['title'].'</a></h1>';
						echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['date'])).'</p>';
						echo '<p>'.substr($row['data'], 0, 99).'</p>';				
						echo '<p><a href="detail.php?id='.$row['id'].'">View</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
	</div>
</body>
</html>