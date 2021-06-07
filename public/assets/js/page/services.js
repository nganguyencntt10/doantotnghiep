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
                `<div class="id-order">${data.id}</div>`,
                `<img src="/${data.image}" style="width: 100px;">`,
                data.name,
                data.description,
                data.detail,
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
                        title: 'Hình ảnh',
                        name: 'name',
                        width: '15%',
                    },
                    {
                        title: 'Tên dịch vụ',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        title: 'Mô tả ngắn',
                        name: 'status',
                        orderable: true,
                        width: '20%',
                    },
                    {
                        title: 'Mô tả Đầy đủ',
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
    uploadImages: {
        onUpload(){
            $(document).on('change', '.services-images', function() {
                $('.image-list').find('.image-item').remove();
                if (this.files) {
                    var filesAmount = this.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $('.image-list').append(`
                                <div class="image-item">
                                    <img src="${event.target.result}">
                                </div>`); 
                        }
                        reader.readAsDataURL(this.files[i]);
                    }
                }
            });
        }
    },
    Procedure: {
        createDocument(name, time, prices){
            $('.services-sub-wrapper').append(`
                <div class="row m-t-10">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <label for="">Tên quy trình</label>
                        <input type="text" class="form-control" name="procedure_name[]" required="" readonly="" value="${name}">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="">Thời gian thực hiện</label>
                        <input type="number" class="form-control" name="procedure_time[]" required="" readonly="" value="${time}">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="">Thời gian thực hiện</label>
                        <input type="number" class="form-control" name="procedure_prices[]" required="" readonly="" value="${prices}">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <div class="btn btn-tone btn-danger pointer procedure-delete float-right m-t-30" atr="Delete Procedure">
                            Xóa
                        </div>
                    </div>
                </div>
            `)
        },
        onCreate(name, callback){
            $(document).on('click', '.procedure-create', function() {
                if($(this).attr('atr').trim() == name) {
                    callback($(this));
                }
            });
        },
        onDelete(name, callback){
            $(document).on('click', '.procedure-delete', function() {
                if($(this).attr('atr').trim() == name) {
                    callback($(this));
                }
            });
        },
    },
    modals: {
        createCategory: {
            resource: '#create-category',
            show(){
                $(this.resource).modal(true)
            },
            hide() {
                $(`${this.resource}`).modal('hide');
            },
            setDefaul(){
                $(this.resource).find('.name').val('')
            },
            setVal(data){ },
            getVal(){
                return {
                    name: $(this.resource).find('.name').val()
                }
            },
            launch() {
                const modalBodyHTML = ` `;
                $(`${this.resource} .modal-body`).html(modalBodyHTML);
            },
            show(){
                $(`${this.resource}`).modal('show');
            },
            unbindAll() {
                $(`${this.resource} .modal-footer :is(.reject-btn, .confirm-btn)`).unbind();
            },
            onPush(name, callback) {
                $(document).on('click', `${this.resource} .modal-action`, function() {
                    if($(this).attr('atr').trim() == name) {
                        callback();
                    }
                });
            },
            init() {

            }
        },
        updateCategory: {
            resource: '#update-category',
            show(){
                $(this.resource).modal(true)
            },
            hide() {
                $(`${this.resource}`).modal('hide');
            },
            setDefaul(){ },
            setVal(data, rowid){
                $(this.resource).find('.name').val(data.name)
                $(this.resource).find('.status').val(data.status)
                $(this.resource).find('.id').val(rowid)
            },
            getVal(){
                return {
                    name    : $(this.resource).find('.name').val(),
                    status  : $(this.resource).find('.status').val(),
                    id      : $(this.resource).find('.id').val()
                }
            },
            launch() {
                const modalBodyHTML = ` `;
                $(`${this.resource} .modal-body`).html(modalBodyHTML);
            },
            show(){
                $(`${this.resource}`).modal('show');
            },
            unbindAll() {
                $(`${this.resource} .modal-action`).unbind();
            },
            onPush(name, callback) {
                $(document).on('click', `${this.resource} .modal-action`, function() {
                    if($(this).attr('atr').trim() == name) {
                        callback();
                    }
                });
            },
            init() {

            }
        },
        init() {
            this.createCategory.init();
            this.updateCategory.init();
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
    View.uploadImages.onUpload();

    View.Procedure.onCreate('Create Procedure', (item) => {
        var name = item.parent().parent().find('.procedure-name').val();
        var time = item.parent().parent().find('.procedure-time').val();
        var prices = item.parent().parent().find('.procedure-prices').val();
        if (name != '' && time != '' ) {
            View.Procedure.createDocument(name, time, prices)
            name = item.parent().parent().find('.procedure-name').val('');
            time = item.parent().parent().find('.procedure-time').val('');
            prices = item.parent().parent().find('.procedure-prices').val('');;
        }
    })

    View.Procedure.onDelete('Delete Procedure', (item) => {
        item.parent().parent().remove();
    })

    function loadService(){
        Api.Services.GetAll()
            .done(res => {
                View.helper.showToastSuccess('Success', 'Getting Successful!'); 
                View.table.clearRows();
                Object.values(res).map(v => {
                    View.table.insertRow(v);
                    View.table.render();
                })
                View.table.render();
            })
            .fail(err => {
                console.log(err);
                View.helper.showToastError('Error', 'Something Wrong'); 
            })
            .always(() => {
            });
    }

    loadService()
})();
