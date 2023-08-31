<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$status == "";
$name = "";
$sql = "SELECT * FROM poll WHERE open = '1'";
if ($result = $db->query($sql)) {
    $row = $result->fetch_assoc();

    if ($row["name"] == "") {
        $status = "Es ist gerade keine Wahl offen!";
    }
    $name = $row["name"];
    $result->close();
}

if ($status) {
    if (str_replace("Eine Antwort wurde aufgenommen.<br>", "", $status) !== "") {
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $status ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success" role="alert">
            Deine Stimme(n) wurde(n) gezählt. Vielen Dank!
        </div>
        <?php
    }
} else {
    ?>

    <h4><?= $name ?></h4>
<div>
    <p>
        Wenn du Stimmrechtsübertragungen hast, wähle bitte aus, wie viele Stimmen du damit insgesamt hast.
    </p>
</div>
<form action="?action=vote" method="post">

    <div class="form-group">
        <label for="vote_count">Anzahl Stimmen gesamt</label>
        <select class="form-control" id="vote_count" name="vote_count">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Wahl starten</button>
    </div>
</form>
<?php } ?>