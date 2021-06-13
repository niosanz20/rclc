<?php session_start(); ?>
<?php include 'header.php'; ?>
<? include 'includes/conn.php'; ?>
<!--Connection -->
<!--Hello from github -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- Instascan JS - 10/23/2020 -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<body class="hold-transition login-page">
    <div class="login-logo">
        <p id="date" class="h1"></p>
        <p id="time" class="bold"></p>
    </div>
    <!-- ATTENDANCE -->
    <!-- new line -->
    <div class="row">
        <!-- CAMERA -->
        <div class="box box-default rclcbox">
            <div class="box-header with-border">
                <i class="fa fa-bullhorn"></i>
                <h4 class="box-title">Camera</h4>
                <input type="hidden" readonly="readonly" class="form-control input-lg" id="employee" name="employee"
                    required>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="login-box">
                    <!-- webcam size - 10/23/2020 -->
                    <video id="preview" width="360" height="240"></video>
                </div>

                <div class="form-group">
                    <select class="btn dropdown-toggle center-block" name="status" id="status"
                        style="width: 110px; border: solid 2px #517B97; font-size: 15px; font-weight:bold;">
                        <option value="in">Time In</option>
                        <option value="out">Time Out</option>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.col -->
    </div>

    <!-- Script in QR Code scanning-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });
    scanner.addListener('scan', function(content) {
        // var employee = document.getElementById("employee");
        employee.value = content;
        if (employee.value != '') {
            var status = $('#status').val();
            $.ajax({
                type: 'POST',
                url: 'attendance.php',
                data: {
                    status: status,
                    employee: employee.value
                },
                dataType: "json",
                success: function(data) {
                    switch (data.status) {

                        case 'Invalid QR Code':
                            SweetAlert(data, 'error');
                            break;

                        case 'Time-in':
                            SweetAlert(data, 'success');
                            break;

                        case 'Time-out':
                            SweetAlert(data, 'success');
                            break;

                        default: //Already Time-in, Already Time-out, No project on-going, Warning, will fall here...
                            SweetAlert(data, 'warning');
                            break;
                    }
                },
                error: function(data) {
                    SweetAlert(data, 'error');
                }
            });
        }

    });

    function SweetAlert(data, icon) {
        Swal.fire({
            title: data.status,
            html: data.message,
            icon: icon
        });
    }

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);

        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
    });
    </script>

    <?php include 'scripts.php' ?>
    <script type="text/javascript">
    $(function() {
        var interval = setInterval(function() {
            var momentNow = moment();
            $('#date').html(momentNow.format('dddd').substring(0, 3).toUpperCase() + ' - ' + momentNow
                .format('MMMM DD, YYYY'));
            $('#time').html(momentNow.format('hh:mm:ss A'));
        }, 100);

        //   $('#attendance').submit(function(e) {
        //     e.preventDefault();
        //     var attendance = $(this).serialize();
        //     $.ajax({
        //       type: 'POST',
        //       url: 'attendance.php',
        //       data: attendance,
        //       dataType: 'json',
        //       success: function(response) {
        //         if (response.error) {
        //           $('.alert').hide();
        //           $('.alert-danger').show();
        //           $('.message').html(response.message);
        //         } else {
        //           $('.alert').hide();
        //           $('.alert-success').show();
        //           $('.message').html(response.message);
        //           $('#employee').val('');
        //         }
        //       }
        //     });
        //   });
    });
    </script>
</body>

</html>
