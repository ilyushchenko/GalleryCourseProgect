var $ = jQuery.noConflict();

$(document).ready(function () {
        // Обработка нажатия кнопки удаления фото из альбома
        $(function () {
            $(".delPhoto").on("click", function (event) {
                event.preventDefault();
                if (this.hasAttribute('photoID')) {
                    var photoID = this.getAttribute('photoID');
                    var deleteDataArray = {deletePhoto: photoID};
                    $.post("/update.php", deleteDataArray, function (data) {
                        console.log(data);
                        var obj = jQuery.parseJSON(data);
                        console.log(obj);
                        if (obj.deleted == 1) {
                            var elem = $('.row[photoID = ' + photoID + ']');
                            elem.remove();
                        }
                    })
                }
            });
        });

        $(function () {
            $(".setPlaceholder").on("click", function (event) {
                if (this.hasAttribute('photoID')) {
                    var photoID = this.getAttribute('photoID');
                    var setPlaceholderDataArray = {setPlaceholder: photoID};
                    $.post("/update.php", setPlaceholderDataArray, function (data) {
                        console.log(data);
                        var obj = jQuery.parseJSON(data);
                        console.log(obj);
                    })
                }
            });
        });

        // Отмена POST запроса и получение данных с формы
        $(function () {
            $("form.update-photo-info").on("submit", function (event) {
                event.preventDefault();
                var submitButton = $(this).find("button[type='submit']");
                var formValues = $(this).serialize();
                $.post('/update.php', formValues, function (data) {
                    console.log(data);
                    submitButton.addClass('btn-success');
                })
            })
        });
    }
);


