define(['jquery'], function() {
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
