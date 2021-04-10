<!DOCTYPE html>
<html>

<body>

    <?php
    echo  DateTime::createFromFormat('H:i:s',  date_create('08:00:00'));
    // $stime_in = ;
    // $time_in = date_create('08:00:00');
    // $stime_out = '17:00:00';
    // $time_out = '19:00:00';

    // $rate = 100;
    // if (date_create($stime_out) < date_create($time_out)) {

    //     //$othour = date_diff($stime_out, $time_out)->format('%H');
    //     $othour = date_diff(date_create($stime_out), date_create($time_out))->format('%H');
    //     $otmin = date_diff(date_create($stime_out), date_create($time_out))->format('%i');
    //     $otint = $othour * 60 + $otmin;

    //     if ($otint > 30) {
    //         $amount = ($rate * ($otint / 60)) * .25;
    //         $time_out = $stime_out;
    //     } else $time_out = $stime_out;
    // } else $time_out = $time_out;

    // $hour = date_diff(date_create('08:00:00'), date_create($time_out))->format('%H');
    // $min = date_diff($stime_in, $time_out)->format('%i');
    // $int = $hour + ($min / 60);

    // if ($hour >= 9)
    //     $int = $int - 1.0;
    // else if ($hour >= 6 && $hour < 9)
    //     $int = $int - .75;
    // else if (($hour >= 4) && $hour < 6)
    //     $int = $int - .5;

    // echo "Total Hour : " . $int . "<br>";
    // echo "Total minutes of OT : " . $otint . " minutes<br>";
    // echo "OT Rate : " . $amount;

    ?>

</body>

</html>