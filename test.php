<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td>
                    <select name="title[]">
                        <option value="0"></option>

                        <option value="1">Title1</option>
                        <option value="2">Title2</option>
                        <option value="3">Title3</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <select name="title[]">
                        <option value="0"></option>
                        <option value="1">Title1</option>
                        <option value="2">Title2</option>
                        <option value="3">Title3</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <select name="title[]">
                        <option value="0"></option>

                        <option value="1">Title1</option>
                        <option value="2">Title2</option>
                        <option value="3">Title3</option>
                    </select>
                </td>
            </tr>

            <input type="submit" name="submit" />
        </table>
    </form>
    <?php
        if(isset($_POST['submit'])){
            foreach($_POST['title'] as $title) {
                echo $title . "<br>";
            }
        }
    ?>
</body>

<?php
$date = date('D') == 'Mon' ? date("Y-m-d") : date("Y-m-d", strtotime("this Monday"));
echo $date;

include 'utils.php';
echo "<br>". $GLOBALS['Monday_Date'];
echo "<br>". date('d-m-Y',strtotime("Monday"));
?>
