
$(function() {

function selectedDiscrepancyCategory(radio, select_discrepancy_minor, select_discrepancy_major) {

    //remove previous content and append with new
    $('#discrepancy_category').empty();
    $('<option>', {
        value: '',
        text: '',
    }).appendTo('#discrepancy_category');
    //minor options is trigger when minor radio is clicked---------------------
    if (radio == "minor") {
        $.each(select_discrepancy_minor, function(index, value) {
            $('<option>', {
                value: value,
                text: value
            }).appendTo('#discrepancy_category');
        });
    } else {
        //major----------------------------------------------------------------
        $.each(select_discrepancy_major, function(index, value) {
            if (value.length > 1) {
                $('<optgroup>', {
                    label: index
                }).appendTo('#discrepancy_category');
                $.each(value, function(index, value) {
                    $('<option>', {
                        value: value,
                        text: value
                    }).appendTo('#discrepancy_category optgroup:last');
                });
            } else {
                $('<option>', {
                    value: value,
                    text: value
                }).appendTo('#discrepancy_category');
            }
        });
    }
    $("#discrepancy_category").select2("val", discrepancy_category.length ? discrepancy_category : '');
}
//form validations---------------------------------------------------------
$('#qdn-form').validate({
    ignore: '',
    rules: {
        customer: {
            required: true
        },
        package_type: {
            required: true
        },
        device_name: {
            required: true
        },
        lot_id_number: {
            required: true
        },
        lot_quantity: {
            required: true,
            digits: true
        },
        quantity: {
            required: true,
            digits: true
        },
        job_order_number: {
            required: true
        },
        machine: {
            required: true
        },
        station: {
            required: true
        },
        receiver_name: {
            required: true
        },
        failure_mode: {
            required: true
        },
        discrepancy_category: {
            required: true
        },
        problem_description: {
            required: true,
            minlength: 10,
            maxlength: 250
        },
        quantity: {
            required: true,
            digits: true
        }
    },
    messages: {
        job_order_number: {
            required: "type 'N/A' if this field is not applicable"
        }
    },
    errorClass: "error",
    errorElement: "span"
});

$('select').select2().change(function() {
    $(this).valid();
});

//---------------------------------------------var
var select_discrepancy_major = {
        'MISSING UNIT(S)': ['MISSING UNIT(S)'],
        'LOW YIELD': ['LOW YIELD'],
        'WRONG TRANSACTION': ['WRONG TRANSACTION'],
        'CANT CREATE': ['CANT CREATE'],
        'FOREIGN MATERIAL': ['FOREIGN MATERIAL'],
        'WRONG MERGING': ['WRONG MERGING'],
        'DATECODE DISCREPANCY': ['DATECODE DISCREPANCY'],
        'MARKING PROBLEM': ['MARKING PROBLEM'],
        'MIXED DEVICE': ['MIXED DEVICE'],
        'LEAD ISSUE': [
            'BENT LEAD',
            'LEAD CONTAMINATION',
            'LEAD DISCOLORATION',
            'LEAD COPLANARITY',
        ],
        'LABEL ISSUE': [
            'LABEL SWAPPING',
            'WRONG LABEL',
            'OTHER LABEL RELATED ISSUE',
        ],
        'QUANTITY DISCREPANCY': [
            'EXCESS',
            'LACKING',
        ],
        'PACKAGE DEFECTS': [
            'PACKAGE CHIP-OUT',
            'PACKAGE SCRATCH',
            'PACKAGE VOID',
            'OTHER PACKAGE RELATED DEFECT',
        ],
        'TAPE AND REEL SEALING PROBLEM': [
            'POOR SEALING',
            'UNSEALED COVER TAPE',
            'OTHER TAPE AND REEL SEALING PROBLEM',
        ],
        'FINAL PACKING PROBLEM': [
            'EXPOSED LOT',
            'OTHER FINAL PACKING PROBLEM',
        ],
        'OTHERS': ['OTHERS'],
    },
    select_discrepancy_minor = [
        'SOP Violation',
        'KDTM Violation',
        'OTHERS',
    ];

//show new input field when select option are not yet specified
$('#customer').on('change', function() {
    var $this = $(this),
        selected = $this.find('option:selected').val();
    if (selected == 'not yet specified') {
        $("#not-yet-specified").fadeIn(300);
    } else {
        $("#not-yet-specified").fadeOut(300);
    }
});
//major and minor discrepancy category--------------------------------

if (typeof category !== 'undefined') {
    selectedDiscrepancyCategory(category, select_discrepancy_minor, select_discrepancy_major);
    $("#discrepancy_category").select2("val", discrepancy_category);

} else {
    selectedDiscrepancyCategory('minor', select_discrepancy_minor, select_discrepancy_major);
}

$('#btn-major').find('input:radio').on('change', function() {
    selectedDiscrepancyCategory($(this).val(), select_discrepancy_minor, select_discrepancy_major);
});
// ------------------------------------------------------------------
//disable lot description if input radio is equal to no

$('#sort').click(function() {
    if ($(this).prop("checked") !== true) {
        $('#lot-description').fadeOut(300, function() {
            $(this).find('input')
                .val('N/A');
            $('#lot_quantity').val(0);

        });

    } else {
        $('#lot-description').fadeIn(300)
            .find('input')
            .val('');
    }

});

//select2 widget--------------------------------------------------------------
$("#discrepancy_category").select2({
    placeholder: "Discrepancy Category"
});
$("#failure_mode").select2({
    placeholder: "Failure Mode"
});
$("#customer").select2({
    placeholder: "Customer"
});
$("#station").select2({
    placeholder: "Station"
});
$("#machine").select2({
    placeholder: "Machine"
});
$("#receiver_name").select2({
    placeholder: "Receiver Name"
});

//append new quantity textfield
$('#discrepancy_category').on('change', function() {
    var $this = $(this),
        selected = $this.find('option:selected').val();
    if (selected == 'MISSING UNIT(S)' || selected == 'EXCESS' || selected == 'LACKING') {
        $("#quantity-field").fadeIn(300);
    } else {
        $("#quantity-field").fadeOut(300);
        $("#quantity").val(0);
    }
});
});