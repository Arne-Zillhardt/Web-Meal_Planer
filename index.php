<!DOCTYPE html>

<head>
    <?php include 'utils.php'; ?>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="grid-container">
        <table>
            <?php
            $queryDay = 'SELECT * FROM  day';
            $queryPerson = 'SELECT * FROM person';
            $foodArray = [];
                        
            $resultDay = mysqli_query($GLOBALS['Connection'], $queryDay);
            $resultPerson = mysqli_query($GLOBALS['Connection'], $queryPerson);

            echo "<tr><th></th>";
            foreach ($resultPerson as $personRow){
                echo "<th>". $personRow['person_name'] ."</th>";

                //Add "between"
                $queryFood = 'Select f.food_name, w.day_id from food f inner join week w on w.food_id = f.food_id where w.week_id in (select week_id from personweek pw where pw.person_id = '. $personRow['person_id'] .') and w.update_date >= '. $GLOBALS['Monday_Date'] .' order by w.update_date asc limit 7'; 
                
                //[food1, food2, food3, food4, food5, food6, food7]
                $resultFood = mysqli_query($GLOBALS['Connection'], $queryFood);
                //[[food1, food2, food3, food4, food5, food6, food7], [[food1, food2, food3, food4, food5, food6, food7]]]

                array_push($foodArray, $resultFood);
            }
            echo "</tr>";

            foreach ($resultDay as $dayRow){
                echo "<tr>";
                echo "<th>". $dayRow['day_name'] ."</th>";

                foreach($foodArray as $foodRow){
                    echo "<td>";

                    $i = 1;
                    foreach ($foodRow as $food){
                        if($i == $dayRow['day_id']){
                            echo $food['food_name'];
                        }
                        $i ++;
                    }
                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>