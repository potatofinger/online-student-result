<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_user" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <b class="text-muted">Personal Information</b>
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? htmlspecialchars($firstname) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? htmlspecialchars($lastname) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <b class="text-muted">System Credentials</b>
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input type="text" name="username" class="form-control form-control-sm" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                            <small id="msg"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? 'required' : ''; ?>>
                            <small><i><?php echo isset($id) ? 'Leave this blank if you do not want to change your password' : ''; ?></i></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($id) ? 'required' : ''; ?>>
                            <small id="pass_match" data-status=""></small>
                        </div>
                        <?php if ($_SESSION['login_type'] == 1): ?>
                        <div class="form-group">
                            <label class="control-label">User Role</label>
                            <select name="type" id="type" class="custom-select custom-select-sm">
                                <option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : ''; ?>>Admin</option>
                                <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : ''; ?>>User</option>
                            </select>
                        </div>
                        <?php else: ?>
                            <input type="hidden" name="type" value="2">
                        <?php endif; ?>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right d-flex justify-content-center">
                    <button class="btn btn-primary mr-2" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('[name="password"], [name="cpass"]').keyup(function () {
        var pass = $('[name="password"]').val();
        var cpass = $('[name="cpass"]').val();
        if (cpass === '' || pass === '') {
            $('#pass_match').attr('data-status', '').html('');
        } else {
            if (cpass === pass) {
                $('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>');
            } else {
                $('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
            }
        }
    });

    $('#manage_user').submit(function (e) {
        e.preventDefault();
        $('input').removeClass('border-danger');
        $('#msg').html('');
        if ($('[name="password"]').val() !== '' && $('[name="cpass"]').val() !== '') {
            if ($('#pass_match').attr('data-status') !== '1') {
                $('[name="password"], [name="cpass"]').addClass('border-danger');
                return false;
            }
        }
        $.ajax({
            url: 'ajax.php?action=save_user',
            data: $(this).serialize(),
            method: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert_toast('Data successfully saved.', 'success');
                    setTimeout(function () {
                        location.replace('index.php?page=user_list');
                    }, 750);
                } else if (resp == 2) {
                    $('#msg').html("<div class='alert alert-danger'>Username already exists.</div>");
                    $('[name="username"]').addClass('border-danger');
                } else {
                    alert_toast('An error occurred. Please try again.', 'danger');
                }
            },
        });
    });
</script>
