let memberTable;
let currentFilterStatus = '';

document.addEventListener('DOMContentLoaded', function () {
    memberTable = initGlobalDatatable('#table_member', function () {
        return {
            filter_status: currentFilterStatus,
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (memberTable) memberTable.ajax.reload();
        });
    });
});



function filter_apply(){
    currentFilterStatus = $('#filter_status').val();
    if (memberTable) {
        memberTable.ajax.reload();
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
    var foto = $(element).data('image');
    var form = document.getElementById('form_member');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/update/member');
    $.ajax({
        url: BASE_URL + '/setting/get_single/user',
        method: form.method,
        data: { 
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            image.style.backgroundImage = "url('" + foto + "')";
            document.getElementById("member_file").value = "";
            $('input[name="id_user"]').val(data.id_user);
            $('input[name="name"]').val(data.name);
            $('input[name="email"]').val(data.email);
            $('input[name="phone"]').val(data.phone);
            $('input[name="name_image"]').val(data.image);
            $('#form_member label.password').removeClass('required');
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_member');
    form.setAttribute('action', BASE_URL + '/master/tambah/member');
    $('#title_modal').text(title[1]);
    image.style.backgroundImage = "url('" + user_base_foto + "')";
    document.getElementById("member_file").value = "";
    $('#form_member input[type="text"]').val('');
    $('#form_member input[type="email"]').val('');
    $('#form_member label.password').addClass('required');
    $('#form_member textarea').val('');
}


