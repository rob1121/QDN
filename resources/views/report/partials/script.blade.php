
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

$('#validation-modal').on('show.bs.modal', function() {
    $('#edit').modal('hide');
});
$('#validation-modal').on('hidden.bs.modal', function() {
    $('#edit').modal('show');
});

    // ======================= AJAX PLACED INSIDE VARIABLE ========================
    var expireCache = function(href='{{ route('home') }}') {
        $.ajax({
                url: '{{ route('forget',['slug'=>$qdn->slug]) }}',
                type: 'get',
                success: function () {
                    location.href = href;
                }
            });
    };
//========================= REFRESH CACHE =====================================
var refresher = function(){
    $.ajax({
            url: '{{ route("refresher",["slug" => $qdn->slug] )}}',
            type: 'get',
            success: function () {
                setTimeout(refresher, 60000);
            }
        });
};
    
setTimeout(refresher, 60000);

$('nav').find('a').on('click', function (e) {
    var self = $(this);
    e.preventDefault();
    expireCache(self.attr('href'));
});
//============================== TRACK IDLE MOMENT ==============================
var IDLE_TIMEOUT = 3*60; //seconds
var _idleSecondsCounter = 0;
document.onclick = function() {
    _idleSecondsCounter = 0;
};
document.onmousemove = function() {
    _idleSecondsCounter = 0;
};
document.onkeypress = function() {
    _idleSecondsCounter = 0;
};
setInterval(CheckIdleTime, 1000);
function CheckIdleTime() {
    
    _idleSecondsCounter++;
    var oPanel = document.getElementById("SecondsUntilExpire");
    if (oPanel)
        oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
        expireCache();
    }
}
});
</script>
