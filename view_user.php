<?php include 'db_connect.php'; ?>
<?php
if (isset($_GET['id'])) {
    $type_arr = array('', "Admin", "User");
    $qry = $conn->query("SELECT id, firstname, lastname, type FROM users WHERE id = {$_GET['id']}")->fetch_assoc();
    if ($qry) {
        foreach ($qry as $key => $value) {
            $$key = $value; // Dynamically set variables based on query results
        }
    } else {
        echo "<div class='text-danger'>User not found.</div>";
        exit;
    }
}
?>
<div class="container-fluid">
    <div class="card card-widget widget-user shadow">
        <div class="widget-user-header bg-dark">
            <h3 class="widget-user-username"><?php echo ucwords($lastname . ', ' . $firstname); ?></h3>
            <h5 class="widget-user-desc"><?php echo isset($username) ? "Username: " . $username : "No username"; ?></h5>
        </div>
        <div class="widget-user-image">
            <span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px; height:90px;">
                <h4><?php echo strtoupper(substr($firstname, 0, 1) . substr($lastname, 0, 1)); ?></h4>
            </span>
        </div>
        <div class="card-footer">
            <div class="container-fluid">
                <dl>
                    <dt>User Type</dt>
                    <dd><?php echo $type_arr[$type]; ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
    #uni_modal .modal-footer.display {
        display: flex;
    }
</style>
