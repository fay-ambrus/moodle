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
                initComplete: function () {
                    let groupColumn = this.api()
                        .column(3)
                        .select();

                    let title = groupColumn.footer().textContent;

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
