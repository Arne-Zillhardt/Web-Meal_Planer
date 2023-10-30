<!DOCTYPE html>

<head>
    <?php 
    include 'utils.php'; 
    $date = $GLOBALS['Monday_Date'];
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
    <div class="grid-container">
        <table>
            <?php
            createHeader();

            $j = 1;
            foreach($days as $day){
                echo "<tr><th>$day[1]</th>";

                for($i=1;$i<=$personLength;$i++){
                    echo "<td>";

                    foreach($foodArray as $foodAndPerson){
                        $foodName = $foodAndPerson[1];
                        $personId = $foodAndPerson[2];
                        $dayId = $foodAndPerson[4];

                        if($personId==$i && $dayId == $j){

                            $foodOut = "Es ist kein Essen vorgesehen";
                            if(isset($foodName)){
                                $foodOut = $foodName;
                            }
                            echo $foodOut;

                            break;
                        }
                    }

                    echo "</td>";
                }

                $j++;
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>