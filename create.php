<?php
    if (isset($_POST["btnSave"])) {

        require_once "connection.php";

        $name    = $con->real_escape_string($_POST["txtName"]);
        $email   = $con->real_escape_string($_POST["txtEmail"]);
        $contact = $con->real_escape_string($_POST["txtContact"]);

        if ($stmt = $con->prepare("INSERT INTO `student_info`(`name`, `email`, `contact`) VALUES (?, ?, ?)")) {
            $stmt->bind_param("sss", $name, $email, $contact);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-create">New record saved successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }

        $con->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD with Search in PHP and MySQL </title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body{
    background-image: url(blue3.jpg);
    background-size: cover;
    height: 500px;
    }
    .container{
      border-radius: 20px;
      background: rgba(0, 0, 0, 0.3);
      width: fit-content;
      margin: auto;
      margin-top: 25vh;
    }
    h2{
        color: #1ba345;
        font-size: 30px;
    }
    hr{
        border: 1px solid #1ba345;
        margin-top: 15px;
    }
    .frm{
      margin-top:50px;
    }
</style>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
                <h2>Create New Record</h2>
                <hr>
        <div class="frm">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="frmCreate">
                <input type="text" name="txtName" placeholder="Name" autocomplete="off" required>
                <input type="email" name="txtEmail" placeholder="Email" autocomplete="off" required>
                <input type="number" min="0" name="txtContact" placeholder="Contact Number" autocomplete="off" required>
                <div class="btnWrapper">
                    <button type="submit" name="btnSave" title="Save contact details">Save</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
        </div>

        </div>
    </main>
</body>
</html>
