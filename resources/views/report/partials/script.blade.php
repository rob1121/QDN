
<script src="/vendor/js/bootstrap-datepicker.js"></script>
<script src="/vendor/js/select2.min.js"></script>
<script src="/js/reportCompletion.js"></script>
<script src="/js/reportForm.js"></script>
<script type="text/javascript">
    $(function() {

    $('#draft-button').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to save as draft only?')) {
            $.ajax({
                url: '/report/' + qdn.slug + '/ajax',
                type: 'get',
                data: $('#qdn-form').serializeArray(),
                success: function(qdn) {
                    //names of receiver
                    var department = $.unique(qdn.department),
                        names = $.map(qdn.receiver_name, function(n) {
                            return n;
                        });

                    //updating section one text fields
                    $('.customer').text($('#customer').val().toUpperCase());
                    $('.package_type').text($('#package_type').val().toUpperCase());
                    $('.device_name').text($('#device_name').val().toUpperCase());
                    $('.lot_id_number').text($('#lot_id_number').val().toUpperCase());
                    $('.lot_quantity').text($('#lot_quantity').val().toUpperCase());
                    $('.job_order_number').text($('#job_order_number').val().toUpperCase());
                    $('.machine').text($('#machine').val().toUpperCase());
                    $('.station').text($('#station').val().toUpperCase());
                    $('.text-major').html($('#major:checked').val() == 'major' ? '[x]' : '[&nbsp;&nbsp;]');
                    $('.text-minor').html($('#major:checked').val() == 'minor' ? '[x]' : '[&nbsp;&nbsp;]');
                    $('.control_id').text($('#control_id').val());
                    $('input.disposition[value="' + $('#dispositions input:checked').val() + '"]').prop('checked', true);
                    // team res
                    $('.team_responsible').html(department.join("<br>").toUpperCase());

                    $('.receiver_name').html(names.join("<br>"));
                    $('.problem_description').text($('#problem_description').val());

                    //display alert
                    $.amaran({
                        'theme': 'awesome ok',
                        'content': {
                            title: 'Draft Saved!',
                            message: '',
                            info: 'Come back soon to verify the issue!',
                            icon: 'fa fa-save'
                        },
                        'position': 'bottom right',
                        'outEffect': 'fadeOut'
                    });


                }

            });
            $('#edit').modal('hide');
        }

    });

    $('#validation-modal').on('show.bs.modal', function () {
        $('#edit').modal('hide');
    });
       $('#validation-modal').on('hidden.bs.modal', function () {
            if ($('#validation-modal h4#validation-msg').text() == "Write Validation Output:"){
                $('#validation-modal h4#validation-msg').text('Add Comment (optional):');
                $('#edit').modal('show');
            }
       });
       $('#edit').on('show.bs.modal', function () {
 $('#validation-modal h4#validation-msg').text('Write Validation Output:');
       });
    });
</script>
