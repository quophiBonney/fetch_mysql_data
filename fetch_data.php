<?php 
require ("db.php");
if(isset($_POST['register'])){
    $employeeName = $_POST['employeeName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $image = $_FILES['image'];
    $filename = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "uploaded_img/".$filename;
    if($email == $email){
    $isEmployeenameTaken = "SELECT * FROM workers WHERE employeeName = '$employeeName' AND email = '$email'";
    $query = mysqli_query($conn, $isEmployeenameTaken);
    $num = mysqli_num_rows($query);
    if($num > 0){
    $message[] = 'Employee is already registered <i class="fa fa-times ml-3"></i>';
    }else {
        $sql = "INSERT INTO workers(employeeName, email, contact, image)
        VALUES('$employeeName', '$email', '$contact', '$filename')";
        $query = mysqli_query($conn, $sql);
        if($query && move_uploaded_file($tmp_name, $folder)){
            $message[] = 'Worker registered successfully <i class="fa fa-correct ml-5"></i>';
        }else {
            $message[] = 'Something went wrong';
        }
    }
}else {
    $message[] = 'Try again later';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data From MySQL Database Using PHP</title>

    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <!--Bootstrap CDN-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!--Custom CSS-->
    <link rel="stylesheet" href="bootstrap/css/main.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5 shadow">
                <form action="fetch_data.php" method="POST" enctype="multipart/form-data">
                    <h3 class="text-center">EMPLOYEES FORM</h3>
                    <p class="text-center">register your new workers</p>
                    <hr class="bg-dark">
                    <?php 
                    if(isset($message)){
                        foreach($message as $message){
                            echo '<div class="form-control shadow text-uppercase text-danger
                            text-center message font-weight-bold">
                             '. $message .' </div>';
                        }
                    }
                    ?>
                     <div class="form-group pt-2 d-flex">
                         <label>Name:</label>
                        <input type="text" name="employeeName" class="form-control" required>
                   </div>
                    <div class="form-group pt-2 d-flex">
                       <label>Email:</label>
                       <input type="email" name="email" class="form-control" required>
                    </div>
                   <div class="form-group pt-2 d-flex">
                        <label>Mobile:</label>
                        <input type="number" name="contact" class="form-control" required>
                    </div>
            
                    <div class="form-group pt-2">
                        <input type="file" name="image" accept="image/jpeg, image/jpg, image/png, image/jfif" class="form-control">
                    </div>
                    <div class="form-group pt-2">
                        <input type="submit" name="register" value="REGISTER" class="form-control bg-danger text-light">
                    </div>
                    <br>
            </div>
            </form>
        </div>
    </div>
    </div>

    <div class="container">
        <table class="table stripped">
            <thead>
                <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Picture</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT employeeName,email,contact,image FROM workers";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_assoc($query)){
                        ?>
                    <tr>
                        <td><?php echo $row['employeeName'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><img class="img-fluid" src="uploaded_img/<?php echo $row['image']?>"></td>

                    </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>