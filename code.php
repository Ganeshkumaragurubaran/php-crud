<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_employee']))
{
    $employee_id = mysqli_real_escape_string($con, $_POST['delete_employee']);

    $query = "DELETE FROM employees WHERE id='$employee_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "employee Deleted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "employee Not Deleted";
        header("Location: index.php");
        exit(0);
    }
}


if (isset($_POST['update_employee'])) {
    $employee_id = mysqli_real_escape_string($con, $_POST['employee_id']);

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);

    // Validate inputs
    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($department)) {
        $errors['department'] = "Department is required.";
    }

    if (empty($designation)) {
        $errors['designation'] = "Designation is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors['mobile'] = "Invalid mobile number format.";
    }

    // Check for errors before updating the database
    if (empty($errors)) {
        // Perform database update
        $name = mysqli_real_escape_string($con, $name);
        $department = mysqli_real_escape_string($con, $department);
        $designation = mysqli_real_escape_string($con, $designation);
        $email = mysqli_real_escape_string($con, $email);
        $mobile = mysqli_real_escape_string($con, $mobile);

        $query = "UPDATE employees SET emp_name='$name', emp_dept='$department', emp_desg='$designation', emp_mail='$email', emp_mobile='$mobile' WHERE id='$employee_id' ";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['message'] = "Employee Updated Successfully";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Employee Not Updated";
            header("Location: index.php");
            exit(0);
        }
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
        echo "<script>window.history.go(-1);</script>";
        exit(0);
    }
}

if (isset($_POST['save_employee'])) {
    $name = trim($_POST['name']);
    $department = trim($_POST['department']);
    $designation = trim($_POST['designation']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    // Validate inputs
    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($department)) {
        $errors['department'] = "Department is required.";
    }

    if (empty($designation)) {
        $errors['designation'] = "Designation is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($mobile)) {
        $errors['mobile'] = "Mobile is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors['mobile'] = "Invalid mobile number format.";
    }

    // Check for errors before inserting into the database
    if (empty($errors)) {
        // Perform database insert
        $name = mysqli_real_escape_string($con, $name);
        $department = mysqli_real_escape_string($con, $department);
        $designation = mysqli_real_escape_string($con, $designation);
        $email = mysqli_real_escape_string($con, $email);
        $mobile = mysqli_real_escape_string($con, $mobile);

        $query = "INSERT INTO employees (emp_name, emp_dept, emp_desg, emp_mail, emp_mobile) VALUES ('$name','$department','$designation','$email','$mobile')";

        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['message'] = "Employee Created Successfully";
            header("Location: employee-create.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Employee Not Created";
            header("Location: employee-create.php");
            exit(0);
        }
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
        echo "<script>window.history.go(-1);</script>";
        exit(0);
    }
}
?>