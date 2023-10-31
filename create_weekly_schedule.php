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
                $date = $_POST['date'];
                $foodArray = getFoodAndPersonAtSpecificDate($date);
            }
            echo " value=". $date ."";

            echo ">";
            ?>
    </form>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="grid-container">
            <table>
                <?php
                if(isset($_POST['submit'])){
                    $postArray = [];
                    foreach($_POST['food'] as $postedFood){
                        $valueArray = explode(",",$postedFood);
                        
                        $foodId = $valueArray[0];
                        $personId = $valueArray[1];
                        $dayId = $valueArray[2];

                        array_push($postArray, [$personId, $dayId, $foodId]);
                    }

                    echo $date; //!!!!!!!! Change !!!!!!!!!!
                    insertFoodAndPerson($postArray, $date);
                }

                createHeader();

                $j = 1;
                foreach($days as $day){
                    echo "<tr><th>$day[1]</th>";
    
                    for($i=1;$i<=$personLength;$i++){
                        echo '<td><select name="food[]">';
                        echo "<option value=-1,$i,$j,$date></option>";
    
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

                            echo '<option value="' . $id . ','. $i. ','. $j. ','. $date .'"';
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
                ?>
            </table>
        </div>
        <input type="submit" name="submit" />
    </form>

    <?php
    ?>
</body>