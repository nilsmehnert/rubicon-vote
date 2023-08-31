<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$status = "";
$vote_prep = array();
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


if ($status == "") {
    if ($_GET["function"] === "do") {
        $inputFilterArgs = [
            'poll_id[]' => FILTER_SANITIZE_STRING,
            'session_id[]' => FILTER_SANITIZE_NUMBER_INT,
            'answer[]' => FILTER_SANITIZE_STRING,
        ];

        $poll_ids = filter_input(INPUT_POST, 'poll_id', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $session_ids = filter_input(INPUT_POST, 'session_id', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $answers = filter_input(INPUT_POST, 'answer', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        // echo "<pre>" . print_r($poll_ids, true) . "</pre>";
        // echo "<pre>" . print_r($session_ids, true) . "</pre>";
        // echo "<pre>" . print_r($answers, true) . "</pre>";

        
        
        $sql = "SELECT * FROM poll WHERE open = '1'";
        if ($result = $db->query($sql)) {
            $row = $result->fetch_assoc();
            $poll_id = $row["ID"];
            $result->close();
        }
        
        for($i = 0; $i < count($poll_ids); $i++){
            if($poll_id != $poll_ids[$i]){
                $status = "Eine der Umfrage-IDs ist falsch.<br>";
            }else{
                $sql = "INSERT INTO vote ("
                        . "poll_id, answer, session_id, datum"
                        . ") VALUES("
                        . "'{$poll_ids[$i]}',"
                        . "'{$answers[$i]}',"
                        . "'{$session_ids[$i]}',"
                        . "NOW()"
                        . ") ON DUPLICATE KEY UPDATE answer = '{$answers[$i]}'";

                // echo "<pre>" . print_r($sql, true) . "</pre>";
                $db->query($sql);
                $status .= "Eine Antwort wurde aufgenommen.<br>";
            }
        }
        
    } else {

        // Wahl vorbereiten
        $optionen = "";
        $poll_id = "";

        $inputFilterArgs = [
            'vote_count' => FILTER_SANITIZE_NUMBER_INT,
        ];

        $filteredInput = filter_input_array(INPUT_POST, $inputFilterArgs);
        // echo "<pre>" . print_r($filteredInput, true) . "</pre>";

        $sql = "SELECT * FROM poll WHERE open = '1'";
        if ($result = $db->query($sql)) {
            $row = $result->fetch_assoc();
            $optionen = $row["options"];
            $optionen = explode(",", $optionen);
            $poll_id = $row["ID"];
            $result->close();
        }


        for ($i = 0; $i < $filteredInput["vote_count"]; $i++) {
            $session_id = $config["session"]["session_id"] . "_" . $i;
            $session_id = hash('sha256', $session_id);

            $vote_prep[$i]["session_id"] = $session_id;
            $vote_prep[$i]["poll_id"] = $poll_id;
            $vote_prep[$i]["optionen"] = $optionen;
        }
        
        
    }
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
    <form action="?action=vote&function=do" method="post">

        <?php
            foreach ($vote_prep as $num => $vote){
        ?>
        <div class="form-group">
            <label for="vote[<?=$num?>]">Stimme <?=($num + 1)?></label>
            <select class="form-control" name="answer[<?=$num?>]">
                <option>Enthaltung</option>
                <?php
                    foreach( $vote["optionen"] as $option){
                        ?>
                            <option><?=trim($option)?></option>
                        <?php
                    }
                ?>
                <option>Ungültig</option>
            </select>
            <input type="hidden" name="session_id[<?=$num?>]" value="<?=$vote["session_id"]?>">
            <input type="hidden" name="poll_id[<?=$num?>]" value="<?=$vote["poll_id"]?>">
        </div>

        <?php
            }
        ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Stimme(n) abgeben</button>
        </div>


    </form>

    <?php
}
?>