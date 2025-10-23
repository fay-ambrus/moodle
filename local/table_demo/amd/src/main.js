define(['core/datatables'], function() {
    return {
        init: function() {
            document.getElementById('demo_button').addEventListener('click', () => {
                alert('Action!');
            });
            $('#myTable').DataTable({
                paging: true,
                searching: true,
                ordering: true
            });
        }
    };
});
