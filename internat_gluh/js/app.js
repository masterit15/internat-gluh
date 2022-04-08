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
    $('.menu-item-has-children > a').on('click', function () {
        if (!$(this).parent().hasClass('active')) {
            $(this).parent().addClass('active')
            $(this).parent().children('.sub-menu').show(200)
        } else {
            $(this).parent().removeClass('active')
            $(this).parent().children('.sub-menu').slideUp(200)
        }
    })
    // folder animation
    $(".js_toggle-folder").on('click', function () {
        let top = 0
        let icon = $(this).find('.fa-folder')
        let iconOpen = $(this).find('.fa-folder-open')
        $(".js_toggle-folder").not(this).each(function () {
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

    $('.mobile_menu_btn').on('click', function () {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active')
            $('#sidebar').addClass('active')
            $('body').append(`<div class="overlay"></div>`)
            $('.overlay').on('click', function () {
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
    $('.mobile_nav').addClass('active')
    $(window).on('scroll', function () {
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
            titleSrc: function (item) {
                return item.el.attr('title') + '<small>ГБОУ "КРОЦ"</small>';
            }
        },
        callbacks: {
            elementParse: function (item) {
                if ($(item.el).hasClass('popup-youtube')) {
                    item.type = 'iframe';
                } else {
                    item.type = 'image';
                }
            }
        },
    });
    $('.add').on('click', function () {
        $('.application').addClass('active')
        $('body').css({ 'position': 'fixed' })
    })
    $('.search').on('click', function () {
        $('.search_popup').addClass('active')
        $('body').css({ 'position': 'fixed' })
    })
    $('.close').on('click', function () {
        $('.application').removeClass('active')
        $('.search_popup').removeClass('active')
        $('body').css({ 'position': 'relative' })
    })
    
    // Подсказка поля адрес
    $('#address').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "ADDRESS",
        onSelect: function (suggestion) {
            // console.log(suggestion.data)
        }
    });
    // Подсказка поля е-почта
    $('#email').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "EMAIL",
        onSelect: function (res) {

        }
    });
    // Подсказка поля ФИО имя
    $('#fio').suggestions({
        token: "fd6932ba741e45fb66a5724df848eb4a15478eda",
        type: "NAME",
        onSelect: function (res) {
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
    $('.useful_link_list_item_lnk').each(function () {
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

    $('input').on('change', function () {
        $(this).val().length > 0 ? $(this).parent().find('label').addClass('active') : $(this).parent().find('label').removeClass('active')
    })
    $('#f_name').on('change', function () {
        documentProxy.name = $(this).val()
    })
    $('.f_cat_list').on('change', function () {
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
            beforeSend: function () {},
            complete: function () {},
            success: function (res) {
                $('.documents_wrap').html(res)
            },
            error: function (err) {
                console.error(err);
            }
        });
    }
    let specialistSheduleImg = ''
    function getFormEl(el, param, reset = false) {
        $.ajax({
            type: "POST",
            url: $(el).data('action'),
            data: param,
            beforeSend: function () {
                $('.loader').css({"display":"flex"})
            },
            complete: function () {},
            success: function (res) {
                $('.specialists_shedule').html(res)
                $('#specialists').on('change', function () {
                    let val = $(this).val()
                    if(val !== '#'){
                        $(this).addClass('valid')
                    }else{
                        $(this).removeClass('valid')
                    }
                    getFormEl($(this), { specialist: val })
                })
                var specialistsData = $('textarea#specialists_field').length > 0 && $('textarea#specialists_field').val().length > 0 ? JSON.parse($('textarea#specialists_field').val()) : []
                var application_specialist_shedule = $('textarea#application_specialist_shedule').length > 0 && $('textarea#application_specialist_shedule').val().length > 0 ?JSON.parse($('textarea#application_specialist_shedule').val()) : []
                var specialists_shedule_book = application_specialist_shedule
                var specialistLock = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z"/></svg>`
                var specialistCheck = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zm323-128.4l-27.8-28.1c-4.6-4.7-12.1-4.7-16.8-.1l-104.8 104-45.5-45.8c-4.6-4.7-12.1-4.7-16.8-.1l-28.1 27.9c-4.7 4.6-4.7 12.1-.1 16.8l81.7 82.3c4.6 4.7 12.1 4.7 16.8.1l141.3-140.2c4.6-4.7 4.7-12.2.1-16.8z"/></svg>`
                var specialistTime = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M496 224c-79.6 0-144 64.4-144 144s64.4 144 144 144 144-64.4 144-144-64.4-144-144-144zm64 150.3c0 5.3-4.4 9.7-9.7 9.7h-60.6c-5.3 0-9.7-4.4-9.7-9.7v-76.6c0-5.3 4.4-9.7 9.7-9.7h12.6c5.3 0 9.7 4.4 9.7 9.7V352h38.3c5.3 0 9.7 4.4 9.7 9.7v12.6zM320 368c0-27.8 6.7-54.1 18.2-77.5-8-1.5-16.2-2.5-24.6-2.5h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h347.1c-45.3-31.9-75.1-84.5-75.1-144zm-96-112c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128z"/></svg>`
                if($('textarea#specialists_field').length > 0){
                    specialistsData.forEach(ss => {
                        const td = $(`.day[data-weekday="${ss.weekday}"][data-time="${ss.time}"]`)
                        if(ss.book){
                            $(td)
                            .addClass('active')
                            .addClass('book')
                            .attr('data-book', true)
                            .html(`${specialistLock}${$(td).data('time')}`)
                        }else{
                            $(td)
                            .addClass('active')
                            .html(`${specialistTime}${$(td).data('time')}`)
                        }
                        
                    });
                }
                if ($('textarea#application_specialist_shedule').length > 0) {
                    application_specialist_shedule.forEach(ss => {
                        const td = $(`.day[data-id="${ss.id}"]`)
                        let weekdayText = `${$(`.weekday[data-weekday="${$(`.day[data-id="${ss.id}"]`).data('weekday')}"]`).text()}`;
                        let time = $(`.day[data-id="${ss.id}"]`).data('time');
                        if(ss.book){
                            $(`.day[data-id="${ss.id}"]`)
                            .addClass('active')
                            .addClass('book')
                            .attr('data-book', true)
                            .html(`${specialistLock}${time}`)
                        }else{
                            $(`.day[data-id="${ss.id}"]`)
                            .addClass('active')
                            .addClass('check')
                            // .attr('data-book', true)
                            .html(`${specialistCheck}${time}`)
                        }
                        
                    });
                }
                $('.day.active').on('click', function () {
                    $('.loader').css({"display":"flex"})
                    if (!$(this).data('book')) {
                        $(this).toggleClass('check')
                        let id = $(this).data('id')
                        let time = $(this).data('time')
                        let book = $(this).data('book')
                        let weekday = $(this).data('weekday')
                        let weekdayText = `${$(`.weekday[data-weekday="${weekday}"]`).text()}`
                        let weekdatefull = $(`.weekday[data-weekday="${weekday}"]`).data('weekdatefull')
                        if ($(this).hasClass('check')) {
                            $(this).html(`${specialistCheck}${time}`)
                            specialists_shedule_book.push({id, book, time, weekdatefull})
                            $('#application_specialist_shedule').val(JSON.stringify(specialists_shedule_book))
                        } else {
                            $(this).html(`${specialistTime}${time}`)
                            specialists_shedule_book = specialists_shedule_book.filter(sh => sh.id != $(this).data('id'))
                            $('#application_specialist_shedule').val(JSON.stringify(specialists_shedule_book))
                        }
                        html2canvas(document.querySelector(".shedule"), {logging: false}).then(function(canvas) {
                            var ctx = canvas.getContext('2d');
                            ctx.fillRect(50,50,600,400);
                            specialistSheduleImg = canvas.toDataURL()
                            $('.loader').fadeOut(200)
                        });
                    }
                })
                $('.loader').fadeOut(200)
            },
            error: function (err) {
                // mainToast(5000, "error", 'Ошибка загрузки!', err)
                console.error(err);
            }
        });
    }
    $('#specialists_cat').on('change', function () {
        let val = $(this).val()
        $.ajax({
            type: "POST",
            url: $(this).data('action'),
            data: { specialistscat: val },
            beforeSend: function () {
                $('.loader').css({"display":"flex"})
            },
            complete: function () {},
            success: function (res) {
                $('#specialists_select').html(res)
                $('.loader').fadeOut(200)
                $('#specialists').on('change', function () {
                    let val = $(this).val()
                    if(val !== '#'){
                        $(this).addClass('valid')
                    }else{
                        $(this).removeClass('valid')
                    }
                    getFormEl($(this), { specialist: val })
                })
            },
            error: function (err) {
                // mainToast(5000, "error", 'Ошибка загрузки!', err)
                console.error(err);
            }
        });
    })
    $('#specialists').on('change', function () {
        let val = $(this).val()
        $('.shedule').remove()
        getFormEl($(this), { specialist: val })
    })
    $('#specialists, #specialists_cat').on('change', function () {
        let val = $(this).val()
        if(val !== '#'){
            $(this).addClass('valid')
            $('.specialists_shedule').html('')
        }else{
            $(this).removeClass('valid')
        }
        
    })
    // $("#phone").mask("+7 (999) 999-99-99", {
    //     placeholder: "+7 (999) 999-99-99",
    //     onInvalid: function(val, e, f, invalid, options){
    //         var error = invalid[0];
    //         console.log("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
    //     }
    // });
    let phone = IMask(
        document.querySelector('#phone'), {
        mask: '+7 000 000-00-00',
        lazy: true,
        placeholderChar: '0',
        
        onchange: function(err){
            console.log(err);
        }
      });
    $('.application').on('submit', function(e){
        e.preventDefault()
        let specialist = $(e.target).find('#specialists').val()
        let specialistsCat = $(e.target).find('#specialists_cat').val()
        let specialistsServiceType = $(e.target).find('#service_type').val()
        let specialistEmail = $(e.target).find('#specialists_email').val() ?? ''
        let specialistShedule = $(e.target).find('#application_specialist_shedule').val()
        let userFio = $(e.target).find('#fio').val()
        let userAge = $(e.target).find('#age').val()
        let userText = $(e.target).find('#text').val()
        let userEmail = $(e.target).find('#email').val()
        let userPhone = $(e.target).find('#phone').val()
        let data = {
            specialist,
            specialistsCat,
            specialistEmail,
            specialistShedule,
            specialistSheduleImg,
            specialistsServiceType,
            userFio,
            userAge,
            userText,
            userEmail,
            userPhone,
        }
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: data,
            beforeSend: function () {
                $('.loader').css({"display":"flex"})
            },
            complete: function () {
                // NProgress.done();
            },
            success: function (res) {
                let result = JSON.parse(res)
                console.log(result);
                $('.application_wrap').html(result.message)
                $('.loader').fadeOut(200)
            },
            error: function (err) {
                // mainToast(5000, "error", 'Ошибка загрузки!', err)
                console.error(err);
            }
        });
    
    })

}