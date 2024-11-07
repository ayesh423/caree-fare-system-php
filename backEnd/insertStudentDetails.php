<?php
include('db_connection.php');

$conn = new mysqli("10.10.10.157", "csc210user", "CSC210!", "group4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$target_dir = "../Files/";  
$target_file = $target_dir . basename($_FILES["resume"]["name"]);
$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$allowed_file_types = ['pdf', 'doc', 'docx'];
if (!in_array($file_type, $allowed_file_types)) {
    echo "<script>alert('Sorry, only PDF, DOC, and DOCX files are allowed.');</script>";
    exit;
}

if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
    $resume = $target_file;
} else {
    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    exit;
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$regNo = $_POST['regNo'];
$email = $_POST['email'];
$phoneNo = $_POST['phoneNo'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$uniName = $_POST['uniName'];
$degreeProgram = $_POST['degreeProgram'];
$yearOfStudy = $_POST['yearOfStudy'];
$GraduationDate = $_POST['GraduationDate'];
$CGPA = $_POST['CGPA'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
$skills = $_POST['skills'];

$sql = "INSERT INTO students (firstname, lastname, StudentRegNo, email, phoneNo, dateOfBirth, gender, uniName, degreeProgram, yearOfStudy, GraduationDate, CGPA, username, password, resume, skills)
        VALUES ('$firstname', '$lastname', '$regNo', '$email', '$phoneNo', '$dateOfBirth', '$gender', '$uniName', '$degreeProgram', '$yearOfStudy', '$GraduationDate', '$CGPA', '$username', '$password', '$resume', '$skills')";

if ($conn->query($sql) === TRUE) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: 'You have successfully registered!',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '../Student_register.php';
            });
        </script>
    </body>
    </html>
    ";
} else {
    echo "<script>alert('Error Occurred: " . $conn->error . "');</script>";
}

$conn->close();
?>