<?php
    include ('dbconnect.php');
?>
<?php  
if(isset($_POST['btn-view-card'])){
$title=$_POST['wasd'];
echo "<title>".$title."'s Profile</title>";
}?>