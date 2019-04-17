$(document).ready(function () {

    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });

    let signaturePad;
    if (document.getElementById('signature')) {
        let canvas = document.getElementById("signature");
        signaturePad = new SignaturePad(canvas);
    }

    $('#clear-signature').on('click', function (e) {
        e.preventDefault();
        signaturePad.clear();
    });

    $('input[type=radio][name=birthPlace]').on('change', function () {
        if ($(this).val() === 'foreign') {
            $('#foreignCountry').show();
        } else {
            $('#foreignCountry').hide();
        }
    });


    $('input[type=radio][name=residencyCountry]').on('change', function () {
        if ($(this).val() === '0') {
            $('.citizenship').show();
        } else {
            $('.citizenship').hide();
        }
    });

    $('#submit').click(function (e) {
        e.preventDefault();
        let signature = '';

        if (!signaturePad.isEmpty()) {
            signature = signaturePad.toDataURL();
        }

        let data = {
            formData: $('#buyerForm').serialize(),
            signature: signature
        };

        $.post(base_url + 'save-boundbook-form', data)
            .done(function (response) {
                if (response.status === 'success') {
                    $('#responseModalLabel').html(response.status);
                    $('.modal-body').html(response.message);
                }
            })
            .fail(function (error) {
                $('#responseModalLabel').html('Error');
                $('.modal-body').html(error.responseJSON);
            })
            .always(function () {
                $('#responseModal').modal();
            });
    });


    let formsListDtb = $('#forms-list').DataTable({
        searchPane: true,
        ajax: {
            'url': base_url + 'list/get',
            'type': 'post'
        },
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        searchDelay: 9000,
        columns: [
            {
                data: 'id',
                title: "ID",
                orderable: true,
            }, {
                data: "first_name_1",
                title: "First Name",
                orderable: false
            }, {
                data: "last_name_1",
                title: "Last Name",
                orderable: false
            }, {
                data: "date_filled_14",
                title: "Date",
                render: function (data) {
                    return new Date(data).toDateString();
                }
            },
            {
                title: "Section B",
                orderable: false,
                render: function (data, type, row) {
                    return `<a class="pdf-download" href="${base_url}fill_sectionB/${row.id}"> 
                              <button class="btn btn-success pdf-download">Section B</button>
                            </a>`;
                }
            },
            {
                title: "Section D",
                orderable: false,
                render: function (data, type, row) {
                    return `<a class="pdf-download" href="${base_url}fill_sectionD/${row.id}"> 
                              <button class="btn btn-success pdf-download">Section D</button>
                            </a>`;
                }
            },
            {
                title: "Download",
                orderable: false,
                render: function (data, type, row) {
                    return `<a class="pdf-download" href="${base_url}pdf/download?id=${row.id}"> 
                              <button class="btn btn-success pdf-download">PDF</button>
                            </a>`;
                }
            },
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    });

    formsListDtb.on('click', 'tbody tr', function (e) {
        if (e.target.closest('.pdf-download') !== null) {
            return;
        }
        let data = formsListDtb.row(this).data();

        $.post(base_url + 'record/get', {id: data.id})
            .done(function (response) {
                if (response.status === 'success') {
                    $('#responseModalLabel').html(response.status);
                    let list = '';
                    let filterdData = response.filterdData;

                    for (let key in filterdData) {
                        list += `<li class="list-group-item  d-flex justify-content-between align-items-center">
                                     <span>${key}</span>
                                     <span>${filterdData[key]}</span>
                                 </li>`;
                    }

                    $('.modal-body .row-fields').show().find('ul').html(list);
                } else {
                    $('#responseModalLabel').html('Error');
                    $('.modal-body').html('Something went wrong,please try again');
                }
            })
            .fail(function (error) {
                $('#responseModalLabel').html('Error');
                $('.modal-body').html(error.responseJSON);

            })
            .always(function () {
                $('#responseModal').modal();
            });
    });

});

console.log(action);

if (action == 'fill_sectionB') {
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker3').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker4').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker5').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker6').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $('#datepicker7').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $(document).ready(function ($) {

        var canvas = document.getElementById("signature");
        let signaturePad = new SignaturePad(canvas);

        $('#clear-signature').on('click', function () {
            signaturePad.clear();
        });

        $(document).on('click', '#save_section_b', function () {

            var data = $('#save_sectionB_form').serializeArray();
            var url = base_url + 'boundbookController/ax_save_sectionB';

            if (!signaturePad.isEmpty()) {
                data.push({name: 'signature', 'value': signaturePad.toDataURL()})
            }

            var file_data = new FormData;

            var input1 = $('#identification_photo_id');
            var input2 = $('#government_photo');
            var input3 = $('#exception_photo');

            var inp_val1 = input1[0].files[0];
            var inp_val2 = input2[0].files[0];
            var inp_val3 = input3[0].files[0];

            if(typeof input1[0].files[0] == 'undefined'){

                 inp_val1 = '';
            }

            if(typeof input2[0].files[0] == 'undefined'){

                inp_val2 = '';
            }

            if(typeof input3[0].files[0] == 'undefined'){

                inp_val3 = '';
            }

            file_data.append('identification_photo_id',inp_val1);
            file_data.append('government_photo', inp_val2);
            file_data.append('exception_photo', inp_val3);

            $.each(data, function (index, value) {

                file_data.append(value['name'], value['value']);
            });

            ax_upload_file_ajax(file_data, url, save_sectionB_handler);
            //  send_ajax(url, 'post', data, {handler: 'save_sectionB_handler'});
        });


    });

    function save_sectionB_handler(data) {
        console.log(1);
    }

    $(document).on('click','.load_file',function () {

        $(this).parent('.snap-id').find('.over_hidden').trigger('click');
    });
}

if (action == 'fill_sectionD') {

    $('#datepicker7').datepicker({
        uiLibrary: 'bootstrap4',
        format:'yyyy-mm-dd'
    });
    $(document).ready(function ($) {

        var canvas = document.getElementById("signature");
        let signaturePad = new SignaturePad(canvas);

        $('#clear-signature').on('click', function () {
            signaturePad.clear();
        });

        $(document).on('click', '#save_sec_d', function () {

            var data = $('#sec_d_form').serializeArray();
            var url = base_url + 'boundbookController/ax_save_sectionD';

            if (!signaturePad.isEmpty()) {
                data.push({name: 'signature', 'value': signaturePad.toDataURL()})
            }


            send_ajax(url, 'post', data, {handler: 'save_sectionB_handler'});
        });


    });

    function save_sectionB_handler(data) {
        console.log(1);
    }
}

function ax_upload_file_ajax(file_data, url, handler) {

    var widget = this;
    widget.queuePos++;
    $.ajax({
        url: url,
        type: 'post',
        data: file_data,
        cache: false,
        contentType: false,
        processData: false,
        forceSync: false,
        dataType: 'json',
        xhr: function () {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                xhrobj.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    var position = event.loaded || event.position;

                    var total = event.total || e.totalSize;
                    if (event.lengthComputable) {
                        percent = Math.ceil(position / total * 100);

                    }

                    processing(percent);

                }, false);
            }

            return xhrobj;
        },
        success: function (data) {

            var obj_upload = data;

            if (handler != '') {
                eval(handler(data))
            }

            $('#mass_upload_file_name').val(obj_upload['file_name']);

            $('.progressbar .proc_span').html('');
            $('.progressbar .procent').css('width', '0');
            $('#mass_upload_inp').val('');
        }
    });
}

function processing(procent) {

    $('#upload_progressbar .proc_span').html(procent + '%');
    $('#upload_progressbar .procent').css('width', procent + '%');

}

$('.no_href').click(function (e) {
    e.preventDefault();
});