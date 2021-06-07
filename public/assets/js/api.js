const Api = {
    Services: {},
    Room: {},
    Customer: {},
    ServicesProcedure: {},
};
(() => {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        crossDomain: true
    });
})();

// Services
(() => {
    Api.Services.GetAll = () => $.ajax({
        url: `/api/service/getall`,
        method: 'GET',
    });
    Api.Services.GetAllWith = () => $.ajax({
        url: `/api/service/getallwith`,
        method: 'GET',
    });
})();


// ServicesProcedure
(() => {
    Api.ServicesProcedure.GetAll = () => $.ajax({
        url: `/api/serviceprocedure/getall`,
        method: 'GET',
    });
})();

// Customer
(() => {
    Api.Customer.GetAll = () => $.ajax({
        url: `/api/customer/getall`,
        method: 'GET',
    });
})();


// Room
(() => {
    Api.Room.GetAll = () => $.ajax({
        url: `/api/room/getall`,
        method: 'GET',
    });

    Api.Room.GetById = (room_list) => $.ajax({
        url: `/api/room/getById`,
        method: 'GET',
        dataType: 'json',
        data: {
            room_list: room_list ?? '',
        }
    });
})();

//// 



