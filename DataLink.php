<?php
namespace UIOWA\DataLink;

use ExternalModules\AbstractExternalModule;

class DataLink extends AbstractExternalModule
{
    public function __construct()
    {
        parent::__construct();
        define("MODULE_DOCROOT", $this->getModulePath());
    }

    function redcap_data_entry_form($project_id, $record, $instrument, $event_id, $group_id, $repeat_instance) {
        ?>
            <script>
                let UIOWA_DataLink = <?= $this->get_javascript_object() ?>;
            </script>

            <script src="<?= $this->getUrl("redcapDataEntryForm.js") ?>" type="text/javascript" charset="utf-8"></script>
            <link href="<?= $this->getUrl("styles.css") ?>" rel="stylesheet" type="text/css"/>
        <?php
    }

    function get_javascript_object($includeProjectsMeta = false) {
        $jsObject = array(
            "dataEntryUrl" => SERVER_NAME . APP_PATH_WEBROOT . "/DataEntry/index.php",
            "postUrl" => $this->getUrl("post.php"),
            "primaryPid" => intval($this->getProjectId()),
            "linkedPids" => $this->getProjectSetting("linked-pid"),
            "recordId" => $this->getRecordId(),
            "fieldConfig" => $this->getProjectSetting("field-config"),
            "linkedFieldColors" => $this->getProjectSetting("linked-field-color"),
            "selectedProjectIndex" => 1
        );

        if ($includeProjectsMeta) {
            $jsObject["projectsMeta"] = $this->get_fields(array_merge(array($this->getProjectId()), $jsObject['linkedPids']));
        }

        return json_encode($jsObject);
    }

    function get_fields($linkedPids) {
        $projectsMeta = [];

        foreach ($linkedPids as $pid) {
            $fields = \REDCap::getDataDictionary($pid, 'array');
            $projectsMetaTemp = array();

            foreach ($fields as $field) {
                $formName = $field['form_name'];

                if (!isset($projectsMetaTemp[$formName])) {
                    $projectsMetaTemp[$formName] = array();
                }

                array_push($projectsMetaTemp[$formName], $field);
            }

            array_push($projectsMeta, $projectsMetaTemp);
        }

        return $projectsMeta;
    }
}
?>