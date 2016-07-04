<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Post</title>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Add Post</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );
		//collect form data
		extract($_POST);

		//very basic validation
		if($title ==''){
			$error[] = 'Please enter the title.';
		}

		if($data ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO posts (title,data,date) VALUES (:title, :data, :date)') ;
				$stmt->execute(array(
					':title' => $title,
					':data' => $data,
					':date' => date('Y-m-d H:i:s')
				));

				//redirect to index page
				header('Location: index.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Title</label><br />
		<input type='text' name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>

		<p><label>Content</label><br />
                    <textarea maxlength="50" name='data' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['data'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
