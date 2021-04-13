<?php
include '../includes/conn.php';

// TAB 1
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
          <th>Total Amount (O.T.)</th>
          <th>Cash Advance</th>
          <th>Material Cost Damage</th>
          <th>SSS  </th>
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
    $sqlCutoffpayslipsummary = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id WHERE employees.employee_id='$empID' AND cutoff.cutoff_id = '$cutoff_id'";

    $resultCutoffpayslipsummary = $conn->query($sqlCutoffpayslipsummary);
    $rowpaylsipcutoffsummary = $resultCutoffpayslipsummary->fetch_assoc();
    $gross = $rowpaylsipcutoffsummary['basic_pay'];
    $sss = $rowpaylsipcutoffsummary['sss'];
    $philhealth = $rowpaylsipcutoffsummary['philhealth'];
    $pagibig = $rowpaylsipcutoffsummary['hdmif'];


    if ($gross != 0) { // para mag-print lang is yung may mga gross sa cut-off date


      $output .= '
              <tr>
                <td>' . $cutoff_id . '</td>
                <td style="width: 100%">' . $start_date . " - " . $end_date . '</td>
                <td>₱ ' . number_format($gross, 2) . '</td>
                <td>₱ ' . number_format($rowpaylsipcutoffsummary['ot'], 2) . '</td> 
                <td>₱ ' . number_format($rowpaylsipcutoffsummary['cash_advance'], 2) . '</td>
                <td>₱ ' . number_format($rowpaylsipcutoffsummary['material_cost'], 2) . '</td>
                <td>₱ ' . number_format($sss, 2) . '</td>
                <td>₱ ' . number_format($philhealth, 2) . '</td>
                <td>₱ ' . number_format($pagibig, 2) . '</td>
                <td>
                  <button type="button" class="viewPayrollDetails btn btn-success btn-sm btn-flat" refid="' . $cutoff_id . '" id="' . $empID . '"><span class="glyphicon glyphicon-file"></span> Print</button>
                </td>
              </tr>
              ';
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

  $data = array(
    'payroll_table' => $output,
    'empID' => $empID,
    'empName' => $empName
  );

  echo json_encode($data);
}
// delete me
// TAB 2
if (isset($_POST['empID2'])) {
  $empID = $_POST['empID2'];
  $cutoffID = $_POST['cutoffID'];

  $sqlCutoffpayslip = $cutoffID != 0 ? "SELECT *, employees.sss as empsss, employees.philhealth as empphil, employees.pagibig as emppag, employees.tin as emptin FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id WHERE payslip.cutoff_id='$cutoffID' AND employees.employee_id='$empID'" :
    "SELECT *, employees.sss as empsss, employees.philhealth as empphil, employees.pagibig as emppag, employees.tin as emptin FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id WHERE payslip.cutoff_id=(SELECT MAX(cutoff_id) FROM cutoff) AND employees.employee_id='$empID'";

  // $sqlCutoffpayslip = "SELECT * FROM employees LEFT JOIN payslip ON payslip.employee_id=employees.employee_id LEFT JOIN cutoff ON cutoff.cutoff_id = payslip.cutoff_id LEFT JOIN position ON position.id=employees.position_id WHERE employees.employee_id='$empID'";
  $resultCutoffpayslip = $conn->query($sqlCutoffpayslip);
  $rowpaylsipcutoff = $resultCutoffpayslip->fetch_assoc();

  $payroll_details = '
    <div class="panel">
      <table class="greyGridTable">
        <thead>
          <tr>
            <th colspan="5">RC Llaguno Construction</th>
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
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['emptin'] . '</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>DATE COVERED</b></td>
            <td width="20%" align="left">: (' . date("M j, Y", strtotime($rowpaylsipcutoff['start_date'])) . ' - ' . $end_date = date("M j, Y", strtotime($rowpaylsipcutoff['end_date'])) . ')</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>SSS NO.</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['empsss'] . '</td>
          </tr>
          <tr>
            <td width="20%" align="left"><b>POSITION</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['position'] . '</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>PHILHEALTH NO.</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['empphil'] . '</td>
          </tr>
          <tr>
            <td width="20%" align="left"><strong>PROJECT NAME: </strong>(<a style="font-style: italic; ">Current</a>)</td>
            <td width="10%" align="left">: project name here</td>
            <td width="10%"></td>
            <td width="20%" align="left"><b>HDMIF NO.</b></td>
            <td width="10%" align="left">: ' . $rowpaylsipcutoff['emppag'] . '</td>
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
            <th>₱ ' . number_format($rowpaylsipcutoff['total_compensation'], 2) . '</th>
            <th>TOTAL <br> DEDUCTIONS
            </th>
            <th>₱ ' . number_format($rowpaylsipcutoff['total_deduc'], 2) . '</th>
            <th>NET PAY</th>
            <th>₱ ' . number_format($rowpaylsipcutoff['netpay'], 2) . '</th>
          </tr>
        </tfoot>
        <tbody>
          <tr>
            <td width="20%" align="left"><b>RATE per HOUR</b></td>
            <td width="10%" align="left">' . number_format($rowpaylsipcutoff['rate'], 2) . '</td>
            <td width="20%" align="left"><strong>TAX</strong></td>
            <td width="10%" align="right">TAX VALUE HERE</td>
            <td width="20%" align="left"><b>TAX</b></td>
            <td width="10%" align="right">' . number_format($rowpaylsipcutoff['tax'], 2) . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>TOTAL HOURS</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['total_hour'] . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['sss'], 2) . '</td>
              <td width="20%" align="left"><b>SSS</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['ytd_sss'], 2) . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>BASIC</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['basic_pay'], 2) . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['philhealth'], 2) . '</td>
              <td width="20%" align="left"><b>PHILHEALTH</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['ytd_philhealth'], 2) . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b>OT (' . $rowpaylsipcutoff['ot_hours'] . ' hrs)</b></td>
              <td width="10%" align="right">' . $rowpaylsipcutoff['ot'] . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['hdmif'], 2) . '</td>
              <td width="20%" align="left"><b>HDMIF</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['ytd_hdmif'], 2) . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b></b></td>
              <td width="10%" align="right"></td>
              <td width="20%" align="left"><b>MATERIAL LOST</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['material_cost'], 2) . '</td>
              <td width="20%" align="left"><b>GROSS INCOME</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['ytd_grossincome'], 2) . '</td>
            </tr>
            <tr>
              <td width="20%" align="left"><b></b></td>
              <td width="10%" align="right"></td>
              <td width="20%" align="left"><b>CASH ADVANCE</b></td>
              <td width="10%" align="right">' . number_format($rowpaylsipcutoff['cash_advance'], 2) . '</td>
              <td width="20%" align="left"><b></b></td>
              <td width="10%" align="right"></td>
            </tr>
            </tbody>
            </table>

            <div class="flexDisplay">
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
               <div class="legend">
                  <table style="border:none">
                    <thead>
                      <th colspan="4">COMPUTATION</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Computation ng rate per hour</td>
                        <td>(OT)</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Computation for TAX</td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr> 
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>

                    </tbody>
                  </table>
              </div>

            </div>
            </div>
  ';

  $data = array(
    'payroll_details' => $payroll_details
  );

  echo json_encode($data);
}