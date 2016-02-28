$(function() {
var count = 250,
    textCount;
$('textarea').each(function() {
    var $this = $(this);
    textCount = 250 - $this.val().length;

    $this.siblings('#count').text('Characters left : ' + textCount);

});
$('textarea').on('keyup', function() {
    var $this = $(this),
        left;
    textCount = $this.val().length;
    left = count - textCount;

    text = $this.val().substring(0, 250);

    $this.siblings('#count').text('Characters left : ' + left);
    if (textCount >= 250) {
        $this.val(text);
    }
    ;
});
//select2 widget--------------------------------------------------------------
$("#containment_action_who").select2({
    placeholder: "Input Name"
});
$("#corrective_action_who").select2({
    placeholder: "Input Name"
});
$("#preventive_action_who").select2({
    placeholder: "Input Name"
});
//datepicker--------------------------------------------------------------------
$('#containment-action-taken').datepicker()
    .on('change', function() {
        $('#containment-action-taken').datepicker('hide');
    });
$('#corrective-action-taken').datepicker()
    .on('change', function() {
        $('#corrrective-action-taken').datepicker('hide');
    });
$('#preventive-action-taken').datepicker()
    .on('change', function() {
        $('#preventive-action-taken').datepicker('hide');
    });

$('span#upload-btn').on('click', function() {
    $(this).siblings('.upload-file-container').children('input[type="file"]').click();
});

$('input[type="file"]').on('change', function() {
    $(this).valid();
    var $this = $(this),
        filename = $this.val().replace(/C:\\fakepath\\/i, '');
    $this.parent().siblings('span#upload-btn').text(filename)
        .append(" <i class='fa fa-pencil'></i>");
    if ($this.val() == '') {
        $this.parent()
            .siblings('span#upload-btn')
            .children()
            .remove();

        $(this).parent()
            .siblings('span#upload-btn')
            .text('Select File..')
            .prepend("<i class='fa fa-plus'></i> ");

    }
});
$('#completion').validate({
    ignore: '',
    rules: {
        disposition: {
            required: true
        },
        cause_of_defect: {
            required: true
        },
        upload_cod: {
            extension: "xls|csv|jpeg|png|pdf|doc|docx|jpg"
        },
        cause_of_defect_description: {
            required: true,
            minlength: 10,
            maxlength: 250
        },
        containment_action_textarea: {
            required: true,
            minlength: 10,
            maxlength: 250
        },
        containment_action_who: {
            required: true
        },
        containment_action_taken: {
            required: true
        },
        upload_containment_action: {
            extension: "xls|csv|jpeg|png|pdf|doc|docx|jpg"
        },
        corrective_action_textarea: {
            required: true,
            minlength: 10,
            maxlength: 250
        },
        corrective_action_who: {
            required: true
        },
        corrective_action_taken: {
            required: true
        },
        upload_corrective_action: {
            extension: "xls|csv|jpeg|png|pdf|doc|docx|jpg"
        },
        preventive_action_textarea: {
            required: true,
            minlength: 10,
            maxlength: 250
        },
        preventive_action_who: {
            required: true
        },
        preventive_action_taken: {
            required: true
        },
        upload_preventive_action: {
            extension: "xls|csv|jpeg|png|pdf|doc|docx|jpg"
        }
    },
    messages: {
        disposition: {
            required: 'PE personnel shall check one from the category'
        },
        cause_of_defect: {
            required: 'Check one from the category'
        },
        upload_cod: {
            extension: "Invalid file extention, system only accept file with xls, csv, jpeg, png, pdf, doc, docx extention"
        },
        cause_of_defect_description: {
            required: 'Input detailed cause of defect'
        },
        containment_action_textarea: {
            required: 'Input action taken'
        },
        containment_action_who: {
            required: 'Select name of the respondent'
        },
        containment_action_taken: {
            required: 'Pick date of when action is taken'
        },
        upload_containment_action: {
            extension: "Invalid file extention, system only accept file with xls, csv, jpeg, png, pdf, doc, docx extention"
        },
        corrective_action_textarea: {
            required: 'Input action taken'
        },
        corrective_action_who: {
            required: 'Select name of the respondent'
        },
        corrective_action_taken: {
            required: 'Pick date of when action is taken'
        },
        upload_corrective_action: {
            extension: "Invalid file extention, system only accept file with xls, csv, jpeg, png, pdf, doc, docx extention"
        },
        preventive_action_textarea: {
            required: 'Input action taken'
        },
        preventive_action_who: {
            required: 'Select name of the respondent'
        },
        preventive_action_taken: {
            required: 'Pick date of when action is taken'
        },
        upload_preventive_action: {
            extension: "Invalid file extention, system only accept file with xls, csv, jpeg, png, pdf, doc, docx extention"
        }

    },
    errorClass: "error",
    errorElement: "span",
    errorPlacement: function(error, element) {
        if (element.is("input:radio")) {
            error.insertAfter(element.parents('#cause-of-defect-section'));
        } else {
            error.insertAfter(element);
        }
    }
});

$('#btn-group button').on('click', function(e) {
    e.preventDefault();
    var self = $(this),
        form = $('form#completion'),
        action = "save as draft";

    form.attr('action', link.linkDraft);

    if (self.attr('id') == "aprroval_button") {
        action = "submit for approval";
        form.attr('action', link.linkApproval);
    }

    if (confirm('Are you sure you want to ' + action + '?')) {
        form.submit();
    }


});

/**
 * function to use for modal submit button
 */
$('#submit').on('click', function(e) {
    e.preventDefault();
    if ($('#qdn-form').valid()) {
        $.ajax({
            url: window.location.href + '/store',
            type: 'get',
            data: $('#qdn-form').serializeArray(),
            success: function(data) {
                alert('success')
            }
        });
    }
});
});

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
    }
});
