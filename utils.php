<!-- Code for Nav-Bar -->
<!DOCTYPE html>

<head>
    <title>Meal Planer</title>
    <?php
    include 'login.php';

    $GLOBALS['connection'] = mysqli_connect($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    if (!$GLOBALS['connection']) {
        die('Could not connect: '. mysqli_connect_error());
    }
    $GLOBALS['Monday_Date'] = date("Y-m-d", strtotime("this Monday"));

    $GLOBALS['Days'] = [];
    $query = "SELECT * FROM day";
    foreach(mysqli_query($GLOBALS['connection'], $query) as $row) {
        array_push($GLOBALS['Days'], $row);
    }

    $GLOBALS['Personlength'] = mysqli_num_rows(mysqli_query($GLOBALS['connection'], "SELECT * FROM person"));

    function createHeader(){

    }

    function getFoodAndPersonAtSpecificDate($date){
        //todo: Validate
        $startDate = date("Y-m-d", strtotime("this Monday", strtotime($date)));
        $endDate = date("Y-m-d", strtotime("this Sunday", strtotime($date)));

        $query = "SELECT w.food_id, f.food_name, pw.person_id, p.person_name, w.day_id
        FROM week w
        INNER JOIN personweek pw on w.week_id = pw.week_id
        INNER JOIN person p on pw.person_id = p.person_id
        INNER JOIN food f on w.food_id = f.food_id
        WHERE w.date BETWEEN '$startDate' AND '$endDate'";

        $result = mysqli_query($GLOBALS['connection'], $query);
        $foodAndPersonArray = [];

        foreach($result as $row){
            array_push($foodAndPersonArray, $row);
        }

        return $foodAndPersonArray;
    }
    ?>
</head>