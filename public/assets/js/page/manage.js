const View = {
    table: {
        // private
        __resource: '#data-table',
        __table: null,
        __rows: [],
        __paginationList: [10, 20, 50, 100],
        __selected: [],
        barge: [
            "danger",
            "success",
        ],
        barge_title: [
            "Đã tạm ẩn",
            "Đang hoạt động",
        ],
        __generateDTRow(data) {
            return [
                data.id,
                data.username,
                data.admin_info.name,
                data.email,
                `<span class="badge badge-pill badge-${this.barge[data.status]}">${this.barge_title[data.status]}</span>`,
                `<div class="view-order" style="cursor: pointer" atr="View"><i class="anticon anticon-eye"></i></div>`
            ];
        },
        listRows() {
            return this.__rows;
        },
        getRow(id) {
            // lấy ra row với id của bảng
            pageLength  = this.__resource.DataTable().page.len();
            pageSelect  = this.__resource.DataTable().page()
            rowData = id + pageLength * pageSelect;
            return this.__rows[rowData];
        },
        insertRow(data) {
            // thêm dòng
            const dtRow = this.__generateDTRow(data);
            this.__table.row.add(dtRow);
            this.__rows.push(data);
        },
        updateRow(id, data) { },
        clearRows() {
            // xóa toàn bộ bảng
            this.__table.clear();
            this.__rows = [];
        },
        onRowAction(name, callback) {
            $(document).on('click', '.view-order', function() {
                const rowid = $(this).closest('tr').find('.id-order').html();
                if($(this).attr('atr').trim() == name) {
                    callback(rowid);
                }
            });
        },
        render() {
            // vẽ bảng
            this.__table.draw();
        },
        init() {
            this.__table    = $(this.__resource).DataTable({
                colReorder: true,
                // fixedHeader: true,
                columns: [
                    {
                        title: 'ID',
                        name: 'id',
                        orderable: true,
                        width: '10%',
                    },
                    {
                        title: 'Username',
                        name: 'name',
                        width: '15%',
                    },
                    {
                        title: 'Họ và tên',
                        name: 'name',
                        width: '15%',
                    },
                    {
                        title: 'Email',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        title: 'Trạng thái',
                        name: 'status',
                        orderable: true,
                        width: '20%',
                    },
                    {
                        title: 'Hành động',
                        name: 'detail',
                        orderable: false,
                        width: '15%',
                    },
                ],
                pageLength: 10,
                lengthChange: true,
                searching: true,
                paging: true,
                autoWidth: false,
                order: [],
                "language": {
                    "emptyTable": `<img class="" style="width: 50%" src="/images_global/artboard_empty.jpeg" alt="Logo">`
                }
            });
        }
    },
    helper: {
        showToastSuccess(title, message) {
            $('#notification-sending').remove();
            var toastHTML = `<div class="alert alert-success fade hide" data-delay="2000">
                                <div class="d-flex justify-content-start">
                                    <span class="alert-icon m-r-20 font-size-30">
                                        <i class="anticon anticon-check-circle"></i>
                                    </span>
                                    <div>
                                        <h5 class="alert-heading">${title}</h5>
                                        <p>${message}</p>
                                    </div>
                                </div>
                            </div>`
            $(document).on('click', '#notification-success .alert', function () {
                $(this).remove();
            })
            $('#notification-success').append(toastHTML)
            $('#notification-success .alert').toast('show');
            setTimeout(function () {
                $('#notification-success .alert:first-child').remove();
            }, 2000);
        },
        showToastError(title, message) {
            $('#notification-sending').remove();
            var toastHTML = `<div class="alert alert-danger fade hide" data-delay="2000">
                                <div class="d-flex justify-content-start">
                                    <span class="alert-icon m-r-20 font-size-30">
                                        <i class="anticon anticon-close-circle"></i>
                                    </span>
                                    <div>
                                        <h5 class="alert-heading">${title}</h5>
                                        <p>${message}</p>
                                    </div>
                                </div>
                            </div>`
            $('#notification-error').append(toastHTML)
            $('#notification-error .alert').toast('show');
            setTimeout(function () {
                $('#notification-error .alert:first-child').remove();
            }, 2000);
        },
        showToastProcessing(title, message) {
            var toastHTML = `<div class="alert alert-primary fade hide" data-delay="400000">
                                <div class="d-flex justify-content-start">
                                    <span class="alert-icon m-r-20 font-size-30">
                                        <i class="anticon anticon-loading"></i>
                                    </span>
                                    <div>
                                        <h5 class="alert-heading">${title}</h5>
                                        <p>${message}</p>
                                    </div>
                                </div>
                            </div>`
            $('#notification-sending').append(toastHTML)
            $('#notification-sending .alert').toast('show');
        },
    },
    uploadImage:{
        onUpload(){
            $(document).on('change', '.services-image', function(e) {
                var img = new Image;
                img.src = URL.createObjectURL(e.target.files[0]);
                img.onload = function() {
                    $('.image-preview-wrapper').find('img').attr('src', URL.createObjectURL(e.target.files[0]))
                }
            });
        }
    },
    ServicesProcedure: {
        onCalculate(callback){
            $(document).on('click', '.calculate-time', function() {
                callback();
            });
        },
        init(data){
            $('.services_procedure').append(
                data.map(v => {
                    $('.services_list').append(`
                        <div class="form-group">
                            <label >${v.name}</label>
                            <div class="row">
                                ${
                                    v.services_procedure.map(data => {
                                        return `<div class="col-xs-12 col-md-3">
                                                <label><input type="checkbox" class="m-r-5 data-booking" name="${data.id}" data-time="${data.time}">${data.name} - ${data.time}</label>
                                            </div>`
                                    }).join("")
                                }
                            </div>
                        </div>
                     `)

                }).join("")
            )
        }
    },
    modals: {

        init() {

        }
    },
    init() {
        this.table.init();
        this.modals.init();
    }
};
(() => {
    View.init();
    View.uploadImage.onUpload();
    function loadService(){
        Api.Services.GetAllWith()
            .done(res => {
                console.log(res);
                View.ServicesProcedure.init(res);
                // View.helper.showToastSuccess('Success', 'Getting Successful!'); 
                // View.table.clearRows();
                // Object.values(res).map(v => {
                //     View.table.insertRow(v);
                //     View.table.render();
                // })
                // View.table.render();
            })
            .fail(err => {
                console.log(err);
                View.helper.showToastError('Error', 'Something Wrong'); 
            })
            .always(() => {
            });
    }

    View.ServicesProcedure.onCalculate(() => {
        room_list = [];
        $('.data-booking').each(function(index, el) {
            if ($(el).is(':checked')) room_list.push($(el).attr('name'));
        });
        Api.Room.GetById(room_list)
            .done(res => {
                console.log(res);
            })
            .fail(err => {
                console.log(err);
            })
            .always(() => {
            });
    })

    loadService()
})();
