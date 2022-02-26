$(function () {
    // отслеживаем изменения параметров фильтра
    var uploaderParam = { files: [] }
    var uploader = new Proxy(uploaderParam, {
        get: function (target, prop) {
            // console.log({
            // 	type: "get",
            // 	target,
            // 	prop
            // });
            return Reflect.get(target, prop);
        },
        set: function (target, prop, value) {
            // console.log({
            // 	type: "set",
            // 	target,
            // 	prop,
            // 	value
            // });
            return Reflect.set(target, prop, value);
        }
    });
    if ($('.add_photo-item').length > 0) {
        // fileupload 
        function uploaderImg(addButton, addInput, imgList, reset = false, edit = false, fileLimit = 5) {
            $(addButton).on(
                'dragover',
                function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(addButton).css({})
                }
            )
            $(addButton).on(
                'dragenter',
                function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            )
            $(addButton).on(
                'drop',
                function (e) {
                    if (e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {
                        e.preventDefault();
                        e.stopPropagation();
                        prepreview(e.originalEvent.dataTransfer.files)
                    }

                }
            )

            $(addButton).on('click', function () {
                $(addInput).trigger('click');
            })

            var maxFileSize = 5 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
            var queue = {};
            var imagesList = $(imgList);
            var filelist = $('.file_list').children().length;
            var itemPreviewTemplate = imagesList.find('.item').detach();
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
                        sTxt = `Прикрепить ${limitUpload() > 100 ? 'файлы' : limitUpload() + ' файлов'}`;
                        break;
                    case 0:
                        sTxt = 'Достигнут лимит';
                        break;
                    default:
                        sTxt = `можно добавить ещё ${limitUpload() > 100 ? '' : limitUpload()}`;
                }
                $(addButton).html(sTxt);
            }

            function limitSize() {
                $(addInput).on('change', function () {
                    var total = 0;
                    for (var i = 0; i < this.files.length; i++) {
                        total = total + this.files[i].size;
                    }
                    return total;
                });
            }
            limitSize();
            $(addInput).on('change', function () {
                prepreview(this.files)
                this.value = '';
            });
            function prepreview(files) {
                // Перебор файлов до лимита
                for (var i = 0; i < limitUpload(); i++) {
                    let file = files[i];
                    let fileType = ''
                    if (file !== undefined) {
                        fileType = file.name.split('.').pop().toLowerCase()
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
            }
            function preview(file, fileType) {
                var reader = new FileReader();
                var itemPreview = itemPreviewTemplate.clone();
                reader.addEventListener('load', function (event) {
                    if (fileType == 'jpeg' || fileType == 'jpg' || fileType == 'png') {
                        itemPreview.find('.img-wrap').css({ 'background-image': `url(${event.target.result})` });
                        imagesList.append(itemPreview);
                    } else {
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
                        itemPreview.find('.img-wrap').append(`<i class="fa ${icon}"></i>`);
                        imagesList.append(itemPreview);
                    }
                    itemPreview.find('.delete-link').before(`<input type="text" value="${file.name.split('.').shift().toLowerCase()}" name="doc_name_${imagesList.children().length}"/>`)
                    var input = itemPreview.find(`input`)
                    var oldName = file.name
                    $(input).on('change', function () {
                        var newName = `${$(this).val()}.${fileType}`
                        if (oldName !== newName) {
                            var myNewFile = new File([queue[file.name]], newName, { type: file.type });
                            queue[file.name] = myNewFile
                            uploader.files = queue
                        }
                    })

                    // Обработчик удаления
                    itemPreview.find('.delete-link').on('click', function () {
                        delete queue[file.name];
                        uploader.files = queue
                        $(this).parent().remove();
                        limitDisplay();
                    });
                    queue[file.name] = file;
                    uploader.files = queue
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
        uploaderImg('.add_photo-item', '#js-photo-upload', '#uploadImagesList', false, false, 9999);
        $('.btn').on('click', function () {
            var formData = new FormData()
            $.each(uploader.files, function (key, input) {
                console.log(input);
                formData.append('files[]', input)
            });
            $.ajax({
                url: $(this).data('url'),
                method: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        if ($('#documents_ids').val() != '') {
                            let val = $('#documents_ids').val().split(',')
                            let filesIds = res.files.concat(val)
                            $('#documents_ids').val(filesIds.join(","))
                        } else {
                            $('#documents_ids').val(res.files.join(","))
                        }

                    }
                }
            })
        })
    }


    $('#insert-documents').on("click", function() {
        var modal = `<div class="document_modal">
                        <span class="close"><i class="fa fa-times"></i></span>
                    </div>`;
        $('.document_modal').remove()
        $('body')
            .css({ 'overflow': 'hidden' })
            .append(modal)
        $('.close').on('click', function () {
            $('.document_modal').remove()
        })
        Array.prototype.unique = function () {
            var a = [];
            var l = this.length;
        
            for (var i = 0; i < l; i++) {
                for (var j = i + 1; j < l; j++) {
                    if (this[i] === this[j]) {
                        j = ++i;
                    }
                }
                a.push(this[i]);
            }
        
            return a;
        };
        $.ajax({
            url: $(this).data('url'),
            method: 'GET',
            success: function(res){
                var cats = []
                var docs = []
                $('.document_modal').append(res)
                $('#documents_cat ').on('change', function(){
                    var select_button_text = $('#documents_cat option:selected').toArray().map(item => item.value);
                    cats = select_button_text
                    $('#documents_shortcode').val(`[documents cat="${cats.unique().join(",")}" docs="${docs.unique().join(",")}"]`)
                })
                $('.document_list li').on('click', function(){
                    $(this).toggleClass('active')
                    if($(this).hasClass('active')){
                        docs.push(Number($(this).data('id')))
                    }else{
                        docs = docs.filter(doc=>doc !=Number($(this).data('id')))
                    }
                    
                    $('#documents_shortcode').val(`[documents cat="${cats.unique().join(",")}" docs="${docs.unique().join(",")}"]`)
                })
                
            }
        })

    });
    
})