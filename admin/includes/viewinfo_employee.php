<?php
include '../includes/conn.php';

//pagkuha ng employee, postion, at schedules
if (isset($_POST['empID'])) {
    $empID = $_POST['empID'];
    $sqlprofile = "SELECT * FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id='$empID'";
    $queryprofile = $conn->query($sqlprofile);
    $rowprofile = $queryprofile->fetch_assoc();

    // //pagkuha ng cut-off dates
    // $sqlCutoff = "SELECT * FROM cutoff ORDER BY end_date DESC";
    // $resultCutoff = mysqli_query($conn, $sqlCutoff);

    $modalemployee = '
            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                    Employee Information 
                        <button type="button" class=" btn btn-sm btn-danger close" aria-label="Close">
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center text-center" style="justify-content: center">
                            <img src="../images/' . $rowprofile['photo'] . '" alt="Admin" class="rounded-circle"
                                style="max-height: 150px;max-width: 150px;">
                            <div class="mt-3" style="padding: 3rem;">
                                <h4>' . $rowprofile['firstname'] . ' ' . $rowprofile['lastname'] . '</h4>
                                <p class="text-secondary mb-1">' . $rowprofile['description'] . '</p>
                                <p class="text-muted font-size-sm">' . $rowprofile['address'] . '</p>
                            </div>
                            <img src="' . $rowprofile['qrimage'] . '" alt="Admin" class="rounded-circle"
                               style="max-height: 150px;max-width: 150px;">
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Schedule</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                ' . date('h:i A', strtotime($rowprofile['time_in'])) . ' - ' . date('h:i A', strtotime($rowprofile['time_out'])) . '
                            </div>
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>SSS</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                TBA
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Contact #</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                ' . $rowprofile['contact_info'] . '
                            </div>
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Pag-ibig</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                TBA
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Gender</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                ' . $rowprofile['gender'] . '
                            </div>
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Philhealth</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                               TBA
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Birthday</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                            ' . $end_date = date("M j, Y", strtotime($rowprofile['birthdate'])) . '
                            </div>
                            <div class="col-sm-2">
                                <h6 class="mb-0"><b>Tin</b></h6>
                            </div>
                            <div class="col-sm-4 text-secondary" style="margin-top: 7px;">
                                TBA
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
          </div>
        ';


    $data = array(
        'employee_modal' => $modalemployee
    );

    echo json_encode($data);
}
