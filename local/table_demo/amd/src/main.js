requirejs.config({
    paths: {
        datatables: 'https://cdn.datatables.net/2.3.4/js/dataTables.min.js'
    },
    shim: {
        datatables: {
            exports: 'D'
        }
    }
});

define(['datatables'], function() {
    return {
        init: function() {
            document.getElementById('demo_button').addEventListener('click', () => {
                alert('Action!');
            });
            let table = new D.DataTable('#myTable');
        }
    };
});
