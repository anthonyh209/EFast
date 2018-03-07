<?php include 'config.php'; ?>
<?php
$partialStates = $_POST['partialState'];
$query = 'SELECT TITLE FROM item WHERE TITLE LIKE "%'.$partialStates.'%"';


$result = $conn->query($query);
$data = $result->fetch_all();
foreach($data as $row){
    echo "<div  align='center'>".$row[0]."</div>";
}
?>