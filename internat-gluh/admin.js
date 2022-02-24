$(function() {
    if ($('.add_photo-item').length > 0) {
        // fileupload 
        function uploaderImg(addButton, addInput, imgList, reset = false, edit = false) {
            $(addButton).on('click', function() {
                $(addInput).trigger('click');
            })
            var maxFileSize = 5 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
            var queue = {};
            var imagesList = $(imgList);
            var filelist = $('.file_list').children().length;
            // 'detach' подобно 'clone + remove'
            var itemPreviewTemplate = imagesList.find('.item').detach();
            var fileLimit = 5
            var fileTypeArr = [
                'jpeg',
                'jpg',
                'png',
                'pdf',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'zip',
                'rar',
            ];
            // Вычисление лимита
            function limitUpload() {
                if (filelist > 0 || edit) {
                    return fileLimit - filelist;
                } else if (filelist == 0 || !edit) {
                    return fileLimit - imagesList.children().length;
                }
            }
            // Отображение лимита
            function limitDisplay() {
                let sTxt;
                switch (limitUpload()) {
                    case fileLimit:
                        sTxt = '<span class="text">Прикрепить ' + limitUpload() + ' файлов</span>';
                        break;
                    case 0:
                        sTxt = 'Достигнут лимит';
                        break;
                    default:
                        sTxt = 'можно добавить ещё ' + limitUpload();
                }
                $(addButton).html(sTxt);
            }

            function limitSize() {
                $(addInput).bind('change', function() {
                    var total = 0;
                    for (var i = 0; i < this.files.length; i++) {
                        total = total + this.files[i].size;
                    }
                    return total;
                });
            }
            limitSize();
            $(addInput).on('change', function() {
                var files = this.files;
                // Перебор файлов до лимита
                for (var i = 0; i < limitUpload(); i++) {
                    let file = files[i];
                    let fileType = ''
                    if (file !== undefined) {
                        fileType = file.name.split('.').pop()
                        if ($.inArray(fileType, fileTypeArr) < 0) {
                            $(".errormassege").text('')
                            $(".errormassege").append('Файлы должны быть в формате jpg, jpeg, png, zip, doc, docx, xls, xlsx, pdf');
                            continue;
                        }
                        if (file.size > maxFileSize) {
                            $(".errormassege").append("Размер файла не должен превышать 2 Мб")
                            continue;
                        }
                        $(".errormassege").html('');
                        preview(file, fileType);
                    }
                }
                this.value = '';
            });

            function preview(file, fileType) {
                var reader = new FileReader();
                reader.addEventListener('load', function(event) {
                    if (fileType == 'jpeg' || fileType == 'jpg' || fileType == 'png') {
                        var img = document.createElement('img');
                        var itemPreview = itemPreviewTemplate.clone();
                        itemPreview.find('.img-wrap img').attr('src', event.target.result);
                        itemPreview.data('id', file.name);
                        imagesList.append(itemPreview);
                    } else {
                        var itemPreview = itemPreviewTemplate.clone();
                        $(itemPreview).find('.img-wrap').remove();
                        let icon = 'fa-file'
                        switch (fileType) {
                            case 'xls':
                                icon = 'fa-file-excel-o'
                                break;
                            case 'xlsx':
                                icon = 'fa-file-excel-o'
                                break;
                            case 'rar':
                                icon = 'fa-file-archive-o'
                                break;
                            case 'zip':
                                icon = 'fa-solid fa-file-zipper'
                                break;
                            case 'docx':
                                icon = 'fa-file-word-o'
                                break;
                            case 'doc':
                                icon = 'fa-file-word-o'
                                break;
                            case 'pdf':
                                icon = 'fa-file-pdf-o'
                                break;
                            default:
                                icon = 'fa-solid fa-file'
                                break;
                        }
                        itemPreview.find('.icon-wrap i').addClass(icon);
                        itemPreview.data('id', file.name);
                        imagesList.append(itemPreview);
                    }
                    // Обработчик удаления
                    itemPreview.on('click', function() {
                        delete queue[file.name];
                        $(this).remove();
                        limitDisplay();
                    });
                    queue[file.name] = file;
                    // Отображение лимита при добавлении
                    limitDisplay();
                });
                reader.readAsDataURL(file);
            }
            // Очистить все файлы
            function resetFiles() {
                $(addInput)[0].value = "";
                limitDisplay();
            }
            if (reset) {
                resetFiles();
            }
            // Отображение лимита при запуске
            limitDisplay();
            return queue
        }
        var filesArr = uploaderImg('.add_photo-item', '#js-photo-upload', '#uploadImagesList', false, false);
        console.log(filesArr);
    }
})