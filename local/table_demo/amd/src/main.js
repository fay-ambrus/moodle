define(['core/datatables'], function() {
    return {
        init: function() {
            document.getElementById('demo_button').addEventListener('click', () => {
                alert('Action!');
            });
            let table = new DataTable('#myTable');
        }
    };
});
