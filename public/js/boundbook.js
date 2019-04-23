$(document).on('keypress', '.not_string', function (key) {
    if (key.charCode > 65 || key.charCode > 90) {

        return false;
    }

});

/*$(document).on('change', '.not_string', function (key) {

    if (!$.isNumeric($(this).val())) {

        $(this).val('');
    }
});*/

$('.socialSecNumber').on('keypress', function () {

    var val = $(this).val();

    if (val.length > 10) {
        return false;
    }
});

$('.socialSecNumber').on('keyup change', function () {

    var val = $(this).val();
    if (val.length == 3 || val.length == 6) {

        $(this).prop('value', val + '-');
    }

    if (val.length > 11) {
        return false;
    }
});

$('.phoneNumber').on('keyup change', function () {

    var val = $(this).val();

    if(val.length == 1){

        $(this).prop('value', '(' + val);
    }

    if(val.length == 4){

        $(this).prop('value',  val + ')');
    }

    if(val.length == 5){

        $(this).prop('value',  val + ' ');
    }

    if (val.length == 9) {

        $(this).prop('value', val + '-');
    }

});

$('.phoneNumber').on('keypress', function () {

    var val = $(this).val();

    if (val.length > 13) {
        return false;
    }
});

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

        $('#buyerForm *').removeClass('error_red_class');

        $('.show_error1').html('');

        var fields = {
            options: {selector: '.show_error', modal_show: '#error_modal', single: false, form_id: '#buyerForm'},
            fName: {errorname: 'First Name', required: true},
            lName: {errorname: 'Last Name', required: true},
            datepicker: {errorname: 'Date & Place of Birth', required: true},
            birthState: {errorname: 'State', required: true},
            birthCity: {errorname: 'City', required: true},
            weight: {errorname: 'Weight', required: true},
            homeAddress1: {errorname: 'Address 1', required: true},
            homeZip: {errorname: 'Zip Code', required: true},
            homeState: {errorname: 'State', required: true},
            homeCity: {errorname: 'City', required: true},
            residencyState: {errorname: 'Residency State', required: true},
            email: {errorname: 'Email', emailvalid: true},
        };



        var validation = new validation_lib(fields);

        if (!validation.validate_field()) {

            $('html,body').animate({
                    scrollTop: $('#buyerForm').offset().top
                },
                'slow');

            return false;
        }

        var socialSecNumber = $('.socialSecNumber').val();

         socialSecNumber = socialSecNumber.replace(/-/gi, "");

        $('.socialSecNumber').prop('value',socialSecNumber);

        var phoneNumberVal = $('.phoneNumber').val();

        phoneNumberVal = phoneNumberVal.replace(/-/gi, "");

        phoneNumberVal = phoneNumberVal.replace(")", "");

        phoneNumberVal = phoneNumberVal.replace("(", "");
        phoneNumberVal = phoneNumberVal.replace(" ", "");

        $('.phoneNumber').prop('value',phoneNumberVal);

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

                var obj = JSON.parse(response);

                if(obj['errors'].length>0){

                    $('#responseModalLabel').html('Error');
                    $('.modal-body').html('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][0] + '</span></div>');

                }else{
                    $('#responseModalLabel').html(obj.status);
                    $('.modal-body').html(obj['success']);
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
        searching: false,
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
                title: "Section A",
                orderable: false,
                render: function (data, type, row) {
                    return `<a class="pdf-download" href="${base_url}fill_sectionA/${row.id}"> 
                              <button class="btn btn-success pdf-download">Section A</button>
                            </a>`;
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
                    return `<a class="pdf-download" href="${base_url}FormsListController/pdfDownload/${row.id}"> 
                              <button class="btn btn-success pdf-download">PDF</button>
                            </a>`;
                }
            },
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    });

    function data_table() {

        var settings = $("#forms-list").dataTable().fnSettings();

        settings.ajax.data = {'type': $('#search_crt').val(), 'searching_val': $('#search_val').val()};

        formsListDtb.ajax.url(base_url + 'list/get').load();
    }

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


    $(document).on('keyup', '#search_val', function () {

        data_table();
    });

    $(document).on('change', '#search_val', function () {

        data_table();
    });

    /*    $(document).on('change','#search_crt',function () {

            if($(this).val() == 'birth_date_7'){

                $('#search_val').datepicker({
                    uiLibrary: 'bootstrap4',
                    format:'yyyy-mm-dd',
                    autoclose:true,
                });

            }else{
                $('#search_val').datepicker('destroy');
                $('#search_val').val('');
            }
        })*/

});

console.log(action);

if (action == 'fill_sectionB') {
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker3').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker4').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker5').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker6').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('#datepicker7').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $(document).ready(function ($) {

        var canvas = document.getElementById("signature");
        let signaturePad = new SignaturePad(canvas);

        $('#clear-signature').on('click', function () {
            signaturePad.clear();
        });

        $(document).on('click', '#save_section_b', function () {

            /* $('#buyerForm *').removeClass('error_red_class');

             var fields = {
                 options: {selector: '.show_error', modal_show:'#error_modal', single: false, form_id: '#save_sectionB_form'},
                 name_of_functions: {errorname: 'Name of Function', required: true},
                 function_state: {errorname: 'State', required: true},
                 birthCity: {errorname: 'City', required: true},
                 issuing_authority: {errorname: 'Issuing Authority', required: true},
                 type_of_identification: {errorname: 'Type of Identification', required: true},
                 number_identification: {errorname: 'Number of Identification', required: true},
                 identification_exp_date: {errorname: 'Expiration Date', required: true},
                 government_issued_documentation: {errorname: 'Government Issued Documentation', required: true},
                 exception_documentation: {errorname: 'Exception Documentation', required: true},
                 date_19a: {errorname: 'Date', required: true},
                 transaction_number: {errorname: 'State transaction number', required: true},
                 state_transaction: {errorname: 'State transaction', required: true},
                 d19_nics_date: {errorname: 'Date', required: true},
                 e19_nics_date: {errorname: 'Date', required: true},
                 f19_name: {errorname: 'Name', required: true},
                 f19_number: {errorname: 'Number', required: true},
                 g19_name: {errorname: 'Name', required: true},
                 state_permit_dade: {errorname: 'Issuing State and Permit Type', required: true},
                 issuance_date: {errorname: 'Issuance Date', required: true},
                 expiration_date: {errorname: 'Expiration Date', required: true},
                 permit_number: {errorname: 'Permit Number', required: true},
             };

             var validation = new validation_lib(fields);

             if (!validation.validate_field()) {

                 $('html,body').animate({
                         scrollTop: $('#save_sectionB_form').offset().top
                     },
                     'slow');

                 return false;
             }
 */

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

            if (typeof input1[0].files[0] == 'undefined') {

                inp_val1 = '';
            }

            if (typeof input2[0].files[0] == 'undefined') {

                inp_val2 = '';
            }

            if (typeof input3[0].files[0] == 'undefined') {

                inp_val3 = '';
            }

            file_data.append('identification_photo_id', inp_val1);
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

        $('.modal-body').html('');
        $('#responseModalLabel').html('');

        $('#responseModal').modal('show');
        $('#responseModalLabel').html('Success');
        $('.modal-body').html('Your information successfully saved.');
    }

    $(document).on('click', '.load_file', function () {

        $(this).parent('.snap-id').find('.over_hidden').trigger('click');
    });
}

if (action == 'fill_sectionD') {

    $('#datepicker7').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $(document).ready(function ($) {

        var canvas = document.getElementById("signature");
        let signaturePad = new SignaturePad(canvas);

        $('#clear-signature').on('click', function () {
            signaturePad.clear();
        });

        $(document).on('click', '#save_sec_d', function () {

            $('#sec_d_form *').removeClass('error_red_class');

            var arr = $('.secB_valid_field');

            var error_log = true;

            $.each(arr, function (index, value) {

                if ($(value).val() == '') {
                    error_log = false;
                    $(this).addClass('error_red_class');
                    $('.show_error1').append('<div><span class="error_img"></span> <span class="error_class">' + $(value).attr('placeholder') + ' field is required.</span></div>');
                }
            });

            var fields = {
                options: {selector: '.show_error', modal_show: '#error_modal', single: false, form_id: '#sec_d_form'},
                sec_d_one: {errorname: 'One', required: true},
                sec_d_transfer_fname: {errorname: 'Full Name', required: true},
                sec_d_transfer_title: {errorname: 'Title', required: true}
            };

                var validation = new validation_lib(fields);

            if (!error_log) {
                $('#error_modal').modal('show');
            }

            if (!validation.validate_field() || !error_log) {

                $('html,body').animate({
                        scrollTop: $('#sec_d_form').offset().top
                    },
                    'slow');

                return false;
            }

            var data = $('#sec_d_form').serializeArray();
            var url = base_url + 'boundbookController/ax_save_sectionD';

            if (!signaturePad.isEmpty()) {
                data.push({name: 'signature', 'value': signaturePad.toDataURL()})
            }


            send_ajax(url, 'post', data, {handler: 'save_sectionB_handler'});
        });


    });

    function save_sectionB_handler(data) {

        var obj = JSON.parse(data);

        $('.modal-body').html('');
        $('#responseModalLabel').html('');

        if(obj['errors'].length>0){

            $('#responseModal').modal('show');
            $('#responseModalLabel').html('Error');
            $('.modal-body').html('<div><span class="error_img"></span> <span class="error_class">' + obj['errors'][0] + '</span></div>');

        }else{
            $('#responseModal').modal('show');
            $('#responseModalLabel').html('Success');
            $('.modal-body').html('Your information successfully saved.');
        }
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

$(document).on("keyup", ".search_zip_code", function(){

    var inpid  = $(this).attr("name");
    var ans    = "#"+inpid+"_div";

    var search = {search:this.value, inputid:inpid};

    var url = base_url+"BoundbookController/ax_search_zip_code";

    if(this.value.length != 5){

        $(ans).css('display', 'none');

        return false;
    }

    var sucfunc = '$("'+ans+'").addClass("show_single")';


    send_ajax(url, 'post', search, {answer:ans, success:sucfunc});
});

$(document).on("click",".single_zip_div",function() {
    var inputid = "#"+$(this).attr("data-input");
    var zip = $(this).attr("data-zip");
    $(inputid).val(zip);
    $(inputid+"_div").css("display", "none");
    $(this).parent().removeClass('show_single');
    $(this).parents('.card-body').find('.city').val( $(this).attr("data-city"));
    $(this).parents('.card-body').find('.zip').val($(this).attr("data-zip"));

    $(this).parents('.card-body').find('.state').find("option[value='"+$(this).attr("data-state")+"']").prop('selected',true);
});