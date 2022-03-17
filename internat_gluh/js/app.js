const ratesList = document.querySelector('.rates_list')
const popularRates = document.querySelector('.popular')
const title = document.querySelectorAll('.title')
window.onload = () => {
    $('.owl-carousel').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoplayHoverPause: true, //false
        loop: true,
        dots: true,
        margin: 0,
        nav: false,
        items: 1,
        autoplay: true
    })
    $('.menu-item-has-children > a').attr('href', '#group')
    $('.menu-item-has-children > a').on('click', function() {
            if (!$(this).parent().hasClass('active')) {
                $(this).parent().addClass('active')
                $(this).parent().children('.sub-menu').show(200)
            } else {
                $(this).parent().removeClass('active')
                $(this).parent().children('.sub-menu').slideUp(200)
            }
        })
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

    $('.mobile_menu_btn').on('click', function() {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active')
                $('#sidebar').addClass('active')
                $('body').append(`<div class="overlay"></div>`)
                $('.overlay').on('click', function() {
                    $('.mobile_menu_btn').removeClass('active')
                    $('#sidebar').removeClass('active')
                    $(this).remove()
                })
            } else {
                $(this).removeClass('active')
                $('#sidebar').removeClass('active')
                $('.overlay').remove()
            }
        })
        // bottom nav
    var scrollPos = 0;
    $(window).on('scroll', function() {
        var st = $(this).scrollTop();
        if (st > scrollPos) {
            $('.mobile_nav').removeClass('active')
        } else {
            $('.mobile_nav').addClass('active')
        }
        scrollPos = st;
    });
    $('.gallery_list_wrap').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Загрузка изображения #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">Изображение #%curr%</a> не удалось загрузить.',
            titleSrc: function(item) {
                return item.el.attr('title') + '<small>ГБОУ "КРОЦ"</small>';
            }
        },
        callbacks: {
            elementParse: function(item) {
                if ($(item.el).hasClass('popup-youtube')) {
                    item.type = 'iframe';
                } else {
                    item.type = 'image';
                }
            }
        },
    });
    $('.add').on('click', function() {
        $('.application').addClass('active')
        $('body').css({ 'position': 'fixed' })
    })
    $('.close').on('click', function() {
        $('.application').removeClass('active')
        $('body').css({ 'position': 'relative' })
    })

    // Подсказка поля адрес
    $('#address').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "ADDRESS",
        onSelect: function(suggestion) {
            // console.log(suggestion.data)
        }
    });
    // Подсказка поля е-почта
    $('#email').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "EMAIL",
        onSelect: function(res) {

        }
    });
    // Подсказка поля ФИО имя
    $('#fio').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "NAME",
        onSelect: function(res) {
            console.log(res);
        }
    });
    // форматируем номера телефонов на всем сайте
    function phoneFormat() {
        let a = [...document.getElementsByTagName("a")]
        a.forEach(link => {
            if (link.getAttribute("href").indexOf("tel:") !== -1) {
                let phone = link.getAttribute("href").split(':')[1]
                let phoneLength = phone.length
                let tt = phone.split('')
                if (phoneLength == 11) {
                    tt.splice(1, "", " (")
                    tt.splice(5, "", ") ")
                    tt.splice(9, "", "-")
                    tt.splice(12, "", "-")
                } else if (phoneLength == 12) {
                    tt.splice(2, "", " (")
                    tt.splice(6, "", ") ")
                    tt.splice(10, "", "-")
                    tt.splice(13, "", "-")
                } else if (phoneLength == 13) {
                    tt.splice(3, "", " (")
                    tt.splice(7, "", ") ")
                    tt.splice(11, "", "-")
                    tt.splice(14, "", "-")
                }
                link.classList.add('vadik_kaprizny_designer')
                link.innerHTML = tt.join('')
            }
        });
    }
    phoneFormat()
    $('.useful_link_list_item_lnk').each(function() {
        var str = $(this).text()
        if (str.includes('http://')) {
            str = str.replace('http://', '');
            str = str.slice(0, -1)
        } else if (str.includes('https://')) {
            str = str.replace('https://', '');
            str = str.slice(0, -1)
        }
        str = str.replace(/\s/g, '')
        $(this).text(str)
    })

    // стилизуем заголовки по дизайну

    title.forEach(tl => {
        let wordsArr = tl.innerHTML.split(' ')
        let span = `<span>${wordsArr[wordsArr.length - 1]}</span>`
        wordsArr.pop()
        wordsArr.push(span)
        tl.innerHTML = wordsArr.join(' ')
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