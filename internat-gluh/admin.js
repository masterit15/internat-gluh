$(function() {
    // function initMoreImages() {
    //     if ($('input.field').val()) {}
    //     let result = [...$('input.field').val()?.split(',').map(Number)]
    //     console.log(result);
    //     $('.edition-selected').text('Выбрано: ' + result.length);
    //     $('.frame label').on('click', function(e) {
    //         $(this).toggleClass('checked')
    //         if ($(this).hasClass('checked')) {
    //             result.push(Number($(this).find('input:not(:checked)').val()))
    //         } else {
    //             result = result.filter(id => Number(id) !== Number($(this).children('input').val()))
    //         }
    //         result = result.filter(id => Number(id) !== 0)
    //         $('.field').val(result.join(','));
    //         $('.edition-selected').text('Выбрано: ' + result.length);
    //         return false
    //     })

    // }
    // $('.load_more').on('click', function() {
    //     loadMoreImages($(this).data('url'))
    // })
    // let selectcount = $('.load_more').data('selectcount')
    // let ppp = selectcount > 10 ? selectcount : 10; // Post per page
    // let pageNumber = 1;
    // loadMoreImages($('.load_more').data('url'))

    // function loadMoreImages(url) {
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: { action: 'moreimage', pageNumber, ppp, post: $('.load_more').data('post') },
    //         beforeSend: function() {},
    //         success: function(res) {
    //             $('.frame').append(res)
    //         },
    //         complete: function() {
    //             initMoreImages()
    //             pageNumber++
    //         },
    //         error: function(err) {
    //             console.error('success', err);
    //         }
    //     })
    // }

$('.delete').one('click', function(){
    let vId = $(this).data('video-id')
    let videos = $('input[name="videos"]').val() != '' ? $('input[name="videos"]').val().split(',') : []
    console.log('bef', vId);
    videos = videos.filter(vd=>vd != vId)
    console.log('aff', videos);
    $('input[name="videos"]').val(videos.join(','))
    $(`.video[data-video-id="${vId}"]`).remove()
})
    $('.video_input input').on('change', function(){
        let that = $(this)
        let value = $(this).val()
        let coint = $(this).parent('.fields').children().length
        // <iframe src="https://www.youtube.com/embed/${value}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        if(value.length > 0){
            $('.add_video').addClass('enable')
            $('.add_video.enable').one('click', function(){
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
                </div><span class="delete" data-videoId="${value}">Удалить</span></div>`)
                $(that).val('')
                $('.add_video').removeClass('enable')
            })
        }else{
            $('.add_video').removeClass('enable')
        }
        
    })

})
