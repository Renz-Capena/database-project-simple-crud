<?php
    require_once "connection.php";

    // Delete
    if (isset($_GET["del"])) {
        $id = preg_replace('/\D/', '', $_GET["del"]); //Accept numbers only
        if ($stmt = $con->prepare("DELETE FROM `student_info` WHERE `id`=?")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $msg = '<div class="msg msg-delete">Record details deleted successfully.</div>';
        }
    }

    // Display
    $tabledata = "";


    if ($stmt = $con->prepare("SELECT * FROM `student_info`")) {
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tabledata .= '<tr>
                                <td style="text-transform:capitalize">'.$row["name"].'</td>
                                <td style="text-transform:capitalize">'.$row["email"].'</td>
                                <td>'.$row["contact"].'</td>
                                <td>
                                    <a href="update.php?id='.$row["id"].'" class="btnAction btnUpdate" title="Update contact details">&#9997;</a>
                                    <a href="index.php?del='.$row["id"].'" class="btnAction btnDelete" title="Delete contact details">&#10006;</a>
                                </td>
                                </tr>';
            }
        }

        $stmt->close();
    }
    // Close database
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD in MySQL</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body{
    background-image: url(blue3.jpg);
    background-size: cover;

    }
    thead tr th{
      background: #1e90ff;
      color: #f2f3f4;
      font-size: 16px;
    }
    .btnCreate{
      background: rgba(0, 0, 0, 0.4);
      margin: 30px 0 10px 0;
      border: 2px solid #f0f0f0;
      border-radius: 30px;
      color: #f0f0f0;
    }
    .btnCreate:hover{
      color:whitesmoke;
      background: #03c03c;
      transition-duration: 0.4s;
    }
    tbody tr:hover{
      background:#0265e6;
      color: white;
      transition-duration: 0.3s;
    }
    .con{
      margin: auto;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .container{
      background: rgba(0, 0, 0, 0.3);
      margin-top: 90px;
      width: 800px;
      border-radius: 20px;
      position: absolute;
      z-index: 1;
    }
    .b1{
      display: flex;
      justify-content: center;
      align-items: right;
    }
    hr{
      margin: auto;
      margin-top: 20px;
      border-bottom: 2px solid;
      width: 600px;
    }

    </style>
</head>
<body>

    <?php if(isset($msg)){ echo $msg; }?>
<div class="b1">
    <main class="container">
        <div class="wrapper">
            <h1>Database connection in HTML</h1>
            <h2>======== Project in Adv. Database System =======</h2>
            <h4>Created by: MERJJ</h3>
            <hr>
        </div>
        <div class="con">
        <div class="wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo $tabledata;
                    ?>
                </tbody>
            </table>
        </div>
      </div>
      <div class="wrapper">
            <a href="create.php" class="btnCreate">Create New Record</a>
        </div>
        </div>
    </main>
</body>
</html>
