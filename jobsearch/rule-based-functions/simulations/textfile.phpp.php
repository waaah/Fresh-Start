<!DOCTYPE html>
<html>
<body>

<?php
$myfile = fopen("Simulations.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("Simulations.txt"));
fclose($myfile);
?>

</body>
</html>