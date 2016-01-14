$(function() {
$('#login-form').validate({
    rules: {
        employee_id: {
            required: true
        },
        password: {
            required: true
        }
    },
    errorClass: "error",
    errorElement: "span"
});
})