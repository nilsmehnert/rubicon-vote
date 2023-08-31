<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$inputFilterArgs = [
    'id' => FILTER_SANITIZE_NUMBER_INT
];

$filteredInput = filter_input_array(INPUT_GET, $inputFilterArgs);
// echo "<pre>" . print_r($filteredInput, true) . "</pre>";
$id = $filteredInput["id"];

if ($id == 0) {
    $sql = "SELECT * FROM poll ORDER BY ID DESC LIMIT 1";
    if ($result = $db->query($sql)) {
        $row = $result->fetch_assoc();

        $id = $row["ID"];
        $result->close();
    }
}
// echo "<pre>ID: " . print_r($id, true) . "</pre>";
// Wahl auswerten

$expected = 0;
$count = 0;
$full_results = array();
$accumulated_results = array();
$open = 0;

$sql = "SELECT * FROM poll WHERE ID = '$id'";
if ($result = $db->query($sql)) {
    $row = $result->fetch_assoc();
    $expected = $row["expected"];
    $open = $row["open"];
    $name = $row["name"];

    $result->close();
}
$sql = "SELECT * FROM vote WHERE poll_id = '$id' ORDER BY answer ASC";
if ($result = $db->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $count++;
        $full_results[] = $row["answer"];
        $accumulated_results[$row["answer"]] ++;
    };

    $result->close();
}

if ($count == sizeof($full_results) && $count == array_sum($accumulated_results) && $count > 0 && $count == $expected) {
    
} else {
    $status = "Die Ergebnisse passen nicht zusammen!";
}
?>
<div class="container">
    <?php
    if ($status) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $status ?>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-sm">
            &nbsp;
        </div>
        <div class="col-sm">
            <h4><?= $name ?></h4>
        </div>
        <div class="col-sm">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            &nbsp;
        </div>
        <div class="col-sm">
            <p>Erwartete Zahl an Ergebnissen: <?= $expected ?></p>
        </div>
        <div class="col-sm">
            <p>Gesamtzahl an Ergebnissen: <?= $count ?></p>
        </div>
        <div class="col-sm">
            &nbsp;
        </div>
    </div>
    <?php
    if (!$open) {
        ?>
        <div class = "row">
            <div class = "col-sm">
                &nbsp;
            </div>
            <div class = "col-sm">
                <p>Gesamtliste:</p>
                <ul class = "list-group">
                    <?php
                    foreach ($full_results as $answer) {
                        echo "<li class='list-group-item'>$answer</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm">
                <p>akkumulierte Liste:</p>
                <table class="table">
                    <tr>
                        <th>
                            Antwort
                        </th>
                        <th>
                            Anzahl
                        </th>
                    </tr>
                    <?php
                    foreach ($accumulated_results as $answer => $anzahl) {
                        echo "<tr><td>$answer</td><td>$anzahl</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="col-sm">
                &nbsp;
            </div>
        </div>

        <?php
    }
    if ($open) {
        ?>
        <div class="alert alert-danger" role="alert">
            Die Wahl ist noch offen.
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success" role="alert">
            die Wahl ist bereits geschlossen.
        </div>
        <?php
    }
    ?>
</div>