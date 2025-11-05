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

define(['datatables', 'jquery'], function() {
    return {
        init: function() {
            $('#myTable').DataTable({
                ordering: false,
                paging: false,
                initComplete: function () {
                    // Add search box to name column
                    let nameColumn = this.api().column(1);

                    let title = nameColumn.header().textContent;

                    let input = document.createElement('input');
                    input.placeholder = title;
                    nameColumn.header().appendChild(input);

                    input.addEventListener('keyup', () => {
                        if (nameColumn.search() !== this.value) {
                            nameColumn.search(input.value).draw();
                        }
                    });



                    // Add dropdown selector to group membership column
                    let groupColumn = this.api().column(3);

                    let groups = new Set();

                    groupColumn.data().each(function (d) {
                        if (d) {
                            let split = d.split(', ');
                            split.forEach(v => groups.add(v));
                        }
                    });

                    let dropdown = $('<div class="filter-dropdown"></div>');
                    let select = $('<select multiple></select>');
                    groups.forEach(v => {
                        select.append(`<option value="${v}">${v}</option>`);
                    });

                    dropdown.append(select);
                    console.log(select, typeof select, dropdown, typeof dropdown);
                    groupColumn.header().append(dropdown);

                    select.on('change', function () {
                        let selected = $(this).val();
                        if (!selected || selected.length === 0) {
                            column.search('').draw();
                        } else {
                            let regex = selected.map(v => `^${v}$`).join('|');
                            column.search(regex, true, false).draw();
                        }
                    });
                    console.log("init complete...");
                },
            });
        }
    };
});
