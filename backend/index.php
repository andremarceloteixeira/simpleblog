<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delete'])){ 

	$stmt = $db->prepare('DELETE FROM posts WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delete']));

	header('Location: index.php?action=delete');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?delete=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT id, title, date FROM posts ORDER BY id DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['title'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['date'])).'</td>';
				?>

				<td>
					<a href="edit.php?id=<?php echo $row['id'];?>">Edit</a> | 
					<a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add.php'>Add Post</a></p>

</div>

</body>
</html>
