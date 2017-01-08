$('#photoFile').change(function () {
    var input = $(this)[0];
    if (input.files && input.files[0]) {
        if (input.files[0].type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
                $('#previewInfo').addClass('hide');
                $('#photoPreview').removeClass('hide');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            console.log('ошибка, не изображение');
        }
    } else {
        console.log('хьюстон у нас проблема');
    }
});
$('#form').bind('reset', function () {
    $('#img-preview').attr('src', 'default-preview.jpg');
});

function writeMeSubmit(form) {
    //создаем экземпляр класс FormData, тут будем хранить всю информацию для отправки
    var formData = new FormData();

    //не забывайти проверить поля на заполнение
    //код проверки полей опустим, он к статье не имеет отнашение

    //присоединяем наш файл
    jQuery.each($('#photoFile')[0].files, function (i, file) {
        formData.append('photoFile', file);
    });
    var title = $('input#photoTitle').val();
    var description = $('textarea#photoDescription').val();
    var album = $('input#currentAlbum').val();
    //присоединяем остальные поля
    formData.append('title', title);
    formData.append('description', description);
    formData.append('album', album);

    //отправляем через ajax
    $.ajax({
        url: "/upload.php",
        type: "POST",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: formData, //указываем что отправляем
        success: function (data) {
            console.log(data);
            if (data.ok == 'Y') {
                //если ок, выводим сообщение
                $('#message_form').html('<p style="color: green; text-align: center; margin: 20px 0;">Сообщение успешно отправлено!<br>В ближайшее время мы свяжемся с Вами!</p>');
                setTimeout(function () {
                    $('#message_form').html(' ');
                }, 8000);
            } else {
                $('#message_form').html('<p style="color: red; text-align: center; margin: 20px 0;">Сообщение не может быть отправлено!<br>Попробуйте позже!</p>');
                setTimeout(function () {
                    $('#message_form').html(' ');
                }, 8000);
            }
            form.reset();
        }
    });
    return false;
}