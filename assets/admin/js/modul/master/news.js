let newsTable;
let currentFilterStatus = '';
let currentFilterCategory = '';

document.addEventListener('DOMContentLoaded', function () {
    newsTable = initGlobalDatatable('#table_news', function () {
        return {
            filter_status: currentFilterStatus,
            filter_category: currentFilterCategory,
        };
    });

    // Trigger reload on each filter
    document.querySelectorAll('.table-filter').forEach(el => {
        el.addEventListener('change', function () {
            if (newsTable) newsTable.ajax.reload();
        });
    });
});

var image = document.getElementById('display_image');
var title = $('#title_modal').data('title').split('|');
$(function () {

    $('.hps_image').on('click', function () {
        // console.log('hapus');
        $('input[name=name_image]').val("");
    });

    $('#kt_modal_news').on('shown.bs.modal', function () {
        $('#select_id_category').select2({ dropdownParent: $('#form_news') });
        
    });

});

function ubah_data(element, id) {
    var foto = $(element).data('image');
    var form = document.getElementById('form_news');
    $('#title_modal').text(title[0]);
    form.setAttribute('action', BASE_URL + '/master/update_news');
    $.ajax({
        url: BASE_URL + 'setting/get_single/news',
        method: 'POST',
        data: { 
            id: id 
        },
        dataType: 'json',
        success: function (data) {
            image.style.backgroundImage = "url('" + foto + "')";
            document.getElementById("news_file").value = "";
            $('input[name="id_news"]').val(data.id_news);
            $('select[name="id_category"]').val(data.id_category);
            $('select[name="id_category"]').trigger('change');
            $('input[name="title"]').val(data.title);
            $('textarea[name="short_description"]').val(data.short_description);
            $('input[name="name_image"]').val(data.image);
            mydescription.setData(data.description)
        }
    })
}

function tambah_data() {
    var form = document.getElementById('form_news');
    form.setAttribute('action', BASE_URL + '/master/insert_news');
    $('#title_modal').text(title[1]);
    image.style.backgroundImage = "url('" + base_foto + "')";
    $('#form_news input[type="text"]').val('');
    $('#form_news textarea').val('');
    $('#form_news select').val('');
    $('#form_news select').trigger('change');
    mydescription.setData('')
    document.getElementById("news_file").value = "";
}


ClassicEditor.create(document.querySelector('#description'), {
    toolbar: {
        items: CKEditor_tool,
    },
    alignment: {
        options: ['left', 'center', 'right', 'justify'],
    },
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
    },
    link: {
        addTargetToExternalLinks: true, // Add 'target="_blank"' for external links
        decorators: {
            openInNewTab: {
                mode: 'manual',
                label: 'Open in a new tab',
                attributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer'
                }
            }
        }
    },
    fontColor: {
        colors: font_color,
        columns: 5,
        documentColors: 10,
        colorPicker: true,
    },
    fontBackgroundColor: {
        colors: font_color,
    },
    language: 'en',
    licenseKey: '',
}).then((editor) => {
    mydescription = editor;
})
.catch((error) => {
    console.error(error);
});

function get_category(element, callback = null) {
    var value = $(element).val();
    $.ajax({
        url: BASE_URL + '/master/manager/categories',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: value 
        },
        cache : false,
        success: function (msg) {
            $('#select_id_category').html(msg);
            $('#select_id_category').trigger('change');

            // Jalankan callback kalau ada
            if (typeof callback === 'function') {
                callback();
            }
        }
    });
}


function filter_apply(){
    currentFilterStatus = $('#filter_status').val();
    currentFilterCategory = $('#filter_category').val();
    if (newsTable) {
        newsTable.ajax.reload();
    }
}

function set_filter_category(element) {
    var value = $(element).val();
    $.ajax({
        url: BASE_URL + '/master/manager/categories',
        method: 'POST',
        data: { 
            _token : csrf_token,
            id: value,
            all : true
        },
        cache : false,
        success: function (msg) {
            $('#filter_category').html(msg);
            $('#filter_category').trigger('change');
        }
    });
}
