import './styles/app.css';
import './bootstrap';

const deleteObject = (fileName) => {
    const url = window.location.origin + '/delete/' + fileName;

    fetch(url, {method: 'DELETE'}).then(res => {
        window.location.reload();
        console.log(fileName + ' DELETED ✅');
    });
};

const uploadObject = (formData) => {
    const url = window.location.origin + '/upload';

    fetch(url, {method: 'POST', body: formData}).then(res => {
        window.location.reload();
        console.log('UPLOADED ✅');
    });
};

$(function() {
    $('svg.delete').on('click', function(event) {
        deleteObject($(event.currentTarget).data('filename'));
    });

    $('input[type="file"]').change(function(e) {
        let data = new FormData();
        data.append('upload', e.target.files[0]);

        uploadObject(data);
    });
});
