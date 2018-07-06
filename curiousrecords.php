<?php 
include("yellconnect-db.php");
function renderForm($name ='', $desc = '', $price = '', $error = '', $id = '')
{ ?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php 
		if ($id != '') {
			echo "Edit the damned record!";
		} 
		else
		{
			echo "Add a new bloody record!";
		}

		?></title>
	</head>
	<body>
		<h1><?php 
		if ($id != '') {
			echo "Edit the damned record!";
		} 
		else
		{
			echo "Add a new bloody record!";
		}

		?></h1>
		<?php if ($error != '') {
			echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
			. "</div>";
		} ?>
		<form action="" method="post">
			<div>
				<?php if ($id != '') { ?>
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<p>ID: <?php echo $id; ?></p>
				<?php } ?>

				<strong>Name: *</strong> <input type="text" name="name"
				value="<?php echo $name; ?>"/><br/>
				<strong>Description: *</strong> <input type="text" name="description"
				value="<?php echo $desc; ?>"/>
				<strong>Price: *</strong> <input type="float" name="price"
				value="<?php echo $price; ?>"/>
				<p>* required</p>
				<input type="submit" name="submit" value="Submit" />
			</div>


		</form>

	</body>
	</html>
<?php 
}

	if (isset($_GET['id'])) 
	{

		if (isset($_POST['submit'])) 
		{
			if (is_numeric($_POST['id']))
				// get variables from the URL/form
			{
				$id = $_POST['id'];
				$name = htmlentities($_POST['name'], ENT_QUOTES);
				$description = htmlentities($_POST['description'], ENT_QUOTES);
				$price = htmlentities($_POST['price'], ENT_QUOTES);

				if ($name == "" ||  $description == "" || $price == "") 
				{
				$error = 'Error: Complete the form!';
				renderForm($name, $description, $price, $error, $id);
				}
				else
				{
					// if everything is fine, update the record in the database
					if ($stmt = $mysqli->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?"))
					{
						$stmt->bind_param("ssdi", $name, $description, $price, $id);
						$stmt->execute();
						$stmt->close();
					}
					else
					{
						echo "ERROR: could not prepare SQL statement";
					}
					header("Location: yellview.php");
				}
			
			}
			else
			{
				echo "Error!";
			}
		}
		else
		{

			//editing existing record
					if (is_numeric($_GET['id']) && $_GET['id'] > 0) 
					{
	 						//query database get id from url
						$id = $_GET['id'];
						if ($stmt = $mysqli->prepare("SELECT * FROM products WHERE id=?"))
						{
							//binding
							$stmt->bind_param("i", $id);
							$stmt->execute();

							$stmt->bind_result($id, $name, $description, $price);
							$stmt->fetch();
							// show the form

							renderForm($name, $description, $price, NULL, $id);

							$stmt->close();
						}
						else
						{
							echo "ERROR: unable to prepare SQL statement.";
						}

					}
					else

					{
						header("Location: yellview.php");
					}

		}
	}
	else
	{
		//create new record

		if (isset($_POST['submit']))
		{

			$name = htmlentities($_POST['name'], ENT_QUOTES);
			$description = htmlentities($_POST['description'], ENT_QUOTES);
			$price = htmlentities($_POST['price'], ENT_QUOTES);



			if($name == "" ||  $description == "" || $price == "") 
			{
				$error = 'Error: Complete the form!';
				renderForm($name, $description, $price, $error);
			}
			else
			{
				if($stmt = $mysqli->prepare("INSERT products(name, description, price) VALUES (?, ?, ?)")) 
				{
					$stmt->bind_param("ssd", $name, $description, $price);
					$stmt->execute();
					$stmt->close();
				}

				else
				{
					echo "ERROR: could not prepare SQL statement.";
				}
				header("Location: yellview.php");	
			}
		}
		else
		{
			//create new record
			renderForm();
		}
	}
	$mysqli->close();

	?>