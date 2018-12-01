<?php
session_start();
if (!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0) {
    header('Location: 404.php');
}
$type = "Add";
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    include_once "database/database.php";
    $userInfo = GetUserInfo($_GET['id']);
    foreach ($userInfo as $u) {
        $login = $u['login'];
        $privilege = $u['role'];
        $isActive = $u['valid'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php
    if ($type == "Edit") {
        echo("<title>Edit Account</title>");
    }
    if ($type == "Add") {
        echo("<title>New Account</title>");
    }
    if ($type == "Password") {
        echo("<title>Change Password</title>");
    }
    ?>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">
            <?php
            if ($type == "Edit") {
                echo "Edit an Account";
            }
            if ($type == "Add") {
                echo "Register an Account";
            }
            if ($type == "Password") {
                echo "Update Password";
            } ?>
        </div>
        <div class="card-body">
            <form method="post" action="validate-user.php?type=<?php echo $type ?>">

                <?php
                if ($type == "Add") {
                    ?>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input name="login" type="text" id="login" class="form-control"
                                           placeholder="First name" required="required" autofocus="autofocus">
                                    <label for="login">Login</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input name="password" type="password" id="password" class="form-control"
                                           placeholder="Password" required="required" value="">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <select name="userPrivileges" id="userPrivileges" class="form-control">
                                        <option value="0">User privileges :</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Standard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">


                                    <label>
                                        <input name="isValid" id="isValid" type="checkbox" value="1">
                                        Account is active
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Validate"/>
                    <a class="btn btn-primary btn-block" href="admin.php">Cancel</a>
                    <?php
                }
                if ($type == "Edit") {
                    ?>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input name="login" type="text" id="login" class="form-control"
                                           placeholder="First name" required="required" autofocus="autofocus"
                                           value="<?php echo $_GET['id'] ?>">
                                    <label for="login">Login</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <select name="userPrivileges" id="userPrivileges" class="form-control">
                                        <option value="0">User privileges :</option>
                                        <option value="1" <?php echo $privilege == 0 ? 'selected' : '' ?>>Admin</option>
                                        <option value="2" <?php echo $privilege == 1 ? 'selected' : '' ?>>Standard
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <label>
                                        <input name="isValid" id="isValid" type="checkbox"
                                               value="1" <?php echo $isActive ? "checked" : "" ?>>
                                        Account is active
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Validate"/>
                    <a class="btn btn-primary btn-block" href="admin.php">Cancel</a>
                    <?php
                }
                if ($type == "Password") {
                    ?>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input name="login" type="text" id="login" class="form-control"
                                           placeholder="First name" required="required" autofocus="autofocus"
                                           value="<?php echo $login ?>">
                                    <label for="login">Login</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input name="password" type="password" id="password" class="form-control"
                                           placeholder="Password" required="required" value="">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Validate"/>
                    <a class="btn btn-primary btn-block" href="admin.php">Cancel</a>
                    <?php
                }
                ?>


            </form>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
