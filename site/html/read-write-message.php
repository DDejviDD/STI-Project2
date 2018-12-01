<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$type = $_GET['type'];
$id = $_GET['id'];
$receiver="";
$subject="";
$content="";
$time = $formatted_time = date('Y-m-d H:i:s', time());
include_once "database/database.php";
$r = ListMessage($_SESSION['username']);
foreach ($r as $m){
    if($m['id'] == $id){
        $receiver = $m['sender'];
        $subject = $m['title'];
        $content = $m['message'];
        $time = $m['time'];
    }
}
if($type == "Answer"){
    $subject = "RE:".$subject;
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

    <title>New Message</title>

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
            if($type == "New"){     echo "New message"; }
            if($type == "Details"){ echo "Details";     }
            if($type == "Answer"){  echo "Answer";      }
            ?>
        </div>
        <div class="card-body">
            <form method="post" action="validate-message.php?type=<?php echo $type?>">
                <?php
                if($type == "Details"){
                ?>
                <div class="form-group">
                    <div class="form-label-group">
                        <input name="time" type="text" id="time" class="form-control" placeholder="Reception date" disabled value="<?php echo $time?>">
                        <label for="to">Reception date</label>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <div class="form-label-group">
                        <input name="to" type="text" id="to" class="form-control" placeholder="Recipient" required="required"
                               autofocus="autofocus" value="<?php echo $receiver?>">
                        <label for="to">Recipient</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input name="subject" type="text" id="subject" class="form-control" placeholder="Subject" required="required" value="<?php echo $subject?>">
                        <label for="subject">Subject</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Message :</label>
                    <div class="form-label-group">
                        <textarea name="content" class="form-control" rows="3" ><?php echo $content?></textarea>
                    </div>
                </div>
                <?php
                if($type == "New" OR $type == "Answer"){
                ?>
                <input type="submit" class="btn btn-primary btn-block" value="Confirm"/>
                    <?php
                }
                ?>
                <?php
                    if($type == "Details"){
                ?>
                        <a class="btn btn-primary btn-block" href="validate-delete-message.php?id=<?php echo $id ?>">Delete</a>
                        <a class="btn btn-primary btn-block" href="read-write-message.php?type=Answer&id=<?php echo $id ?>">Answer</a>
                <?php
                    }
                ?>
                <a class="btn btn-primary btn-block" href="view.php">Cancel</a>
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