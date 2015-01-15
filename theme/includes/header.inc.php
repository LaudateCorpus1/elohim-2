<!doctype html>
<html ng-app="mandala">
<head>
    <title>{{mandalaController.title}}</title>
    <script src="../../lib/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="../../lib/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../../lib/angular.min.js" type="text/javascript"></script>
    <script src="//code.angularjs.org/1.2.28/angular-route.min.js"></script>
    <script src="../../app/mandala.js"></script>
    <script src="../../app/scripts/user.js"></script>
</head>
<body>
<div>
    <ng-view></ng-view>

</div>