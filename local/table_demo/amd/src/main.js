define([], function() {
    return {
        init: function() {
            console.log('JS init');
            document.getElementById('demo_button').addEventListener('click', () => {
                alert('Action!');
            });
        }
    };
});
