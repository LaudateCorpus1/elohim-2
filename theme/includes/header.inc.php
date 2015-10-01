<!doctype html>
<html>
<head>
    <title>## Mandala Dev<?php isset($_title)?" :: ".$_title:''; ?></title>
    <script src="/lib/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="/lib/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/lib/jquery.validate.min.js" type="text/javascript"></script>
    <?php include SCRIPTS_PATH.'scripts.inc.php'; ?>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= STYLES_PATH ?>mandala.css" />
</head>
<body class="<?= $user->userIsLoggedIn()?"userLoggedIn":"userLoggedOut" ?>">

<div id="header">
    <div class="wrapper">
        <h1>Title</h1>
        <?php $modules->import('userLogin'); ?>
    </div>
</div>

<?php
include THEME_INCLUDES_PATH."menu.inc.php";
?>