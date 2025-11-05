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

define(['datatables', 'jquery', 'local_table_demo/table-utils'], function(/*dataTable, $, tableUtils*/) {
    return {
        init: function() {
            $('#demoTable').DataTable({
                ordering: false,
                paging: false,
                searching: false,
                initComplete: function () {
                    // Add search box to name column
                    let nameColumn = this.api().column(1);

                    let title = nameColumn.header().textContent;

                    let input = document.createElement('input');
                    input.placeholder = title;
                    nameColumn.header().appendChild(input);

                    input.addEventListener('keyup', () => {
                        // search
                        if (nameColumn.search() !== this.value) {
                            nameColumn.search(input.value).draw();
                        }

                        // highlight and list on criteria
                        /*if (input.value) {
                            nameColumn.nodes().to$().addClass('highlight');
                        } else {
                            nameColumn.nodes().to$().removeClass('highlight');
                        }*/
                        //tableUtils.refreshSearchCriteria('search', title, input.value);
                    });



                    // Add dropdown selector to group membership column
                    let groupColumn = this.api().column(3);
                    title = nameColumn.header().textContent;
                    let groups = new Set();

                    groupColumn.data().each(function (d) {
                        if (d) {
                            let split = d.split(', ');
                            split.forEach(v => groups.add(v));
                        }
                    });

                    const dropdown = document.createElement('div');
                    dropdown.className = 'filter-dropdown';

                    const select = document.createElement('select');
                    select.multiple = true;

                    groups.forEach(v => {
                            const option = document.createElement('option');
                            option.value = v;
                            option.textContent = v;
                            select.appendChild(option);
                    });

                    dropdown.appendChild(select);
                    groupColumn.header().appendChild(dropdown);

                    select.addEventListener('change', () => {
                        const selected = Array.from(select.selectedOptions).map(opt => opt.value);
                        // search
                        if (selected.length === 0) {
                            groupColumn.search('').draw();
                        } else {
                            const regex = '^(' + selected.join('|') + ')$';
                            groupColumn.search(regex, true, false).draw();
                        }

                        /*// highlight and list on criteria
                        if (selected.length === 0) {
                            groupColumn.nodes().to$().removeClass('highlight');
                        } else {
                            groupColumn.nodes().to$().addClass('highlight');
                        }*/
                        //tableUtils.refreshSearchCriteria('selectMultiple', title, selected.join(', '));
                    });
                    console.log("init complete");
                },
            });
        }
    };
});
