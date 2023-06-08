<?php 
$conn = mysqli_connect('localhost','root','','edms');
if(!$conn){
    echo "Could not connect to the database";
}

$sql = "SELECT * FROM logs";
$result = mysqli_query($conn,$sql);

if(isset($_POST['back'])){
    header("location:index");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>EDMS DOCUMENTS PAGE</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- <link href="DataTables/datatables.min.css" rel="stylesheet"/> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container col-10 mt-4">
        <?php 
         if(mysqli_num_rows($result)<=0){
            $message = "No system logs available";
            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" >
            <?php echo $message;?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
            </div>';
            ?>
            <?php
        }else{

        }
        ?>
       
<div class="table-responsive">
    <table class="table table-striped table-bordered table-dark table-hover" id="logs">
        <thead>
            <tr>
                <td><a href="index" class="btn btn-danger text-capitalize font-weight-bold" name="back">BACK</a></td>
                <td><a href="" class="btn btn-light text-capitalize font-weight-bold">Clear Logs</a></td>
                <td><a href="" class="btn btn-warning text-capitalize font-weight-bold">Export Logs</a></td>
            </tr>
            <tr>
                <td class="text-center font-weight-bold">#</td>
                <td class="text-center font-weight-bold">fullname</td>
                <td class="text-center font-weight-bold">User Type</td>
                <td class="text-center font-weight-bold">Email</td>
                <td class="text-center font-weight-bold">Login time</td>
                <td class="text-center font-weight-bold">Logout time</td>
                <td class="text-center font-weight-bold">Total time</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = $result->fetch_assoc()){
                ?>
            <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['fullname'];?></td>
                <td><?php echo $row['user_type'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['login_time'];?></td>
                <td><?php echo $row['logout_time'];?></td>
                <td><?php echo $row['total_time'];?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
</body>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
<script type="text/javascript">
       $(document).ready( function () {
    $('#logs').DataTable();
} );
</script>
<!-- <script src="DataTables/datatables.min.js"></script> -->
<script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/popper/popper.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script>
</html>