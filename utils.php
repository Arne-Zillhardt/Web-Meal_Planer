<!-- Code for Nav-Bar -->
<!-- Validate -->
<!DOCTYPE html>

<head>
    <title>Meal Planer</title>
    <?php
    include 'login.php';

    $GLOBALS['connection'] = mysqli_connect($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    if (!$GLOBALS['connection']) {
        die('Could not connect: '. mysqli_connect_error());
    }
    $GLOBALS['Monday_Date'] = date("Y-m-d", strtotime('monday this week'));

    $GLOBALS['Days'] = [];
    $query = "SELECT * FROM day";
    $result = mysqli_query($GLOBALS['connection'], $query);
    foreach($result as $row) {
        array_push($GLOBALS['Days'], [$row['day_id'], $row['day_name']]);
    }

    $GLOBALS['Foods'] = [];
    $query = "SELECT * FROM food";
    $result = mysqli_query($GLOBALS['connection'], $query);
    foreach($result as $row) {
        array_push($GLOBALS['Foods'], [$row['food_id'], $row['food_name']]);
    }

    $GLOBALS['Personlength'] = mysqli_num_rows(mysqli_query($GLOBALS['connection'], "SELECT * FROM person"));

    function createHeader(){
        echo '<th></th>';

        $query = "SELECT person_name FROM person";
        foreach(mysqli_query($GLOBALS['connection'], $query) as $row) {
            echo '<th>'. $row['person_name']. '</th>';
        }
    }

    function getFoodAndPersonAtSpecificDate($date){
        $startDate = date("Y-m-d", strtotime("monday this week", strtotime($date)));
        $endDate = date("Y-m-d", strtotime("sunday this week", strtotime($date)));

        $query = "SELECT df.food_id, f.food_name, pdf.person_id, p.person_name, df.day_id
        FROM day_food df
        INNER JOIN person_day_food pdf on df.day_food_id = pdf.day_food_id
        INNER JOIN person p on pdf.person_id = p.person_id
        INNER JOIN food f on df.food_id = f.food_id
        WHERE pdf.date BETWEEN '$startDate' AND '$endDate'";

        $result = mysqli_query($GLOBALS['connection'], $query);
        $foodAndPersonArray = [];

        foreach($result as $row){
            array_push($foodAndPersonArray, [$row['food_id'], $row['food_name'], $row['person_id'], $row['person_name'], $row['day_id']]);
        }

        return $foodAndPersonArray;
    }

    function insertFoodAndPerson($foodAndPersonArray){
        foreach($foodAndPersonArray as $foodAndPerson){
            $personId = $foodAndPerson[0];
            $dayId = $foodAndPerson[1];
            $foodId = $foodAndPerson[2];
            if($foodId == -1){
                $foodId = "null";
            }

            $date = $foodAndPerson[3];

            $query = "SELECT * FROM day_food df
            INNER JOIN person_day_food pdf on df.day_food_id = pdf.day_food_id
            WHERE pdf.person_id = $personId AND 
            pdf.date = $date AND
            df.day_id = $dayId";

            if(mysqli_num_rows(mysqli_query($GLOBALS['connection'], $query)) == 1){
                $query = "UPDATE day_food
                SET food_id = $foodId WHERE
                day_food_id = (
                    SELECT day_food_id FROM person_day_food 
                    WHERE person_id = $personId AND 
                    date = $date
                )";

                mysqli_query($GLOBALS['connection'], $query);
                echo $query;
            }else {
                $query = "INSERT INTO day_food(day_id, food_id) VALUES
                ($dayId, $foodId)";

                mysqli_query($GLOBALS['connection'], $query);

                $query = "SELECT day_food_id FROM day_food 
                ORDER BY day_food_id DESC LIMIT 1";
                $day_food_id = mysqli_fetch_array(mysqli_query($GLOBALS['connection'], $query))['day_food_id'];

                $query = "INSERT INTO person_day_food(person_id, day_food_id, date) VALUES
                ($personId, $day_food_id, '$date')";

                mysqli_query($GLOBALS['connection'], $query);
            }
        }
    }
    ?>
</head>