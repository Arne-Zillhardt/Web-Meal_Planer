<!DOCTYPE html>

<head>
    <?php 
    include 'utils.php'; 
    $date = $GLOBALS['Monday_Date'];
    $foods = $GLOBALS['Foods'];
    $days = $GLOBALS['Days'];
    $personLength = $GLOBALS['Personlength'];
    $foodArray = getFoodAndPersonAtSpecificDate($date);
    ?>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return false;">
        <?php
            echo '<input type="date" name="date" id="date" onchange="this.form.submit()"';
            if(isset($_POST['date'])){
                echo " value=". $_POST['date'] ."";
                $date = $_POST['date'];
                $foodArray = getFoodAndPersonAtSpecificDate($date);
            }

            echo ">";
            ?>
    </form>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="grid-container">
            <table>
                <?php
                if(isset($_POST['submit'])){
                    foreach($_POST['food'] as $postedFood){
                        $valueArray = explode(",",$postedFood);
                        print_r(explode(",",$postedFood));
                        break;
                    }
                }

                $j = 1;
                foreach($days as $day){
                    echo "<tr><th>$day[1]</th>";
    
                    for($i=1;$i<=$personLength;$i++){
                        echo '<td><select name="food[]">';
                        echo "<option value=-1,$i,$j></option>";
    
                        $foodId = null;
                        foreach($foodArray as $foodAndPerson){
                            $personId = $foodAndPerson[2];
                            $dayId = $foodAndPerson[4];
    
                            if($personId==$i && $dayId == $j){
                                $foodId = $foodAndPerson[0];
                                break;
                            }
                        }

                        foreach($foods as $food){
                            $id = $food[0];
                            $foodName = $food[1];

                            echo '<option value="' . $id . ','. $i. ','. $j. '"';
                            if($foodId == $id){
                                echo ' selected ';
                            }

                            echo ">$foodName</option>";
                        }
    
                        echo "</select></td>";
                    }
    
                    $j++;
                    echo "</tr>";
                }

                /*if(isset($_POST["submit"])){
                    $foodForPerson = [];
                    $cout = 0;

                    $i = 1;
                    $dayId = 1;
                    foreach($_POST['food'] as $postedFood){
                        $personId = $i;
                        array_push($foodForPerson, [$personId, $postedFood, $dayId]);

                        if($i%4==0){
                            $dayId++;
                            $i = 0;
                        }
                        $i++;
                    }

                    insertFoodAndPerson($foodForPerson, $date);
                }

                createHeader();
                $foodArray = getFoodAndPersonAtSpecificDate($date);

                $mult = 0;
                for($i=0; $i<sizeof($days); $i++) {
                    echo "<tr>";
                    echo "<th>". $days[$i] ."</th>";

                    for($j=0; $j<$GLOBALS['Personlength']; $j++) {
                        echo "<td>";
                        $foodAtCurrentDay = "";
                        if (isset($foodArray[$j + $mult])) {
                            $foodRow = $foodArray[$j + $mult];
                            $foodAtCurrentDay = $foodRow['food_name'];
                        }

                        echo '<select name="food[]">';

                        //echo $foodAtCurrentDay
                        if(empty($foodAtCurrentDay)) {
                            echo '<option value="-1"></option>';
                        }

                        foreach($food as $foodName){
                            echo '<option value="'. $foodName[0] .'"';

                            if($foodName[1] == $foodAtCurrentDay){
                                echo " selected";
                            }

                            echo '>'. $foodName[1] .'</option>';
                        }

                        echo "</select>";
                        echo "</td>";
                    }
                    $mult += $GLOBALS['Personlength'];

                    echo "</tr>";
                }*/
                ?>
            </table>
        </div>
        <input type="submit" name="submit" />
    </form>

    <?php
    ?>
</body>