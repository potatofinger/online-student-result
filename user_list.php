<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $type = array('', "Admin", "Registrar");
                    $qry = $conn->query("SELECT id, firstname, lastname, type FROM users ORDER BY lastname ASC, firstname ASC");
                    while ($row = $qry->fetch_assoc()):
                        $name = ucwords($row['lastname'] . ', ' . $row['firstname']);
                        $role = isset($type[$row['type']]) ? $type[$row['type']] : 'N/A';
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++; ?></th>
                        <td><b><?php echo $name; ?></b></td>
                        <td><b><?php echo $role; ?></b></td>
                        <td class="text-center">
                            <!-- View Button -->
                            <a class="btn btn-info btn-sm" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" onclick="viewUser(<?php echo $row['id']; ?>)">View</a>
                            
                            <!-- Edit Button -->
                            <a class="btn btn-warning btn-sm" href="./index.php?page=edit_user&id=<?php echo $row['id']; ?>">Edit</a>
                            
                            <!-- Delete Button -->
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</a>
                        </td>
                    </tr>  
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#list').dataTable();
    });

    function viewUser(id) {
        // Assuming you're using a modal to show the user details.
        uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + id);
    }

    function deleteUser(id) {
        _conf("Are you sure you want to delete this user?", "delete_user", [id]);
    }

    function delete_user(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_user',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
