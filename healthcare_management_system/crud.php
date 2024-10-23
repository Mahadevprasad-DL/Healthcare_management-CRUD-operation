<?php
session_start();

$validUsername = "girish";
$validPassword = "123456";

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['loggedIn'] = true;
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $errorMessage = "Invalid username or password";
    }
}

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container my-5">
            <h2>Login</h2>

            <?php if (!empty($errorMessage)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="login">Sign In</button>
            </form>
        </div>
    </body>
    </html>

    <?php
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthcaremanagementsystem";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Insert Operation code
if(isset($_POST['addMedication'])){
    $medicationID = $_POST['medicationID'];
    $medicationName = $_POST['medicationName'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    
    $stmt = $conn->prepare("INSERT INTO medications (MedicationID, MedicationName, Dosage, Frequency) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $medicationID, $medicationName, $dosage, $frequency);
    
    if ($stmt->execute()) {
        echo "<p>New record created successfully</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}



// Delete Operation code
if(isset($_GET['deleteMedication'])){
    $id = $_GET['deleteMedication'];
    
    $stmt = $conn->prepare("DELETE FROM medications WHERE MedicationID=?");
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        echo "<p>Record deleted successfully</p>";
    } else {
        echo "<p>Error deleting record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}



// Update Operation code
if(isset($_POST['updateMedication'])){
    $id = $_POST['medicationID'];
    $medicationName = $_POST['medicationName'];
    $dosage = $_POST['dosage'];
    $frequency = $_POST['frequency'];
    
    $stmt = $conn->prepare("UPDATE medications SET MedicationName=?, Dosage=?, Frequency=? WHERE MedicationID=?");
    $stmt->bind_param("ssss", $medicationName, $dosage, $frequency, $id);
    
    if ($stmt->execute()) {
        echo "<p>Record updated successfully</p>";
    } else {
        echo "<p>Error updating record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$medicationToEdit = null;
if (isset($_GET['editMedication'])) {
    $id = $_GET['editMedication'];
    $stmt = $conn->prepare("SELECT * FROM medications WHERE MedicationID=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $medicationToEdit = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DEMO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
        .btn-edit {
            color: white;
            background-color: blue;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .btn-delete {
            color: white;
            background-color: red;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <input type="hidden" id="medicationID" name="medicationID" value="<?php echo $medicationToEdit ? $medicationToEdit['MedicationID'] : ''; ?>" required>
        <label for="medicationName">Medication Name:</label><br>
        <input type="text" id="medicationName" name="medicationName" value="<?php echo $medicationToEdit ? $medicationToEdit['MedicationName'] : ''; ?>" required><br>
        <label for="dosage">Dosage:</label><br>
        <input type="text" id="dosage" name="dosage" value="<?php echo $medicationToEdit ? $medicationToEdit['Dosage'] : ''; ?>" required><br>
        <label for="frequency">Frequency:</label><br>
        <input type="text" id="frequency" name="frequency" value="<?php echo $medicationToEdit ? $medicationToEdit['Frequency'] : ''; ?>" required><br><br>
        <input type="submit" value="<?php echo $medicationToEdit ? 'Update Medication' : 'Add Medication'; ?>" name="<?php echo $medicationToEdit ? 'updateMedication' : 'addMedication'; ?>">
    </form>

    <table>
        <tr>
            <th>Medication ID</th>
            <th>Medication Name</th>
            <th>Dosage</th>
            <th>Frequency</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM medications";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['MedicationID']."</td>
                        <td>".$row['MedicationName']."</td>
                        <td>".$row['Dosage']."</td>
                        <td>".$row['Frequency']."</td>
                        <td>
                            <a href='?editMedication=".$row['MedicationID']."' class='btn-edit'>Edit</a>
                            <a href='?deleteMedication=".$row['MedicationID']."' class='btn-delete'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No medications found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
