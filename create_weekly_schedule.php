<!DOCTYPE html>

<head>
    <?php include 'utils.php'; ?>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="date"></input>
        <div class="grid-container">
            <table>
                <?php
                function submit(){
                    echo "Testing";
                }

                if (isset($_POST['submit'])){
                    submit();
                }

                $queryDay = 'SELECT * FROM  day';
                $queryPerson = 'SELECT * FROM person';
                $queryFood = 'SELECT * FROM food';
                
                $resultDay = mysqli_query($GLOBALS['Connection'], $queryDay);
                $resultPerson = mysqli_query($GLOBALS['Connection'], $queryPerson);
                $resultFood = mysqli_query($GLOBALS['Connection'], $queryFood);

                echo "<tr><th></th>";
                foreach ($resultPerson as $personRow){
                    echo "<th>". $personRow['person_name'] ."</th>";
                }
                echo "</tr>";

                foreach($resultDay as $day){
                    echo "<tr>";

                    echo "<th>". $day['day_name'] ."</th>";
                    foreach ($resultPerson as $personRow){
                        echo "<td>";
                        echo "<select value="..">";

                        foreach ($resultFood as $food){
                            echo "<option>". $food['food_name'] ."</option>";
                        }

                        echo "</select>";
                        echo "</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <input type="submit" name="submit" value="speichern" />
    </form>
</body>