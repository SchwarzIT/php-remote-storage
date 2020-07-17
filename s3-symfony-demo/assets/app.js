import './styles/app.css';
import './bootstrap';

const deleteObject = (fileName) => {
    const url = window.location.origin + '/delete/' + fileName;

    fetch(url, {
        method: 'DELETE',
    })
        .then(res => res.text())
        .then(res => {
            window.location.reload();
            console.log(fileName + ' DELETED ✅')
        });
};

$(function() {
    $('svg.delete').on('click', function(event) {
        const fileName = $(event.currentTarget).data('filename');

        if (confirm(`⚠️ Are you sure that you will delete this document ${fileName}?`)) {
            deleteObject(fileName);
        }
    });
});
