define([], function() {
    return {
        init: function() {
            document.getElementById('demo').addEventListener('click', () => {
                alert('Action!');
            });
        }
    };
});
