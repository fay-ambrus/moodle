requirejs.config({
    paths: {
        datatables: 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min'
    },
    shim: {
        datatables: {
            deps: ['jquery'],
            exports: '$.fn.DataTable'
        }
    }
});

define(['datatables'], function() {
    return {
        init: function() {
            $('#myTable').DataTable({
                paging: true,
                searching: true,
                ordering: true
            });
        }
    };
});
