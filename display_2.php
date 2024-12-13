<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LAB 5B";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}


$editMode = false;
$matric = $name = $level = "";


if (isset($_GET['edit'])) 
{
    $editMode = true;
    $matric = $_GET['edit'];
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $level = $row['level'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) 
{
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $level = $_POST['level'];

    $sql = "UPDATE users SET name='$name', level='$level' WHERE matric='$matric'";
    if ($conn->query($sql)) {
        echo "<p style='color:green;'>User informations has updated successfully.</p>";
    } else {
        echo "<p style='color:red;'>Error updating user: " . $conn->error . "</p>";
    }
    $editMode = false;  
}


if (isset($_GET['delete'])) 
{
    $matric = $_GET['delete'];
    $sql = "DELETE FROM users WHERE matric='$matric'";

    if ($conn->query($sql)) 
    {
        echo "<p style='color:green;'>Userinformation has deleted successfully.</p>";
    } else 
    {
        echo "<p style='color:red;'>Error in deleting user data: " . $conn->error . "</p>";
    }
}


$sql = "SELECT * FROM users";

$result = $conn->query($sql);
?>
<!DOCTYPE html>

<html lang="en">

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User List Management</title>

    <style>

        table { border-collapse: collapse; width: 100%; }

        th, td { border: 1px solid black; padding: 8px; text-align: left; }

        th { background-color: #f2f2f2; }

    </style>

</head>

<body>
    
    
    <?php if ($editMode): ?>

        <h2>Update User</h2>

        <form method="POST">

            <label>Matric:</label><br>
            <input type="text" name="matric" value="<?php echo $matric; ?>" readonly><br><br>
            <label>Name:</label><br>
            <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>
            <label>Access Level:</label><br>
            <input type="text" name="level" value="<?php echo $level; ?>" required><br><br>
            <button type="submit" name="update">Update</button>
            <a href="index.php">Cancel</a>
        </form>''
    <?php endif; ?>

    <h2>User Management List</h2>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['matric']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td>
                        <a href="?edit=<?php echo $row['matric']; ?>">Update</a> |

                        <a href="?delete=<?php echo $row['matric']; ?>" onclick="return confirm('DO you want to delete it?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No users found.</td>
            </tr>
        <?php endif; ?>

    </table>

</body>

</html>
