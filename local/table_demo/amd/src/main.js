requirejs.config({
    paths: {
        datatables: 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min',
        datatables_select: 'https://cdn.datatables.net/select/3.1.3/js/dataTables.select.min'
    },
    shim: {
        datatables: {
            deps: ['jquery'],
            exports: '$.fn.DataTable'
        },
        datatables_select: {
            deps: ['jquery', 'datatables'],
            exports: '$.fn.DataTable'
        }
    }
});

define(['datatables', 'datatables_select'], function() {
    return {
        init: function() {
            $('#myTable').DataTable({
                initComplete: function () {
                    console.log("hello");
                    let groupColumn = this.api().column(3).select();

                    let title = groupColumn.footer().textContent;

                    console.log(title);

                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    groupColumn.header().appendChild(input);

                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (groupColumn.search() !== this.value) {
                            groupColumn.search(input.value).draw();
                        }
                    });
                },
            });
        }
    };
});
