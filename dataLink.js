$(document).ready(function() {
    Vue.component('project-fields', {
        template: $("#project-fields")[0],
        props: ['pid', 'forms', 'linkedFieldColor']
    });

    new Vue({
        el: '#app',
        data: UIOWA_DataLink,
        mounted: function () {
            $('.project-fields').each(function(index, el) {
                new Sortable(el, {
                    group: {
                        name: function() {
                            if ($(el).data('rc-pid') === pid) {
                                return "this_project"
                            }
                            else {
                                return "other_project"
                            }
                        },
                        put: true
                    },
                    animation: 150,
                    sort: false,
                    filter: '.filtered',
                    onAdd: function (evt) {
                        // let sourcePid = $(evt.item).data('rc-source-pid');
                        // let destinationPid = $(evt.to).data('rc-source-pid');
                        // let sourceIndex = $(evt.item).data('rc-index');
                        //
                        // if (sourcePid === destinationPid) {
                        //     evt.newDraggableIndex = sourceIndex;
                        // }


                        var $thisProjectFields = $('.project-fields[data-rc-pid=' + pid + '] > div')
                        var prevField;

                        UIOWA_DataLink.fieldConfig = {};

                        $thisProjectFields.each(function(i,elm) {
                            var fieldData = $(elm).data();

                            if (fieldData.rcCurrentPid === pid) {
                                prevField = fieldData.rcField
                            }
                            else {
                                if (!(fieldData.rcCurrentPid in UIOWA_DataLink.fieldConfig)) {
                                    UIOWA_DataLink.fieldConfig[fieldData.rcCurrentPid] = {};
                                }

                                if (!(fieldData.rcForm in UIOWA_DataLink.fieldConfig[fieldData.rcCurrentPid])) {
                                    UIOWA_DataLink.fieldConfig[fieldData.rcCurrentPid][fieldData.rcForm] = [];
                                }

                                UIOWA_DataLink.fieldConfig[fieldData.rcCurrentPid][fieldData.rcForm].push(
                                    {
                                        fieldName: fieldData.rcField,
                                        prevField: prevField
                                    }
                                )
                            }
                        });

                        $.ajax({
                            url: UIOWA_DataLink.postUrl,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                method: 'save',
                                fieldConfig: UIOWA_DataLink.fieldConfig
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        })
                    },
                    // onAdd: function (evt, originalEvent) {
                    //     console.log(evt)
                    //     // let thisPid = $(el).data('rc-pid')
                    //     let destinationPid = $(evt.to).data('rc-pid');
                    //
                    //     if (destinationPid !== pid) {
                    //         return false;
                    //     }
                    // }
                });
            })

            // load existing config
            if (UIOWA_DataLink.fieldConfig) {
                let sourcePID = pid;
                let projects = UIOWA_DataLink.fieldConfig;

                $.each(projects, function(pid, project) {
                    $.each(project, function(form_name, form) {
                        $.each(form, function(index, field) {
                            let $dragElm = $('[data-rc-source-pid="' + pid + '"][data-rc-form="' + form_name + '"][data-rc-field="' + field.fieldName + '"]');
                            let $newNeighborElm = $('[data-rc-source-pid="' + sourcePID + '"][data-rc-field="' + field.prevField + '"]');

                            $dragElm.insertAfter($newNeighborElm);
                        })
                    })
                })
            }

            // set position of @LINKED fields
            $.each(UIOWA_DataLink.projectsMeta[0], function(form_name, form) {
                $.each(form, function(index, field) {
                    let fieldName = field.field_name;
                    let actionTags = field.field_annotation;
                    let linkedPID = actionTags.slice(actionTags.indexOf("@LINKED=") + 9);
                    linkedPID = linkedPID.substring(0, linkedPID.indexOf("'"));

                    if (linkedPID) {
                        let $dragElm = $('[data-rc-source-pid="' + linkedPID + '"][data-rc-field="' + fieldName + '"]');
                        let $newNeighborElm = $('[data-rc-source-pid="' + pid + '"][data-rc-field="' + fieldName + '"]').hide();

                        $dragElm.insertAfter($newNeighborElm);
                    }
                })
            })
        },
        methods: {
            getPidForMeta: function(index) {
                if (index === 0) {
                    return this.primaryPid;
                }
                else {
                    return this.linkedPids[index - 1];
                }
            }
        }
    })
})