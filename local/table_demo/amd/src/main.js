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
                    console.log("init complete ");
                    let groupColumn = this.api().column(-1).select();

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
