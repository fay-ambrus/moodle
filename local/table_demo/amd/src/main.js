requirejs.config({
    paths: {
        datatables: 'https://cdn.datatables.net/v/dt/dt-2.3.4/sl-3.1.3/datatables.min'
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
                ordering: false,
                initComplete: function () {
                    console.log("hello");
                    let groupColumn = this.api().column(3);

                    let title = groupColumn.header().textContent;

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
