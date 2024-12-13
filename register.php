<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        label, input 
        {
            display: block;
            margin: 10px 0;
        }
    </style>

</head>

<body>

    <h2>Register</h2>

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

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  
        $role = $_POST['role'];  

        
        $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

       
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else 
        {
            echo "Its' an Error: " . $sql . "<br>" . $conn->error;
        }
    }

    
    $conn->close();
    ?>

    <form action="register.php" method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="role">Role:</label>
        <select id="role" name="role" required>
        <option value="">Please select</option>
        <option value="Admin">Admin</option>
        <option value="User">User</option>
        </select>

        <input type="submit" value="Submit">
    </form>

    
</body>

</html>