let categoryTable;
let currentFilterStatus = '';

document.addEventListener('DOMContentLoaded', function () {
    categoryTable = initGlobalDatatable('#table_category', function () {
        return {
            filter_status: currentFilterStatus,
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (categoryTable) categoryTable.ajax.reload();
        });
    });
});



function filter_apply(){
    currentFilterStatus = $('#filter_status').val();
    if (categoryTable) {
        categoryTable.ajax.reload();
    }
}



var image = document.getElementById('display_image');
var title = $('#title_modal').data('title').split('|');
$(function () {

    $('.hps_image').on('click', function () {
        // console.log('hapus');
        $('input[name=name_image]').val("");
    });

});

function ubah_data(element, id) {
    var form = document.getElementById('form_category');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/update_category');
    $.ajax({
        url: BASE_URL + '/setting/get_single/category',
        method: form.method,
        data: { 
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            $('input[name="id_category"]').val(data.id_category);
            $('input[name="name"]').val(data.name);
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_category');
    form.setAttribute('action', BASE_URL + '/master/insert_category');
    $('#title_modal').text(title[1]);
    $('#form_category input[type="text"]').val('');
    $('#form_category input[type="email"]').val('');
}


