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
                data.name,
                data.services_procedure.name,
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
                        title: 'Số phòng',
                        name: 'name',
                        width: '15%',
                    },
                    {
                        title: 'Tên dịch vụ',
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
    ServicesProcedure: {
        init(data){
            $('.services_procedure').append(
                data.map(v => {
                    return `<option value="${v.id}">${v.name}</option>`
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

    function loadService(){
        Api.ServicesProcedure.GetAll()
            .done(res => {
                View.ServicesProcedure.init(res);
            })
            .fail(err => {
                console.log(err);
                View.helper.showToastError('Error', 'Something Wrong'); 
            })
            .always(() => {
            });
        Api.Room.GetAll()
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
