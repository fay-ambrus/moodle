define([], function() {
    return {
        init: function() {
            console.log('JS init');
            console.log('sample change');
            document.getElementById('demo_button').addEventListener('click', () => {
                alert('Action!');
            });
        }
    };
});
