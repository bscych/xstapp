/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$().ready(function () {
    $(".tb2").hide();
    $("#frequence").on("change", function () {
        var frequence = $("#frequence").val();
        if (frequence === "1") {
            $(".tb2").hide();
        } else {
            $(".tb2").show();
        }
    });
    $("#duration").on("change", function () {
        calculateTotal();
    });
    $("#unit_price").on("change", function () {
        calculateTotal();
    });
    $("#courseCategory_id").on("change", function () {
        var category = $("#courseCategory_id").val();
        if (category === "16" || category === "17") {
            $(".tg").hide();
            $(".tb2").hide();
        } else {
            $(".tg").show();
            $(".tb2").hide();
        }

    });
});
function calculateTotal() {
    var duration = parseFloat($("#duration").val());
    var unit_price = parseInt($("#unit_price").val());
    var total = duration * unit_price;
    $("#total_price").text(total);
}


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function submit(schedule_id, field, component_id, url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: {schedule_student_id: schedule_id, field: field, value: $('#'+field+component_id).prop('checked')}
    });
}

function updateCourse(course_id, url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: {in_count: $('#'+course_id).prop('checked'),course_id:course_id}
    });
}
