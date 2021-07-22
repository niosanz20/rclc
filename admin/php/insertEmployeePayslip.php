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
    $sqlCutoff = "SELECT * FROM cutoff ORDER BY end_date ASC";
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

      $gross = $rowGross['rate'] * $rowGross['total_numhr'];    //gross income

      if ($gross != 0) { // para mag-print lang is yung may mga gross sa cut-off date

        //cost of damage materials
        $sqlAdvanceDam = "SELECT SUM(price) as total_price  from project_materials_log where date BETWEEN '$new_start_date' AND '$new_end_date' AND name = '$empID'";
        $resultAdvanceDam = mysqli_query($conn, $sqlAdvanceDam);
        $rowAdvanceDam = mysqli_fetch_assoc($resultAdvanceDam);

        $amount = $rowAdvanceDam['amount'];  //cash advance
        $price = $rowAdvanceDam['total_price'];   //cost of damage


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
        // $sqlDamage = "SELECT SUM(price) as total_price  from project_materials_log where date BETWEEN '$new_start_date' AND '$new_end_date' AND name = '$empID'";
        // $resultDamage = mysqli_query($conn, $sqlDamage);
        // $rowDamage = mysqli_fetch_assoc($resultDamage);
        // if ($rowDamage['total_price'] == NULL)
        //   $rowDamage['total_price'] = 0;

        //sss
        $sss_gross = $gross * 2;
        if ($sss_gross < 3250)
          $sss = 135;
        else if (3749.99 >= $sss_gross && $sss_gross > 3250)
          $sss = 157.50;
        else if (4249.99 >= $sss_gross && $sss_gross > 3750)
          $sss = 180;
        else if (4749.99 >= $sss_gross && $sss_gross > 4250)
          $sss = 202.5;
        else if (5249.99 >= $sss_gross && $sss_gross > 4750)
          $sss = 225;
        else if (5749.99 >= $sss_gross && $sss_gross > 5250)
          $sss = 247.5;
        else if (6249.99 >= $sss_gross && $sss_gross > 5750)
          $sss = 270;
        else if (6749.99 >= $sss_gross && $sss_gross > 6250)
          $sss = 292.5;
        else if (7249.99 >= $sss_gross && $sss_gross > 6750)
          $sss = 315;
        else if (7749.99 >= $sss_gross && $sss_gross > 7250)
          $sss = 337.5;
        else if (8249.99 >= $sss_gross && $sss_gross > 7750)
          $sss = 360;
        else if (8749.99 >= $sss_gross && $sss_gross > 8250)
          $sss = 382.5;
        else if (9249.99 >= $sss_gross && $sss_gross > 8750)
          $sss = 405;
        else if (9749.99 >= $sss_gross && $sss_gross > 9250)
          $sss = 427.5;
        else if (10249.99 >= $sss_gross && $sss_gross > 9750)
          $sss = 450;
        else if (10749.99 >= $sss_gross && $sss_gross > 10250)
          $sss = 472.50;
        else if (11249.99 >= $sss_gross && $sss_gross > 10750)
          $sss = 495;
        else if (11749.99 >= $sss_gross && $sss_gross > 11250)
          $sss = 517.5;
        else if (12249.99 >= $sss_gross && $sss_gross > 11750)
          $sss = 540;
        else if (12749.99 >= $sss_gross && $sss_gross > 12250)
          $sss = 562.5;
        else if (13249.99 >= $sss_gross && $sss_gross > 12750)
          $sss = 585;
        else if (13749.99 >= $sss_gross && $sss_gross > 13250)
          $sss = 607.5;
        else if (14249.99 >= $sss_gross && $sss_gross > 13750)
          $sss = 630;
        else if (14749.99 >= $sss_gross && $sss_gross > 14250)
          $sss = 652.5;
        else if (15249.99 >= $sss_gross && $sss_gross > 14750)
          $sss = 675;
        else if (15749.99 >= $sss_gross && $sss_gross > 15250)
          $sss = 697.5;
        else if (16249.99 >= $sss_gross && $sss_gross > 15750)
          $sss = 720;
        else if (16749.99 >= $sss_gross && $sss_gross > 16250)
          $sss = 742.5;
        else if (17249.99 >= $sss_gross && $sss_gross > 16750)
          $sss = 765;
        else if (17749.99 >= $sss_gross && $sss_gross > 17250)
          $sss = 787.5;
        else if (18249.99 >= $sss_gross && $sss_gross > 17750)
          $sss = 810;
        else if (18749.99 >= $sss_gross && $sss_gross > 18250)
          $sss = 832.5;
        else if (19249.99 >= $sss_gross && $sss_gross > 18750)
          $sss = 855;
        else if (19749.99 >= $sss_gross && $sss_gross > 19250)
          $sss = 877.5;
        else if ($sss_gross > 19750)
          $sss = 900;

        $sss = $sss / 2;



        // payslip data
        $total_hour = $rowGross['total_numhr'];     //total hour per cut-off
        $ot_hours = $rowOT['hour_ot'] / 60;         //total Hours of OT per cut-off
        $total_ot = $rowOT['total_amount'];         //total Amount of OT per cut-off
        $total_cashad = $rowCashAd['total_amount']; //cash advance per cut-off
        $tax_stat = "S";                            //tax status per cut-off
        $material_loss = $price;                    //material cost damages per cut-off
        $philhealth = $gross * 0.035 / 2;           //philhealth per cut-off
        $pagibig = 50;                              //pag-ibig per cut-off
        $sss_payslip = $sss;                        //sss per cut-off passing to payslip history
        $philhealth_payslip = $philhealth;          //philhealth per cut-off  passing to payslip history
        $pagibig_payslip = $pagibig;                //pag-ibig per cut-off passing to payslip history
        $gross_payslip = $gross;                    //gross per cut-off passing to payslip history
        $compensation_total = $gross + $total_ot;   //total compensation per cut-off
        $deduction_contribution = $total_cashad + $sss_payslip + $philhealth_payslip + $pagibig_payslip + $material_loss; //total deduction per cut-of

        //tax computation
        $salary = ($compensation_total - $deduction_contribution);

        if ($salary <= 10417)   //1
          $tax_income = 0;
        else if ($salary > 10417 && $salary <= 16666)   //2
        {
          $tax_income = (($salary - 10417) * .20) + 0;
        } else if ($salary > 16666 && $salary <= 33332)   //3
        {
          $tax_income = (($salary - 16667) * .25) + 1250;
        } else if ($salary > 33332 && $salary <= 83332)   //4
        {
          $tax_income = (($salary - 33333) * .30) + 5416.67;
        } else if ($salary > 83332 && $salary <= 333332)    //5
        {
          $tax_income = (($salary - 83333) * .32) + 20416.67;
        } else if ($salary > 333332)    //6
        {
          $tax_income = (($salary - 333333) * .35) + 100416.67;
        }

        // $tax_payslip = $tax_income;

        $deduction_total = $deduction_contribution + $tax_income;

        $netpay = $compensation_total - $deduction_total; //net pay per cut-off


        //insert to yeartodate
        $sqlYTD = "SELECT * from yeartodate WHERE employee_id = '$empID'";
        $queryYTD = $conn->query($sqlYTD);
        $rowYTD = $queryYTD->fetch_assoc();

        $philhealthYTD = $rowYTD['philhealth'] + $philhealth;
        $pagibigYTD = $rowYTD['pagibig'] + $pagibig;
        $sssYTD = $rowYTD['sss'] + $sss;
        $grossYTD = $rowYTD['gross_income'] + $gross;
        $tax_payslipYTD = $rowYTD['tax'] + $tax_income;

        // dapat mastore 'yung previous value   //done

        $sqlYear = "UPDATE yeartodate SET 
                sss = '$sssYTD',
                philhealth = '$philhealthYTD',
                pagibig = '$pagibigYTD', 
                tax = '$tax_payslipYTD',
                gross_income = '$grossYTD'
                WHERE employee_id = '$empID'";
        $conn->query($sqlYear) ? 'working' : "Error3." . $sqlYear . "<br>" . $conn->error;

        // Postion & Rate
        $sqlp = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
        $queryp = $conn->query($sqlp);
        $rowp = $queryp->fetch_assoc();
        $position = $rowp['description'];
        $rph = $rowp['rate'];

        // Project
        $sqlproj = "SELECT employees.employee_id, project.project_name AS empproj FROM employees LEFT JOIN project_employee ON project_employee.name=employees.employee_id LEFT JOIN project on project.project_id=project_employee.projectid WHERE employees.employee_id='$empID'";
        $queryproj = $conn->query($sqlproj);
        $rowproj = $queryproj->fetch_assoc();
        $projectname = $rowproj['empproj'];


        $sqlpayslipdisplay = "SELECT * FROM payslip WHERE '$cutoff_id'=cutoff_id AND '$empID'=employee_id";
        $querypayslipdisplay = $conn->query($sqlpayslipdisplay);
        $rowpayslipdisplay = $querypayslipdisplay->fetch_assoc();

        $payslip_cutoffID = $rowpayslipdisplay['cutoff_id'];
        $payslip_empID = $rowpayslipdisplay['employee_id'];
        if ($cutoff_id != $payslip_cutoffID && $empID != $payslip_empID) {

          $sqlpayslip = "INSERT INTO payslip (employee_id, cutoff_id, project_name, position, rate, tax_status, basic_pay, total_hour, ot_hours, ot, cash_advance, sss, philhealth, hdmif, tax, material_cost, ytd_sss, ytd_philhealth, ytd_hdmif, ytd_tax, ytd_grossincome, total_compensation, total_deduc, netpay) 
                                      VALUES ('$empID', '$cutoff_id', '$projectname', '$position', '$rph', '$tax_stat', '$gross_payslip', '$total_hour', '$ot_hours', '$total_ot', '$total_cashad', '$sss_payslip', '$philhealth_payslip', '$pagibig_payslip', '$tax_income', '$material_loss', '$sssYTD', '$philhealthYTD', '$pagibigYTD', '$tax_payslipYTD', '$gross', '$compensation_total', '$deduction_total', '$netpay')";

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