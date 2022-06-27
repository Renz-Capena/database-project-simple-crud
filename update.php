<?php
    require_once "connection.php";

    // Get contact details
    if (isset($_GET["id"])) {
        $id = preg_replace('/\D/', '', $_GET["id"]); //accept number
    } else {
        header("Location: index.php?p=update&err=no_id");
    }

    // Update
    if (isset($_POST["btnUpdate"])) {
        $name    = $con->real_escape_string($_POST["txtName"]);
        $email   = $con->real_escape_string($_POST["txtEmail"]);
        $contact = $con->real_escape_string($_POST["txtContact"]);

        if ($stmt = $con->prepare("UPDATE `student_info` SET `name`=?, `email`=?, `contact`=? WHERE `id`=?")) {
            $stmt->bind_param("sssi", $name, $email, $contact, $id);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-update">Record details updated successfully.</div>';
        } else {
            $msg = '<div class="msg">Prepare() failed: '.htmlspecialchars($con->error).'</div>';
        }
    }


    if ($stmt = $con->prepare("SELECT `name`, `email`, `contact` FROM `student_info` WHERE `id`=? LIMIT 1")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($name, $email, $contact);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    } else {
        die('prepare() failed: ' . htmlspecialchars($con->error));
    }

    // Close database connection
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data </title>
    <link rel="stylesheet" href="style.css">
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
        font-size: 30px;
        color: #fec001;
        text-transform: uppercase;
    }
    hr{
        border: 1px solid #FEC001;
        margin-top: 5px;
    }
    .frm{
      margin-top:50px;
    }

    </style>
</head>
<body>
    <?php if(isset($msg)){ echo $msg; }?>
    <main class="container">
        <div class="wrapper">
                <h2>Update Record</h2>
                <hr>
            <div class="frm">
            <form action="<?=$_SERVER['PHP_SELF']."?id=".$id;?>" method="post" class="frmUpdate">
                <input type="text" name="txtName" placeholder="Name" value="<?php echo $name; ?>" autocomplete="off" required>
                <input type="email" name="txtEmail" placeholder="Email" value="<?php echo $email; ?>" autocomplete="off" required>
                <input type="number" min="0" name="txtContact" placeholder="Contact Number" value="<?php echo $contact; ?>" autocomplete="off" required>
                <div class="btnWrapper">
                    <button type="submit" name="btnUpdate" class="btnUpdate" title="Update contact details">Update</button>
                    <a href="index.php" class="btnHome" title="Return back to homepage">Home</a>
                </div>
            </form>
          </div>
        </div>
    </main>
</body>
</html>
