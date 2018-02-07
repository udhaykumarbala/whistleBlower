<?php
include_once 'config.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>whistle blower</title>
</head>
<body>
<form method="post" action="save.php">
    <label>Title</label>
	<input type="text" name="title" placeholder="TITLE">
	<br>
	<label>Department</label>
	<select>
		<?php
           include "config.php";
           $result = mysqli_query($link, "SELECT name FROM department ");
           while ($row = mysqli_fetch_array($result)) 
           {
           ?>

        
        <option value="<?php echo $row['id'];?>" > <?php echo $row['name']; ?> </option>

<?php      
}

?>
	</select>
	<br>
	<label>Description</label>
	<textarea name="description"></textarea>
	<br>
	<label>Notes</label>
	<textarea name="notes"></textarea>
	<br>
	<input type="file" name="fileToUpload" id="fileToUpload">
	<br>
	<input type="submit" name="submit">
</form>




</body>
</html>