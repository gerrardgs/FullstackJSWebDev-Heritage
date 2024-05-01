<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include("connection.php");

$error_message = ""; // Definisi awal variabel $error_message

if (isset($_POST["submit"])) {
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $name = htmlentities(strip_tags(trim($_POST["name"])));
    $birth_city = htmlentities(strip_tags(trim($_POST["birth_city"])));
    $faculty = htmlentities(strip_tags(trim($_POST["faculty"])));
    $department = htmlentities(strip_tags(trim($_POST["department"])));
    $gpa = htmlentities(strip_tags(trim($_POST["gpa"])));
    $birth_date = htmlentities(strip_tags(trim($_POST["birth_date"])));
    $birth_month = htmlentities(strip_tags(trim($_POST["birth_month"])));
    $birth_year = htmlentities(strip_tags(trim($_POST["birth_year"])));


    // Validasi input
    if (empty($nim)) {
        $error_message .= "- NIM belum diisi <br>";
    } elseif (!preg_match("/^[0-9]{8}$/", $nim)) {
        $error_message .= "- NIM harus berupa 8 digit angka <br>";
    }

    if (empty($name)) {
        $error_message .= "- Nama belum diisi <br>";
    }

    if (empty($birth_city)) {
        $error_message .= "- Tempat lahir belum diisi <br>";
    }

    if (empty($department)) {
        $error_message .= "- Jurusan belum diisi <br>";
    }

    if (!is_numeric($gpa) OR ($gpa <= 0)) {
        $error_message .= "- IPK harus diisi dengan angka <br>";
    }

    if ($error_message === "") {
        $nim = mysqli_real_escape_string($connection, $nim);
        $name = mysqli_real_escape_string($connection, $name);
        $birth_city = mysqli_real_escape_string($connection, $birth_city);
        $faculty = mysqli_real_escape_string($connection, $faculty);
        $department = mysqli_real_escape_string($connection, $department);
        $birth_date = mysqli_real_escape_string($connection, $birth_date);
        $birth_month = mysqli_real_escape_string($connection, $birth_month);
        $birth_year  = mysqli_real_escape_string($connection, $birth_year);
        $gpa = (float) $gpa;

        $birth_date_full = $birth_year."-".$birth_month."-".$birth_date;

        $query = "UPDATE student SET 
                  name = '$name', 
                  birth_city = '$birth_city', 
                  birth_date = '$birth_date_full', 
                  faculty = '$faculty', 
                  department = '$department', 
                  gpa = $gpa 
                  WHERE nim = '$nim'";

        $result = mysqli_query($connection, $query);

        if ($result) {
            $message = "Data mahasiswa dengan NIM <b>$nim</b> berhasil diperbarui";
            $message = urlencode($message);
            header("Location: student_view.php?message={$message}");
            exit();
        } else {
            die ("Query gagal dijalankan: ".mysqli_errno($connection). " - ".mysqli_error($connection));
        }
    }
} else {
    if (isset($_GET["nim"])) {
        $nim_to_edit = $_GET["nim"];
        $query = "SELECT * FROM student WHERE nim='$nim_to_edit'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
            die("Data mahasiswa tidak ditemukan.");
        }

        $data = mysqli_fetch_assoc($result);

        // Format tanggal lahir untuk ditampilkan di form
        $birth_date_parts = explode("-", $data["birth_date"]);
        $birth_year = $birth_date_parts[0];
        $birth_month = $birth_date_parts[1];
        $birth_date = $birth_date_parts[2];

        mysqli_free_result($result);
    } else {
        header("Location: student_view.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet" >
</head>
<body>
<div class="container">
    <div id="header">
        <h1 id="logo">Edit Data Mahasiswa</h1>
    </div>
    <hr>
    <nav>
        <ul>
            <li><a href="student_view.php">Tampil</a></li>
            <li><a href="student_add.php">Tambah</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h2>Edit Data Mahasiswa</h2>
    <?php
    if ($error_message !== "") {
        echo "<div class='error'>$error_message</div>";
    }
    ?>
    <form id="form_mahasiswa" action="student_edit.php" method="post">
    <fieldset>
        <legend>Data Mahasiswa</legend>
        <p>
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" value="<?php echo $data['nim']; ?>" readonly>
        </p>
        <p>
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>">
        </p>
        <p>
            <label for="birth_city">Tempat Lahir:</label>
            <input type="text" id="birth_city" name="birth_city" value="<?php echo $data['birth_city']; ?>">
        </p>
        <p>
            <label for="birth_date">Tanggal Lahir:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['birth_date']; ?>">
        </p>
        <p>
            <label for="faculty">Fakultas:</label>
            <select id="faculty" name="faculty">
                <option value="FTIB" <?php echo ($data['faculty'] == 'FTIB') ? 'selected' : ''; ?>>FTIB</option>
                <option value="FTEIC" <?php echo ($data['faculty'] == 'FTEIC') ? 'selected' : ''; ?>>FTEIC</option>
            </select>
        </p>
        <p>
            <label for="department">Jurusan:</label>
            <input type="text" id="department" name="department" value="<?php echo $data['department']; ?>">
        </p>
        <p>
            <label for="gpa">IPK:</label>
            <input type="text" id="gpa" name="gpa" value="<?php echo $data['gpa']; ?>">
        </p>
        <input type="submit" name="submit" value="Simpan">
    </fieldset>
</form>

</div>
</body>
</html>

<?php
mysqli_close($connection);
?>