<?php
session_start();

function getActionByName($name)
{
    $name .= 'Action';
    require("actions/$name.inc.php");

    return new $name();
}

function getViewByName($name)
{
    $name .= 'View';
    require("views/$name.inc.php");

    return new $name();
}

function getAction()
{
    if (!isset($_REQUEST['action'])) {
        $action = 'Home';
    } else {
        $action = $_REQUEST['action'];
    }

    $actions = [
        'Default',
        'SignUpForm',
        'SignUp',
        'Logout',
        'Login',
        'UpdateUserForm',
        'UpdateUser',
        'AddSurveyForm',
        'AddSurvey',
        'GetMySurveys',
        'Search',
        'Vote',
        'Home',
        'EditSurvey',
        'Delete',
        'Comment'
    ];

    if (!in_array($action, $actions)) {
        $action = 'Default';
    }

    return getActionByName($action);
}

$action = getAction();
$action->run();
$view = $action->getView();
$action->getView()->setLogin($action->getSessionLogin());
$view->run();
?>

