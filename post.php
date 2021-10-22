<?php
/** @var \UIOWA\DataLink\DataLink $module */

//call_user_func(array($module, $_POST['method']), $_POST['params']);

if ($_POST['method'] === 'save') {
    $module->setProjectSetting('field-config', $_POST['fieldConfig']);
}
//elseif ($_POST['method'] === 'load') {
//    $savedConfig = $module->getProjectSetting('field-config');
//    $projectsMeta = array();
//
//    foreach ($_POST['pids'] as $pid) {
//        $fields = \REDCap::getDataDictionary($pid, 'array');
//        $projectsMeta[$pid] = array();
//
//        foreach ($fields as $field) {
//            $formName = $field['form_name'];
//
//            if (!isset($projectsMeta[$pid][$formName])) {
//                $projectsMeta[$pid][$formName] = array();
//            }
//
//            array_push($projectsMeta[$pid][$formName], $field);
//        }
//    }
//
//    echo json_encode(
//        array(
//            'projectsMeta' => $projectsMeta,
//            'fieldConfig' => $savedConfig
//        ));
//}
