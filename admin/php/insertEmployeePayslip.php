<?php
include '../includes/conn.php';
if (isset($_POST['dateNow'])) {
  $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
  $query = $conn->query($sql);

  //load employee table
  while ($row = $query->fetch_assoc()) :
    $position = $row['description'];
    $empID = $row['employee_id'];

    //pagkuha ng cut-off dates
    $sqlCutoff = "SELECT * FROM cutoff ORDER BY end_date DESC";
    $resultCutoff = mysqli_query($conn, $sqlCutoff);

    // printing ng payroll summary ng employee
    while ($rowCutoff = mysqli_fetch_array($resultCutoff)) :

      $cutoff_id = $rowCutoff['cutoff_id'];
      $new_start_date = $rowCutoff['start_date'];
      $new_end_date = $rowCutoff['end_date'];
      $start_date = date("M j Y", strtotime($rowCutoff['start_date']));
      $end_date = date("M j Y", strtotime($rowCutoff['end_date']));

      //gross
      $sqlGross = "SELECT SUM(num_hr) as total_numhr, rate FROM attendance as a, position as p, employees as e WHERE a.employee_id = e.employee_id AND p.id = e.position_id AND e.employee_id = '$empID' AND a.date BETWEEN '$new_start_date' AND '$new_end_date'";
      $resultGross = mysqli_query($conn, $sqlGross);
      $rowGross = mysqli_fetch_assoc($resultGross);

      $gross = $rowGross['rate'] * $rowGross['total_numhr'];

      if ($gross != 0) { // para mag-print lang is yung may mga gross sa cut-off date

        //cost of damage materials
        $sqlAdvanceDam = "SELECT * FROM cashadvance as ca, project_materials_log as p WHERE ca.employee_id = p.name AND ca.employee_id = '$empID'";
        $resultAdvanceDam = mysqli_query($conn, $sqlAdvanceDam);
        $rowAdvanceDam = mysqli_fetch_assoc($resultAdvanceDam);

        $amount = $rowAdvanceDam['amount'];  //cash advance
        $price = $rowAdvanceDam['price'];   //cost of damage


        //OT
        $sqlOT = "SELECT SUM(amount) as total_amount, SUM(hours) as hour_ot  from overtime where date_overtime BETWEEN '$new_start_date' AND '$new_end_date' AND employee_id = '$empID' AND ot_status = 'Approved'";
        $resultOT = mysqli_query($conn, $sqlOT);
        $rowOT = mysqli_fetch_assoc($resultOT);

        if ($rowOT['total_amount'] == NULL)
          $rowOT['total_amount'] = 0;

        //cash advance
        $sqlCashAd = "SELECT SUM(amount) as total_amount  from cashadvance where date_advance BETWEEN '$new_start_date' AND '$new_end_date' AND employee_id = '$empID'";
        $resultCashAd = mysqli_query($conn, $sqlCashAd);
        $rowCashAd = mysqli_fetch_assoc($resultCashAd);
        if ($rowCashAd['total_amount'] == NULL)
          $rowCashAd['total_amount'] = 0;

        //damage
        $sqlDamage = "SELECT SUM(price) as total_price  from project_materials_log where date BETWEEN '$new_start_date' AND '$new_end_date' AND name = '$empID'";
        $resultDamage = mysqli_query($conn, $sqlDamage);
        $rowDamage = mysqli_fetch_assoc($resultDamage);
        if ($rowDamage['total_price'] == NULL)
          $rowDamage['total_price'] = 0;

        //sss
        if ($gross < 3250)
          $sss = 135;
        else if (3749.99 >= $gross && $gross > 3250)
          $sss = 157.50;
        else if (4249.99 >= $gross && $gross > 3750)
          $sss = 180;
        else if (4749.99 >= $gross && $gross > 4250)
          $sss = 202.5;
        else if (5249.99 >= $gross && $gross > 4750)
          $sss = 225;
        else if (5749.99 >= $gross && $gross > 5250)
          $sss = 247.5;
        else if (6249.99 >= $gross && $gross > 5750)
          $sss = 270;
        else if (6749.99 >= $gross && $gross > 6250)
          $sss = 292.5;
        else if (7249.99 >= $gross && $gross > 6750)
          $sss = 315;
        else if (7749.99 >= $gross && $gross > 7250)
          $sss = 337.5;
        else if (8249.99 >= $gross && $gross > 7750)
          $sss = 360;
        else if (8749.99 >= $gross && $gross > 8250)
          $sss = 382.5;
        else if (9249.99 >= $gross && $gross > 8750)
          $sss = 405;
        else if (9749.99 >= $gross && $gross > 9250)
          $sss = 427.5;
        else if (10249.99 >= $gross && $gross > 9750)
          $sss = 450;


        // payslip data
        $total_hour = $rowGross['total_numhr'];     //total hour per cut-off
        $ot_hours = $rowOT['hour_ot'] / 60;         //total Hours of OT per cut-off
        $total_ot = $rowOT['total_amount'];         //total Amount of OT per cut-off
        $total_cashad = $rowCashAd['total_amount']; //cash advance per cut-off
        $tax_stat = "S";                            //tax status per cut-off
        $material_loss = $price;                    //material cost damages per cut-off
        $philhealth = $gross * 0.035 / 2;           //philhealth per cut-off
        $pagibig = 50;                              //pag-ibig per cut-off
        $tax = 100;                                 //cash advance per cut-off
        $sss_payslip = $sss;                        //sss per cut-off passing to payslip history
        $philhealth_payslip = $philhealth;          //philhealth per cut-off  passing to payslip history
        $pagibig_payslip = $pagibig;                //pag-ibig per cut-off passing to payslip history
        $tax_payslip = $tax;                        //tax per cut-off passing to payslip history
        $gross_payslip = $gross;                    //gross per cut-off passing to payslip history
        $compensation_total = $gross + $total_ot;   //total compensation per cut-off
        $deduction_total = $total_cashad + $tax_payslip + $sss_payslip + $philhealth_payslip + $pagibig_payslip + $material_loss; //total deduction per cut-off
        $netpay = $compensation_total - $deduction_total; //net pay per cut-off

        //insert to yeartodate
        $sqlYTD = "SELECT * from yeartodate WHERE employee_id = '$empID'";
        $resultYTD = mysqli_query($conn, $sqlYTD);
        $rowYTD = mysqli_fetch_assoc($resultYTD);

        $philhealth = $rowYTD['philhealth'] + $philhealth;
        $pagibig = $rowYTD['pagibig'] + $pagibig;
        $sss = $rowYTD['sss'] + $sss;
        $gross = $rowYTD['gross_income'] + $gross;

        /*
	  dapat mastore 'yung previous value 
	  $sqlYear = "UPDATE yeartodate set
                    tax = '$tax',
                    sss = '$sss',
                    philhealth = '$philhealth',
                    pagibig = '$pagibig', 
                    gross_income = '$gross'
                    WHERE employee_id = '$empID'";
      $conn->query($sqlYear);*/

        $sqlp = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
        $queryp = $conn->query($sqlp);
        $rowp = $queryp->fetch_assoc();
        $position = $rowp['description'];
        $rph = $rowp['rate'];

        // $empID, $cutoff_id, $position, $tax_stat, $gross_payslip, $total_ot, $total_cashad, $sss_payslip, $philhealth_payslip, $pagibig_payslip, $tax_payslip,$material_loss, $sss, $philhealth, $pagibig, $gross, $compensation_total, $deduction_total, $netpay 

        $sqlpayslipdisplay = "SELECT * FROM payslip WHERE '$cutoff_id'=cutoff_id AND '$empID'=employee_id";
        $querypayslipdisplay = $conn->query($sqlpayslipdisplay);
        $rowpayslipdisplay = $querypayslipdisplay->fetch_assoc();

        $payslip_cutoffID = $rowpayslipdisplay['cutoff_id'];
        $payslip_empID = $rowpayslipdisplay['employee_id'];
        if ($cutoff_id != $payslip_cutoffID && $empID != $payslip_empID) {

          $sqlpayslip = "INSERT INTO payslip 
        (employee_id, cutoff_id, position, rate, tax_status, basic_pay, total_hour, ot_hours, ot, cash_advance, sss, philhealth, hdmif, tax, material_cost, ytd_sss, ytd_philhealth, ytd_hdmif, ytd_grossincome, total_compensation, total_deduc, netpay) 
        VALUES ('$empID', '$cutoff_id', '$position', '$rph', '$tax_stat', '$gross_payslip', '$total_hour', '$ot_hours', '$total_ot', '$total_cashad', '$sss_payslip', '$philhealth_payslip', '$pagibig_payslip', '$tax_payslip', '$material_loss', '$sss', '$philhealth', '$pagibig', '$gross', '$compensation_total', '$deduction_total', '$netpay')";

          $data = $conn->query($sqlpayslip) ? 'working' : "Error3." . $sqlpayslip . "<br>" . $conn->error;
          if ($data  == NULL) {
            $data = "";
          }
        }
      }
    endwhile;
  endwhile;
  echo json_encode($data);
}
