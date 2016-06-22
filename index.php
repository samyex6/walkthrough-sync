<?php
if(!empty($_GET['sync'])) {

    $filename = 'progress';
    $initial  = FALSE;
    $old_path = getcwd();

    chdir(__DIR__);
    set_time_limit(0);

    while(true) {

        sleep(1);
        clearstatcache();

        $progress = file_get_contents($filename);

        if(!$initial && !$progress) {
            $initial = TRUE;
            shell_exec('./sync.bash');
        } elseif(!$progress) {
            continue;
        } elseif(!($filetime = filemtime($filename)) || $filetime > $_GET['timestamp']) {
            echo json_encode($progress);
            exit;
        }

    }

    chdir($old_path);

}
?>

<!DOCTYPE html>
<html ng-app="sync">
<head>
    <style>
        * { font-size: 12px; }
        #panel { overflow-y: scroll; width: 500px; height: 200px; border: 1px solid #000; border-radius: 10px; padding: 10px; margin-bottom: 10px; }
    </style>
<head>
<body ng-controller="MainController">

<div id="panel"></div>
<button ng-click="enabled = true; sync();">Start</button>
<button ng-click="enabled = false;">Stop</button>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
<script>
var app = angular.module('sync', []);
app.controller('MainController', ['$scope', '$http', function($scope, $http) {
    $scope.enabled = false;
    $scope.panelElement = angular.element(document.getElementById('panel'));
    $scope.sync  = function() {
        if(!$scope.enabled) return;
        $http.get('index.php?sync=1&timestamp=' + ((new Date).getTime() / 1000)).then(function(response) {
            response = JSON.parse(response.data);
            $scope.panelElement.prepend(response ? 'Processing ' + response + '<br>' : 'Process complete.<br>');
            $scope.sync();
        }, function() {
            $scope.sync();
        });
    };
}]);
</script>
</body>
</html>
