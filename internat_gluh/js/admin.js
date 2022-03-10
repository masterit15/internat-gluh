$(function() {
    $('.delete_video').one('click', function() {
        let vId = $(this).data('video-id')
        let videos = $('input[name="videos"]').val() != '' ? $('input[name="videos"]').val().split(',') : []
        console.log('bef', vId);
        videos = videos.filter(vd => vd != vId)
        console.log('aff', videos);
        $('input[name="videos"]').val(videos.join(','))
        $(`.video[data-video-id="${vId}"]`).remove()
    })
    $('.video_input input').on('change', function() {
        let that = $(this)
        let value = $(this).val()
        let coint = $(this).parent('.fields').children().length
            // <iframe src="https://www.youtube.com/embed/${value}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        if (value.length > 0) {
            $('.add_video').addClass('enable')
            $('.add_video.enable').one('click', function() {
                let videos = $('input[name="videos"]').val() != '' ? $('input[name="videos"]').val().split(',') : []
                videos.push(value)
                console.log(videos.join(','));
                $('input[name="videos"]').val(videos.join(','))
                $('.two_colimn').append(`<div class="video">
                <div class="video_input">
                <input type="text" value="${value}" name="video-${coint++}"/>
                </div>
                <div class="video_frame">
                <img src="https://img.youtube.com/vi/${value}/0.jpg"/>
                </div><span class="delete_video" data-videoId="${value}">Удалить</span></div>`)
                $(that).val('')
                $('.add_video').removeClass('enable')
            })
        } else {
            $('.add_video').removeClass('enable')
        }

    })
    Array.prototype.unique = function() {
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
    // отслеживаем изменения параметров фильтра
    var uploaderParam = { files: [] }
    var uploader = new Proxy(uploaderParam, {
        get: function(target, prop) {
            // console.log({
            // 	type: "get",
            // 	target,
            // 	prop
            // });
            return Reflect.get(target, prop);
        },
        set: function(target, prop, value) {
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
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(addButton).css({})
                }
            )
            $(addButton).on(
                'dragenter',
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            )
            $(addButton).on(
                'drop',
                function(e) {
                    if (e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {
                        e.preventDefault();
                        e.stopPropagation();
                        prepreview(e.originalEvent.dataTransfer.files)
                    }

                }
            )

            $(addButton).on('click', function() {
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
                $(addInput).on('change', function() {
                    var total = 0;
                    for (var i = 0; i < this.files.length; i++) {
                        total = total + this.files[i].size;
                    }
                    return total;
                });
            }
            limitSize();
            $(addInput).on('change', function() {
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
                reader.addEventListener('load', function(event) {
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
                    $(input).on('change', function() {
                        var newName = `${$(this).val()}.${fileType}`
                        if (oldName !== newName) {
                            var myNewFile = new File([queue[file.name]], newName, { type: file.type });
                            queue[file.name] = myNewFile
                            uploader.files = queue
                        }
                    })

                    // Обработчик удаления
                    itemPreview.find('.delete-link').on('click', function() {
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
        $('.btn').on('click', function() {
            var formData = new FormData()
            $.each(uploader.files, function(key, input) {
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
                success: function(res) {
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
        $('.close').on('click', function() {
            $('.document_modal').remove()
        })
        $('.document_modal').on('click', function(e) {
            if ($(e.target).hasClass('document_modal')) $('.document_modal').remove()
        })
        $.ajax({
            url: $(this).data('url'),
            method: 'GET',
            success: function(res) {
                var cats = []
                var docs = []
                var files = []
                var shortcode = `[documents]`
                $('.document_modal').append(res)
                    // folder animation
                $(".js_toggle-folder").on('click', function() {
                    let top = 0
                    let icon = $(this).find('.fa-folder')
                    let iconOpen = $(this).find('.fa-folder-open')
                    $(".js_toggle-folder").not(this).each(function() {
                        $(this).parent().removeClass("active");
                        $(this).removeClass("active");
                        $(this).find('.fa-folder').css({ 'opacity': 0 })
                        $(this).find('.fa-folder-open').css({ 'opacity': 1 })
                        top = $(this).innerHeight()
                    });
                    $(this).parent().toggleClass("active");
                    $(this).toggleClass("active");
                    if ($(this).hasClass('active')) {
                        $('.folder-content').slideUp(200)
                        $('.folder.active').children('.folder-content').slideDown(200)
                        $(icon).css({ 'opacity': 0 })
                        $(iconOpen).css({ 'opacity': 1 })
                        let offsetFromScreenTop = $('.folder.active').offset().top - $(window).scrollTop();
                        if (offsetFromScreenTop >= 200 && Math.sign(offsetFromScreenTop) != -1) {
                            $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
                        } else if (Math.sign(offsetFromScreenTop) == -1) {
                            $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
                        }
                    } else {
                        $('.folder-content').slideUp(200)
                        $('.folder.active').children('.folder-content').slideUp(200)
                        $(icon).css({ 'opacity': 1 })
                        $(iconOpen).css({ 'opacity': 0 })
                    }
                });
                $('.folder .checked').on('click', function() {
                    $(this).toggleClass('active')
                    if ($(this).hasClass('active')) {
                        docs.push(Number($(this).data('id')))
                    } else {
                        docs = docs.filter(doc => doc != Number($(this).data('id')))
                    }
                    shortcode = `[documents docs="${docs.unique().join(",")}" files="${files.unique().join(",")}"]`
                })
                $('.doc_item, .folder-item').on('click', function() {
                    $(this).toggleClass('active')
                    if ($(this).hasClass('active')) {
                        files.push(Number($(this).data('id')))
                    } else {
                        files = files.filter(file => file != Number($(this).data('id')))
                    }
                    shortcode = `[documents docs="${docs.unique().join(",")}" files="${files.unique().join(",")}"]`
                })
                $('.add_shortcode').on('click', function() {
                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
                })
                $('input').on('change', function() {
                    $(this).val().length > 0 ? $(this).parent().find('label').addClass('active') : $(this).parent().find('label').removeClass('active')
                })
                $('#f_name').on('change', function() {
                    documentProxy.name = $(this).val()
                })
                $('.f_cat_list').on('change', function() {
                    if ($(this).val() != '#') {
                        documentProxy.cat = $(this).val()
                    } else {
                        documentProxy.cat = ''
                    }

                })
                let documentFilterParams = {
                        cat: '',
                        name: '',
                        dateTo: '',
                        dateFrom: ''
                    }
                    // отслеживаем изменения параметров фильтра
                const documentProxy = new Proxy(documentFilterParams, {
                    get: function(target, prop) {
                        // console.log({
                        // 	type: "get",
                        // 	target,
                        // 	prop
                        // });
                        return Reflect.get(target, prop);
                    },
                    set: function(target, prop, value) {
                        // console.log({
                        //   type: "set",
                        //   target,
                        //   prop,
                        //   value
                        // });
                        setTimeout(() => {
                            GetFilter(target)
                        }, 10)
                        return Reflect.set(target, prop, value);
                    }
                });
                new AirDatepicker('#f_date', {
                    range: true,
                    // timepicker: true,
                    multipleDatesSeparator: ' - ',
                    onSelect: ({ date, formattedDate, datepicker }) => {
                        $('#f_date').val().length > 0 ? $('#f_date').parent().find('label').addClass('active') : $('#f_date').parent().find('label').removeClass('active')
                        if (formattedDate.length > 1) {
                            documentProxy.dateFrom = formattedDate[0]
                            documentProxy.dateTo = formattedDate[1]

                        } else {
                            documentProxy.dateFrom = formattedDate[0]
                        }
                    }
                })

                function GetFilter(param) {
                    $.ajax({
                        type: "POST",
                        url: $('#filter').data('url'),
                        data: param,
                        beforeSend: function() {
                            // NProgress.start();
                        },
                        complete: function() {
                            // NProgress.done();
                        },
                        success: function(res) {
                            $('.documents_wrap').html(res)
                        },
                        error: function(err) {
                            // mainToast(5000, "error", 'Ошибка загрузки!', err)
                            console.error(err);
                        }
                    });
                }
            }
        })

    });

    $('.file_edit').on('click', function() {
        var parent = $(this).parent().parent('li')
        $(parent).find('.file_name input').prop('disabled', false)
    })

})