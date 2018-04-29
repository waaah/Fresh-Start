<!DOCTYPE html>
<html>
<body>

<?php
$file =  file_get_contents('SimulationsNew.txt');
$lines = explode("\r\n", $file);
foreach ($lines as $line) {
	print $line ."<br>";
}
//this is for importing the file 
$text = "This is the long text\r\n\tSo please don't judge";
$myfile1 = file_put_contents('SimulationsNew.txt', $text);

?>

</body>
</html>