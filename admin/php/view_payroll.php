<?php
include '../includes/conn.php';

//pagkuha ng employee, postion, at schedules
if (isset($_POST['empID'])) {
  $empID = $_POST['empID'];
  // $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
  // $query = $conn->query($sql);
  // $row = $query->fetch_assoc();

  // //pagkuha ng cut-off dates
  // $sqlCutoff = "SELECT * FROM cutoff ORDER BY end_date DESC";
  // $resultCutoff = mysqli_query($conn, $sqlCutoff);

  $output = '
  <div class="panel" id="payrollSummary">
    <div class="box-body">
      <table id="example6" class="table table-bordered" style=" width:100%">
        <thead>
          <th>Ref. ID</th>
          <th style="width: 100%">Cut-Off Date</th>
          <th>Gross Income</th>
          <th>OT</th>
          <th>Cash Advance</th>
          <th>Cost of Damage Materials</th>
          <th>SSS</th>
          <th>PhilHealth</th>
          <th>Pag-ibig</th>
          <th>Actions</th>
        </thead>
        <tbody>
        ';
  $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();

  $empName = $row['firstname'] . ' ' . $row['lastname'];
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
      $sqlOT = "SELECT SUM(amount) as total_amount  from overtime where date_overtime BETWEEN '$new_start_date' AND '$new_end_date' AND employee_id = '$empID' AND ot_status = 'Approved'";
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
      $total_ot = $rowOT['total_amount'];         //total OT per cut-off
      $total_cashad = $rowCashAd['total_amount']; //cash advance per cut-off
      $tax_stat = "S";                            //tax status per cut-off
      $material_loss = $price;   //material cost damages per cut-off
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

      $output .= '
              <tr>
                <td>' . $cutoff_id . '</td>
                <td style="width: 100%">' . $start_date . " - " . $end_date . '</td>
                <td>₱ ' . number_format($gross) . '</td>
                <td>₱ ' . $rowOT['total_amount'] . '</td>
                <td>₱ ' . $rowCashAd['total_amount'] . '</td>
                <td>₱ ' . $rowDamage['total_price'] . '</td>
                <td>₱ ' . number_format($sss) . '</td>
                <td>₱ ' . number_format($philhealth) . '</td>
                <td>₱ ' . number_format($pagibig) . '</td>
                <td>
                  <button type="button" class="viewPayrollDetails btn btn-success btn-sm btn-flat" refid="' . $cutoff_id . '" id="' . $empID . '"><span class="glyphicon glyphicon-file"></span> Print</button>
                </td>
              </tr>
              ';
      //insert to yeartodate
      $sqlYTD = "SELECT * from yeartodate WHERE employee_id = '$empID'";
      $resultYTD = mysqli_query($conn, $sqlYTD);
      $rowYTD = mysqli_fetch_assoc($resultYTD);

      $philhealth = $rowYTD['philhealth'] + $philhealth;
      $pagibig = $rowYTD['pagibig'] + $pagibig;
      $sss = $rowYTD['sss'] + $sss;
      $gross = $rowYTD['gross_income'] + $gross;

      $sqlYear = "UPDATE yeartodate set
                    tax = '$tax',
                    sss = '$sss',
                    philhealth = '$philhealth',
                    pagibig = '$pagibig', 
                    gross_income = '$gross'
                    WHERE employee_id = '$empID'";
      $conn->query($sqlYear);

      $sqlp = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.employee_id='$empID'";
      $queryp = $conn->query($sqlp);
      $rowp = $queryp->fetch_assoc();
      $position = $rowp['description'];

      // $empID, $cutoff_id, $position, $tax_stat, $gross_payslip, $total_ot, $total_cashad, $sss_payslip, $philhealth_payslip, $pagibig_payslip, $tax_payslip,$material_loss, $sss, $philhealth, $pagibig, $gross, $compensation_total, $deduction_total, $netpay 

      $sqlpayslipdisplay = "SELECT * FROM payslip WHERE '$cutoff_id'=cutoff_id AND '$empID'=employee_id";
      $querypayslipdisplay = $conn->query($sqlpayslipdisplay);
      $rowpayslipdisplay = $querypayslipdisplay->fetch_assoc();

      $payslip_cutoffID = $rowpayslipdisplay['cutoff_id'];
      $payslip_empID = $rowpayslipdisplay['employee_id'];
      if ($cutoff_id != $payslip_cutoffID && $empID != $payslip_empID) {
        $sqlpayslip = "INSERT INTO payslip (employee_id, cutoff_id, position, tax_status, basic_pay, total_hour, ot, cash_advance, sss, philhealth, hdmif, tax, material_cost, ytd_sss, ytd_philhealth, ytd_hdmif, ytd_grossincome, total_compensation, total_deduc, netpay) VALUES ('$empID', '$cutoff_id', '$position', '$tax_stat', '$gross_payslip', '$total_hour', '$total_ot', '$total_cashad', '$sss_payslip', '$philhealth_payslip', '$pagibig_payslip', '$tax_payslip', '$material_loss', '$sss', '$philhealth', '$pagibig', '$gross', '$compensation_total', '$deduction_total', '$netpay')";
        if ($conn->query($sqlpayslip) === TRUE) {
          echo 'edi wow';
        } else echo "Error3." . $sqlpayslip . "<br>" . $conn->error;
      }
    }
  endwhile;
  $output .= '
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $(function() {
      $("#example6").DataTable({
        "order": [
          [0, "desc"]
        ],
        responsive: true,
        "paging": true,
        "lengthChange": false,
        pageLength: 5,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      })
    })
  </script>
  ';
  // $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id WHERE payslip.cutoff_id='$cutoff_id' AND employees.employee_id='$empID'";
  $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id='$empID'";
  $resultCutoffpayslip = $conn->query($sqlCutoffpayslip);
  $rowpaylsipcutoff = $resultCutoffpayslip->fetch_assoc();

  // $sqlCutoffpayslip = "SELECT * FROM cutoff ORDER BY end_date DESC";
  // $resultCutoffpayslip = mysqli_query($conn, $sqlCutoffpayslip);
  // $rowpaylsipcutoff = $resultCutoffpayslip->fetch_assoc();
  $payroll_details = '
    <div class="panel">
      <table class="greyGridTable">
        <thead>
          <tr>
            <th colspan="6">RC Llaguno Construction</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="20%" align="left"><b>NAME</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['firstname'] . ' ' . $rowpaylsipcutoff['lastname'] . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>TAX STATUS</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['tax_status'] . '</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>PAYROLL DATE</b></td>
            <td width="10%" align="left">: ' . date("M j Y", strtotime($rowpaylsipcutoff['payroll_date'])) . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>TIN</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>DATE COVERED</b></td>
            <td width="20%" align="left">: (' . date("M j, Y", strtotime($rowpaylsipcutoff['start_date'])) . ' - ' . $end_date = date("M j, Y", strtotime($rowpaylsipcutoff['end_date'])) . ')</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>SSS NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>POSITION</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['description'] . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>PHILHEALTH NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"></td>
            <td width="10%" align="left"></td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>HDMIF NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
        </tbody>
      </table>
      <table class="greyGridTable" id="secondTable">
        <thead>
          <tr>
            <th colspan="2">COMPENSATION
            </th>
            <th colspan="2">DEDUCTIONS
            </th>
            <th colspan="2">YEAR-TO-DATE</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>TOTAL <br> COMPENSATION
            </th>
            <th>₱ ' . $rowpaylsipcutoff['total_compensation'] . '</th>
            <th>TOTAL <br> DEDUCTIONS
            </th>
            <th>₱ ' . $rowpaylsipcutoff['total_deduc'] . '</th>
            <th>NET PAY</th>
            <th>₱ ' . $rowpaylsipcutoff['netpay'] . '</th>
          </tr>
        </tfoot>
        <tbody>
          <tr>
            <td width="20%" align="left"><b>RATE per HOUR</b></td>
            <td width="10%" align="left">' . $rowpaylsipcutoff['rate'] . '</td>
            <td width="20%" align="left"><b>CASH ADVANCE</b></td>
            <td width="10%" align="right">' . $rowpaylsipcutoff['cash_advance'] . '</td>
            <td width="20%" align="left"><b>TAX</b></td>
            <td width="10%" align="right">' . $rowpaylsipcutoff['tax'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>TOTAL HOURS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['total_hour'] . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['sss'] . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_sss'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>BASIC</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['basic_pay'] . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['philhealth'] . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_philhealth'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>OT (10 hrs)</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ot'] . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['hdmif'] . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_hdmif'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b></b></td>
              <td width="10%" align="right"></td>
              <td width="20%" align="left"><b>MATERIAL LOST</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['material_cost'] . '</td>
              <td width="20%" align="left"><b>GROSS INCOME</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_grossincome'] . '</td>
            </tr>
            </tbody>
            </table>
            <div class="legend">
              <table style="border:none">
                <thead>
                  <th colspan="4">LEGEND</th>
                </thead>
                <tbody>
                  <tr>
                    <td>LH -</td>
                    <td>Legal Holiday</td>
                    <td>OT -</td>
                    <td>Overtime</td>
                  </tr>
                  <tr>
                    <td>SH -</td>
                    <td>Special Holiday &nbsp</td>
                    <td>RD -</td>
                    <td>Rest Day</td>
                  </tr>
                  <tr>
                    <td>DH -</td>
                    <td>Double Holiday</td>
                    <td></td>
                    <td></td>
                  </tr>

                </tbody>
              </table>
            </div>
            </div>
  ';

  $data = array(
    'payroll_table' => $output,
    'payroll_details' => $payroll_details,
    'empID' => $empID,
    'empName' => $empName
  );

  echo json_encode($data);
}

if (isset($_POST['empID2'])) {
  $empID = $_POST['empID2'];
  $cutoffID = $_POST['cutoffID'];

  $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id WHERE payslip.cutoff_id='$cutoffID' AND employees.employee_id='$empID'";
  // $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id='$empID'";
  $resultCutoffpayslip = $conn->query($sqlCutoffpayslip);
  $rowpaylsipcutoff = $resultCutoffpayslip->fetch_assoc();

  $payroll_details = '
    <div class="panel">
      <table class="greyGridTable">
        <thead>
          <tr>
            <th colspan="6">RC Llaguno Construction</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="20%" align="left"><b>NAME</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['firstname'] . ' ' . $rowpaylsipcutoff['lastname'] . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>TAX STATUS</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['tax_status'] . '</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>PAYROLL DATE</b></td>
            <td width="10%" align="left">: ' . date("M j Y", strtotime($rowpaylsipcutoff['payroll_date'])) . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>TIN</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>DATE COVERED</b></td>
            <td width="20%" align="left">: (' . date("M j, Y", strtotime($rowpaylsipcutoff['start_date'])) . ' - ' . $end_date = date("M j, Y", strtotime($rowpaylsipcutoff['end_date'])) . ')</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>SSS NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>POSITION</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['description'] . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>PHILHEALTH NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
          <tr>
            <td width="20%" align="left"></td>
            <td width="10%" align="left"></td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>HDMIF NO.</b></td>
            <td width="10%" align="left">: 52341234</td>
          </tr>
        </tbody>
      </table>
      <table class="greyGridTable" id="secondTable">
        <thead>
          <tr>
            <th colspan="2">COMPENSATION
            </th>
            <th colspan="2">DEDUCTIONS
            </th>
            <th colspan="2">YEAR-TO-DATE</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>TOTAL <br> COMPENSATION
            </th>
            <th>₱ ' . $rowpaylsipcutoff['total_compensation'] . '</th>
            <th>TOTAL <br> DEDUCTIONS
            </th>
            <th>₱ ' . $rowpaylsipcutoff['total_deduc'] . '</th>
            <th>NET PAY</th>
            <th>₱ ' . $rowpaylsipcutoff['netpay'] . '</th>
          </tr>
        </tfoot>
        <tbody>
          <tr>
            <td width="20%" align="left"><b>RATE per HOUR</b></td>
            <td width="10%" align="left">' . $rowpaylsipcutoff['rate'] . '</td>
            <td width="20%" align="left"><b>CASH ADVANCE</b></td>
            <td width="10%" align="right">' . $rowpaylsipcutoff['cash_advance'] . '</td>
            <td width="20%" align="left"><b>TAX</b></td>
            <td width="10%" align="right">' . $rowpaylsipcutoff['tax'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>TOTAL HOURS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['total_hour'] . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['sss'] . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_sss'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>BASIC</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['basic_pay'] . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['philhealth'] . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_philhealth'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>OT (10 hrs)</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ot'] . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['hdmif'] . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_hdmif'] . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b></b></td>
              <td width="10%" align="right"></td>
              <td width="20%" align="left"><b>MATERIAL LOST</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['material_cost'] . '</td>
              <td width="20%" align="left"><b>GROSS INCOME</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ytd_grossincome'] . '</td>
            </tr>
            </tbody>
            </table>
            <div class="legend">
              <table style="border:none">
                <thead>
                  <th colspan="4">LEGEND</th>
                </thead>
                <tbody>
                  <tr>
                    <td>LH -</td>
                    <td>Legal Holiday</td>
                    <td>OT -</td>
                    <td>Overtime</td>
                  </tr>
                  <tr>
                    <td>SH -</td>
                    <td>Special Holiday &nbsp</td>
                    <td>RD -</td>
                    <td>Rest Day</td>
                  </tr>
                  <tr>
                    <td>DH -</td>
                    <td>Double Holiday</td>
                    <td></td>
                    <td></td>
                  </tr>

                </tbody>
              </table>
            </div>
            </div>
  ';

  $data = array(
    'payroll_details' => $payroll_details
  );

  echo json_encode($data);
}
