<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$status = "";
if ($_GET["function"] === "do") {
    $inputFilterArgs = [
        'name' => FILTER_SANITIZE_STRING,
        'create_by' => FILTER_SANITIZE_STRING,
        'options' => FILTER_SANITIZE_STRING,
        'expected' => FILTER_SANITIZE_NUMBER_INT,
        'password' => FILTER_SANITIZE_STRING,
    ];

    $filteredInput = filter_input_array(INPUT_POST, $inputFilterArgs);
    // echo "<pre>" . print_r($filteredInput, true) . "</pre>";

    if ($config["admin"]["password"] === $filteredInput["password"]) {
        $sql = "SELECT * FROM poll WHERE open = '1'";
        if ($result = $db->query($sql)) {
            $row = $result->fetch_assoc();

            if ($row["name"] != "") {
                $status = "Es ist noch eine Umfrage offen!";
            }
            $result->close();
        }
        if ($status === "") { // Umfrage erstellen
            $sql = "INSERT INTO poll ("
                    . "name, created_by, options, expected,open"
                    . ") VALUES("
                    . "'{$filteredInput["name"]}',"
                    . "'{$filteredInput["create_by"]}',"
                    . "'{$filteredInput["options"]}',"
                    . "'{$filteredInput["expected"]}',"
                    . "'1'"
                    . ")";

            // echo "<pre>" . print_r($sql, true) . "</pre>";
            $db->query($sql);
        }
    } else {
        $status = "Password Falsch!";
    }
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
            Umfrage angelegt. Siehe hier
        </div>
        <?php
    }
}
?>

<form action="?action=create&function=do" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="Name der Umfrage" placeholder="Name der Umfrage" value="<?= $filteredInput["name"] ?>">
    </div>
    <div class="form-group">
        <label for="create_by">Ersteller</label>
        <input type="text" class="form-control" id="create_by" name="create_by" placeholder="Name der Umfrageerstellers" value="<?= $filteredInput["create_by"] ?>">
    </div>
    <div class="form-group">
        <label for="expected">Erwartete Teilnehmerzahl</label>
        <input type="number" class="form-control" id="expected" name="expected" placeholder="42" value="<?= $filteredInput["expected"] ?>">
    </div>

    <div class="form-group">
        <label for="options">Optionen (mit Komma getrennt)</label>
        <textarea class="form-control" id="options" name="options" rows="3" ></textarea>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="password">
    </div>
    <button type="submit" class="btn btn-primary">Erstellen</button>


</form>
