<?php
header('Content-Type: application/json');

require_once('.secret/mysqli.php');
require_once('.secret/mqtt.php');
require_once('lib/mqtt.php');
require_once('class/class_asset.php');
require_once('class/class_assetdescriptor.php');
require_once('lib/functions.php');
require_once('lib/actions.php');

$json_ob = json_decode($_REQUEST['json']);

$assets = array();

if(is_array($json_ob->ids)) {
    if(!$json_ob->action) {

    } else {
        foreach($json_ob->ids as $serial) {
            if($asset = find_or_create($serial)) {
                $assets[] = $asset;
            }
        }
        $action = strtolower(str_replace('.','_',$json_ob->action));
        if(preg_match('/^process_(\w+)$/', $action, $matches) ) {

        } else if (file_exists(__DIR__ . '/actions/' . $action . '.php')) {
           $action($assets);
        }
    }
} else {
}
