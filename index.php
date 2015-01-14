<?php


include 'init.inc.php';
?>

<html ng-app="mandala">
<head>
    <script src="//code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
    <script src="app/mandala.js"></script>
    <script src="app/scripts/user.js"></script>
</head>
<body>
<div ng-controller="UserController as user">
    <div ng-repeat="userDetails in user.users">
        <h1>{{userDetails.name}}</h1>
    </div>
</div>
</body>
</html>
