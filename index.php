<?php

use App\Exceptions\SqlException;
use App\Exceptions\DbConnectEx;

require __DIR__ . '/autoload.php';

/*
 * Point of enter in application 
 * Front controller
 * */
try {
    $ctrl = isset($_GET['ctrl']) ? ucfirst($_GET['ctrl']) : 'Index';
    $class = '\App\Controllers\\' . $ctrl;
    $ctrl = new $class;
    $ctrl();
} catch (SqlException $ex) {
    $ctrl = new \App\Controllers\SqlError($ex);
    $ctrl();
} catch (DbConnectEx $ex) {
    $ctrl = new \App\Controllers\DbError($ex);
    $ctrl();
} catch (\Exception $ex) {
    echo 'Неизвестная ошибка!!!' . $ex->getMessage();
}


