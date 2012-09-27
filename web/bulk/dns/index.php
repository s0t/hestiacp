<?php
// Init
error_reporting(NULL);
ob_start();
session_start();

include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

$domain = $_POST['domain'];
$record = $_POST['record'];
$action = $_POST['action'];

if ($_SESSION['user'] == 'admin') {
    if (empty($record)) {
        switch ($action) {
            case 'delete': $cmd='v_delete_dns_domain';
                break;
            case 'suspend': $cmd='v_suspend_dns_domain';
                break;
            case 'unsuspend': $cmd='v_unsuspend_dns_domain';
                break;
            default: header("Location: /list/dns/"); exit;
        }
    } else {
        switch ($action) {
            case 'delete': $cmd='v_delete_dns_domain_record';
                break;
            case 'suspend': $cmd='v_suspend_dns_domain_record';
                break;
            case 'unsuspend': $cmd='v_unsuspend_dns_domain_record';
                break;
            default: header("Location: /list/dns/?domain=".$domain); exit;
        }
    }
} else {
    if (empty($record)) {
        switch ($action) {
            case 'delete': $cmd='v_delete_dns_domain';
                break;
            default: header("Location: /list/dns/"); exit;
        }
    } else {
        switch ($action) {
            case 'delete': $cmd='v_delete_dns_domain_record';
                break;
            default: header("Location: /list/dns/?domain=".$domain); exit;
        }
    }
}


if (empty($record)) {
    foreach ($domain as $value) {
        // DNS
        $value = escapeshellarg($value);
        exec (VESTA_CMD.$cmd." ".$user." ".$value." no", $output, $return_var);
        $restart = 'yes';
    }
} else {
    foreach ($record as $value) {
        // DNS Record
        $value = escapeshellarg($value);
        $dom = escapeshellarg($domain);
        exec (VESTA_CMD.$cmd." ".$user." ".$dom." ".$value." no", $output, $return_var);
        $restart = 'yes';
    }
}

if (!empty($restart)) {
    exec (VESTA_CMD."v_restart_dns", $output, $return_var);
}

if (empty($record)) { 
    header("Location: /list/dns/");
    exit;
} else {
    header("Location: /list/dns/?domain=".$domain);
    exit;
}
