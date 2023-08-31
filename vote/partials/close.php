<?php

if($_GET["pw"] != $config["admin"]["password"]){
    exit;
}
$sql = "SELECT * FROM poll WHERE open = '1'";
if ($result = $db->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["ID"];
        
        $sql="UPDATE vote SET session_id = '' WHERE poll_id = '$id'";
        $db->query($sql);
        
        $sql="UPDATE poll SET open = '0' WHERE ID = '$id'";
        $db->query($sql);
        
        $status = "done";
    }
    $result->close();
} else {
    $status = "nichts zum schließen da.";
}


if ($status) {
    if ($status !== "done") {
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $status ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success" role="alert">
            Umfrage geschlossen. Auswertung: hier
        </div>
        <?php
    }
}
?>