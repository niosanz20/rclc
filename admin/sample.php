<!DOCTYPE html>
<html>
<body>

    <!-- <?php 
    $string = "densoten";
    if(strlen($string) > 50 || strlen($string) < 5){
        echo "Invalid Input!\nLetters Contains between 5 and  50 only!";
    }
    else
    {
        $newString = substr($string, 1, -1);
        $firstChar = $string[0];
        $lastChar = $string[strlen($string)-1];

        echo $lastChar . $newString . $firstChar;
    }
     ?> -->
    <label>Enter Text:</label>
    <input type="txt" id="setText" value="">
    <input type="button" id="getText" value="Submit" onclick="getText()">

<script type="text/javascript">
    function getText(){
        var txt = document.getElementById('setText').value;

        if(txt.length >= 5 && txt.length <= 50)
        {
            alert(txt[txt.length - 1] + txt.substring(1, (txt.length - 1)) + txt[0]);
        }
        else
        {
            alert('Invalid Input String. Must Contain 5 up to 50 characters only!');
        }
   
    }
</script>



<?php
if(isset($_POST['submit'])){
    $count = 1;    
    $sumrow = array();
    $sumcol = array([],[]);
    $num = $_POST['numTable'];
    $total = 0; 
    $row = 0;
    $column = 0;
    echo "
     <table>
        <tbody>
    ";
    // A. Table
    for($i = 0; $i < $num; $i++) { // column
        echo "<tr>";

        for($x = 0; $x < $num ; $x++){ // row

    // B. Sum of Row
        $row += $count;

        echo "<td>".$sumcol[$i][$x] = $count++. "</td>";
        if ($x == $num - 1)
            $sumrow[$i] = $row;

        } // end of row



        echo "</tr>";
        $total += $row;
        $row = 0;    
    } // end of column
    echo "
      </tbody>
    </table>
    ";
    $count = 0;
    $col_result = array();
    $row_result = array();
    $sum = 0;
    for($x = 0; $x < $num; $x++)
    {
        $sum = 0;
        for($y = 0;$y < $num; $y++)
        {
            $sum = $sum + (int)$sumcol[$x][$y];
        }
        $col_result[$x] = $sum;
    }

     for($x = 0; $x < $num; $x++)
    {
        $sum = 0;
        for($y = 0;$y < $num; $y++) 
        {
            $sum = $sum + (int)$sumcol[$y][$x];
        }
        $row_result[$x] = $sum;
    }
    
    foreach ($sumrow as $value) {
        echo $value .", ";
    }
    echo "<br>Total: ".$total."<br>";
     foreach ($col_result as $value) {
        echo $value .", ";
    }
    echo "<br>";
     foreach ($row_result as $value) {
        echo $value .", ";
    }
}
?>



</body>
</html>
