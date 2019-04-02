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
            signature:signature
        };

        $.post(base_url+'save-boundbook-form', data)
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
            'url': base_url+'list/get',
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
            }, {
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
        if(e.target.closest('.pdf-download') !== null) {
            return ;
        }
        let data = formsListDtb.row(this).data();

        $.post(base_url+'record/get', {id: data.id})
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

})
;