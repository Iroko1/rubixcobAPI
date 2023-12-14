<?php

header('Content-Type: application/json');
session_start();
include "../model/apiKey.php";
include "../model/rubicoob_db.php";

if (isset($_GET['APIKey'])) {
    if (!validateKey(filter_input(INPUT_GET, 'APIKey'))) {
        echo json_encode(['error' => 'Invalid API Key']);
        exit();
    }
}
if (isset($_GET['length'])) {
    $result = json_encode(scramble(filter_input(INPUT_GET, 'length')));
    echo $result;
    recordRequest($_SESSION['email'], $_SESSION['key'], date("Y-m-d H:i:s"), $result);
    exit();
} else {
    $result = json_encode(scramble(20));
    echo $result;
    recordRequest($_SESSION['email'], $_SESSION['key'], date("Y-m-d H:i:s"), $result);
    exit();
}




function lastid($ls, $item) {
    $ls = array_reverse($ls);
    foreach ($ls as $i => $value) {
        if ($value[0] == $item) {
            $ls = array_reverse($ls);
            return [true, ($i + 1) * -1];
        }
    }
    $ls = array_reverse($ls);
    return [false, 0];
}

// makes a scramble list (robot instructions)
function scramble($num) {
    $scramblelist = [];
    $moveset = ['U', 'D', 'L', 'R', 'F', 'B', 
                'U2', 'D2', 'L2', 'R2', 'F2', 'B2', 
                "U'", "D'", "L'", "R'", "F'", "B'"];
    $restrict = [
        'U' => ['D', "D'", 'D2'],
        'D' => ['U', "U'", 'U2'],
        'L' => ['R', "R'", 'R2'],
        'R' => ['L', "L'", 'L2'],
        'F' => ['B', "B'", 'B2'],
        'B' => ['F', "F'", 'F2'],
    ];

    while (count($scramblelist) < $num) {
        $move = $moveset[rand(0, count($moveset) - 1)];
        if (empty($scramblelist)) {
            if ($move != 'D' && $move != 'D2' && $move != "D'") {
                $scramblelist[] = $move;
            }
            continue;
        }
        if ($move[0] != $scramblelist[count($scramblelist) - 1][0]) {
            [$_, $index] = lastid($scramblelist, $move[0]);
            $stop = false;
            if ($_ ) {
                foreach (array_slice($scramblelist, $index + 1) as $i) {
                    foreach ($restrict[$move[0]] as $n) {
                        if ($i[0] == $n) {
                            $stop = true;
                            break;
                        }
                    }
                    if ($stop) {
                        $scramblelist[] = $move;
                        break;
                    }
                }
            } else {
                $scramblelist[] = $move;
            }
        }
    }

    return $scramblelist;
}

?>