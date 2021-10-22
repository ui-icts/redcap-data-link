$(document).ready(function() {
    let projectIndex = 0;

    $.each(UIOWA_DataLink.fieldConfig, function(sourcePid, forms) {
        $.each(forms, function(formName, fields) {
            const dataEntryUrl = "?pid=" + sourcePid + "&id=" + UIOWA_DataLink.recordId + "&page=" + formName;

            $.ajax(dataEntryUrl)
                .then(function(result) {
                    let $dataEntryForm = $(result);

                    $.each(fields, function(index, fieldInfo) {
                        let $injectField = $dataEntryForm.find("tr[sq_id='" + fieldInfo.fieldName + "']");

                        $injectField.find(".rc-field-icons").empty().append(
                            "<div>" +
                                "<a href='#' class='btn-xs btn-info goto-linked-project'>" +
                                    "<i class='fas fa-link'></i>" +
                                "</a>" +
                            "</div>");
                        $injectField.find(".resetLinkParent").empty();

                        $injectField.find("td").css("background-color", UIOWA_DataLink.linkedFieldColors[projectIndex]);
                        $injectField.find("input").attr("disabled", true);

                        $("tr[sq_id='" + fieldInfo.prevField + "']").after($injectField);

                        $injectField.find('.goto-linked-project').click(function() {
                            window.open(dataEntryUrl, "_blank");
                        })
                    })

                    projectIndex++;
                })
        })
    })
})