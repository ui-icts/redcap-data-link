<?php
/** @var \UIOWA\DataLink\DataLink $module */

require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';

?>
<script>
    let UIOWA_DataLink = <?= $module->get_javascript_object(true) ?>;
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>

<script src="<?= $module->getUrl("dataLink.js") ?>"></script>
<link href="<?= $module->getUrl("styles.css") ?>" rel="stylesheet" type="text/css"/>

<template id="project-fields">
    <div>
        <div
                v-for="(form_fields, form_name) in forms"
                class="card"
                :data-rc-form="form_name"
        >
            <div
                    class="card-header"
                    :id="'header_' + pid + '_' + form_name" data-toggle="collapse"
                    :data-target="'#projectFields_' + pid + '_' + form_name"
                    aria-expanded="true"
                    :aria-controls="'header_' + pid + '_' + form_name"
                    style="cursor: pointer;"
            >
                <h5 class="mb-0">
                    {{ form_name }}
                </h5>
            </div>
            <div
                    :id="'projectFields_' + pid + '_' + form_name"
                    :aria-labelledby="'header_' + pid + '_' + form_name"
                    :data-parent="'#header_' + pid + '_' + form_name"
                    class="project-fields collapse show"
                    :data-rc-pid="pid"
            >
                <div
                        v-for="(field_meta, field_index) in form_fields"
                        class="list-group-item"
                        :class="{
                                    tinted: UIOWA_DataLink.primaryPid !== parseInt(pid),
                                    filtered: UIOWA_DataLink.primaryPid === parseInt(pid)
                                }"
                        :style="linkedFieldColor ? 'background-color: ' + linkedFieldColor : ''"
                        :data-rc-index="field_index"
                        :data-rc-source-pid="pid"
                        :data-rc-current-pid="pid"
                        :data-rc-form="field_meta.form_name"
                        :data-rc-field="field_meta.field_name"
                        style="cursor: pointer;"
                >
                    {{ field_meta.field_name }}
                </div>
            </div>
        </div>
    </div>
</template>

<template id="project-fields">
</template>

<html>
    <body>
        <div id="app" class="container">
            <div v-for="(forms, index) in projectsMeta" :value="index" style="float: left">
                <project-fields
                        :pid="getPidForMeta(index)"
                        :forms="projectsMeta[index]"
                        :linked-field-color="linkedFieldColors[index - 1]"
                ></project-fields>
            </div>
        </div>
    </body>
</html>

<?php

require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';