<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$polls = array();

$sql = "SELECT * FROM poll ORDER BY ID ";
if ($result = $db->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $polls[$row["ID"]] = $row["name"];
    }
    $result->close();
}
//// echo "<pre>ID: " . print_r($polls, true) . "</pre>";
?>

<ul class="list-group">
    <?php
    foreach($polls as $id => $name){
    ?>
        <li class="list-group-item">
            <a href="?action=show&id=<?=$id?>"><?=$name?></a>
        </li>
    <?php 
    }
    ?>

</ul>