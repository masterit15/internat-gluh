
const ratesList = document.querySelector('.rates_list')
const popularRates = document.querySelector('.popular')
const title = document.querySelectorAll('.title')
window.onload = ()=>{
  $('.owl-carousel').owlCarousel({
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    autoplayHoverPause:true, //false
    loop:true,
    dots: true,
    margin:0,
    nav:false,
    items:1,
    autoplay: true
  })
  $('.menu-item-has-children > a').attr('href', '#group')
  // $('.sub-menu').slideUp()
  $('.menu-item-has-children > a').on('click', function(){
    if(!$(this).parent().hasClass('active')){
      // $('.menu-item-has-children').removeClass('active')
      $(this).parent().addClass('active')
      $(this).parent().children('.sub-menu').show(200)
    }else{
      $(this).parent().removeClass('active')
      $(this).parent().children('.sub-menu').slideUp(200)
    }
  })
  // folder animation
function folderAnimation(){
  $(".js_toggle-folder").on('click', function () {
      let top = 0
      let icon = $(this).find('.fa-folder')
      let iconOpen = $(this).find('.fa-folder-open')
      
      $(".js_toggle-folder").not(this).each(function () {
          $(this).parent().removeClass("active");
          $(this).removeClass("active");
          tl.to($(this).find('.fa-folder'), { opacity: 1, duration: 0.01 })
          tl.to($(this).find('.fa-folder-open'), { opacity: 0, duration: 0.01 })   
          top = $(this).innerHeight()
      });
      $(this).parent().toggleClass("active");
      $(this).toggleClass("active");
      if ($(this).hasClass('active')) {
          $('.folder-content').slideUp(200)
          $('.folder.active').children('.folder-content').slideDown(200)
          // tl.to($(icon), { opacity: 0, duration: 0.01 })
          // tl.to($(iconOpen), { opacity: 1, duration: 0.01 })
          // tl.to($('.folder.active').children('.folder-content').children('.folder-item'), { y: 0, opacity: 1, stagger: 0.1, duration: .2, })
          .then(function (res) {
              let offsetFromScreenTop = $('.folder.active').offset().top - $(window).scrollTop();
              if(offsetFromScreenTop >= 200 && Math.sign(offsetFromScreenTop) != -1){
                  $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
              }else if(Math.sign(offsetFromScreenTop) == -1){
                  $('html, body').animate({ scrollTop: parseInt($('.folder.active').offset().top) - 50 }, 300);
              }
          })
      } else {
        $('.folder-content').slideUp(200)
        $('.folder.active').children('.folder-content').slideUp(200)
          // tl.to($('.folder.active').children('.folder-content').children('.folder-item'), { y: -20, opacity: 0, stagger: 0.1, duration: 0.02, })
          //     .then(function (res) {
                  
          //         tl.to($(icon), { opacity: 1, duration: 0.01 })
          //         tl.to($(iconOpen), { opacity: 0, duration: 0.01 })
                  
          //     })
      }
  });
}
folderAnimation()

$('.mobile_menu_btn').on('click', function(){
  
  if(!$(this).hasClass('active')){
    $(this).addClass('active')
    $('#sidebar').addClass('active')
    $('body').append(`<div class="overlay"></div>`)
    $('.overlay').on('click', function(){
      $('.mobile_menu_btn').removeClass('active')
      $('#sidebar').removeClass('active')
      $(this).remove()
    })
  }else{
    $(this).removeClass('active')
    $('#sidebar').removeClass('active')
    $('.overlay').remove()
  }
})

// bottom nav
var scrollPos = 0;
$(window).on('scroll',function(){
   var st = $(this).scrollTop();
   if (st > scrollPos){
    $('.mobile_nav').removeClass('active')
   } else {
    $('.mobile_nav').addClass('active')
   }
   scrollPos = st;
});
$('.mobile_nav_item.specversion').on('click', function(){
  $(this).toggleClass('active')
  // if($(this).hasClass('active')){
  //   $(this).removeClass('bt_widget-vi-on')
  //   $(this).addClass('vi-close')
  //   $(this).find('i.fa').removeClass('fa-eye')
  //   $(this).find('i.fa').addClass('fa-low-vision')
  // }else{
  //   $(this).removeClass('vi-close')
  //   $(this).addClass('bt_widget-vi-on')
  //   $(this).find('i.fa').removeClass('fa-low-vision')
  //   $(this).find('i.fa').addClass('fa-eye')
  // }
})
$('.gallery_list_wrap').magnificPopup({
  delegate: 'a',
  type: 'image',
  tLoading: 'Loading image #%curr%...',
  mainClass: 'mfp-img-mobile',
  gallery: {
    enabled: true,
    navigateByImgClick: true,
    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
  },
  image: {
    tError: '<a href="%url%">Изображение #%curr%</a> не удалось загрузить.',
    titleSrc: function(item) {
      return item.el.attr('title') + '<small>ГБОУ "КРОЦ"</small>';
    }
  },
  callbacks: {
    elementParse: function(item) {
      if($(item.el).hasClass('popup-youtube')) {
          item.type = 'iframe';
      } else {
          item.type = 'image';
      }
    }
  },
});
}



// форматируем номера телефонов на всем сайте
function phoneFormat(){
  let a = [...document.getElementsByTagName("a")]
  a.forEach(link => {
    if (link.getAttribute("href").indexOf("tel:") !== -1) {
      let phone = link.getAttribute("href").split(':')[1]
      let phoneLength = phone.length
      let tt = phone.split('')
      if(phoneLength == 11){
        tt.splice(1,"", " (")
        tt.splice(5,"", ") ")
        tt.splice(9,"", "-")
        tt.splice(12,"", "-")
      } else if(phoneLength == 12){
          tt.splice(2,"", " (")
          tt.splice(6,"", ") ")
          tt.splice(10,"", "-")
          tt.splice(13,"", "-")
      }else if(phoneLength == 13){
          tt.splice(3,"", " (")
          tt.splice(7,"", ") ")
          tt.splice(11,"", "-")
          tt.splice(14,"", "-")
      }
      link.classList.add('vadik_kaprizny_designer')
      link.innerHTML = tt.join('')
    }
  });
}
phoneFormat()

// стилизуем заголовки по дизайну

title.forEach(tl=>{
  let wordsArr = tl.innerHTML.split(' ')
  let span = `<span>${wordsArr[wordsArr.length - 1]}</span>`
  wordsArr.pop()
  wordsArr.push(span)
  tl.innerHTML = wordsArr.join(' ')
})

//  изменение для карточки популярного тарифа


// анимация стрелок скорости тарифа 
function animateSpeed(){
  let path = document.querySelectorAll('.speed_arrow')
  path.forEach((p, i)=>{
    let speed = p.closest('.rates_list_item').dataset.speed
    let step = 800
    p.style.transform = `rotate(0deg)`
    setTimeout(()=>{
      p.style.transform = `rotate(240deg)`
    },300)
    setTimeout(()=>{
      p.style.transform = `rotate(${speed}deg)`
    },step)
    setTimeout(()=>{
      p.classList.add('ag-speedometer_needle')
    },1200)
    step += 800
  })
}

// запуск при прокрутке до тарифных планов анимация стрелок скорости тарифа 
window.addEventListener('scroll', ()=>{
  if(elementInViewport(ratesList)){
    animateSpeed()
  }
})
// запуск при загрузке анимация стрелок скорости тарифа 
window.addEventListener('load', ()=>{
  if(elementInViewport(ratesList)){
    animateSpeed()
  }
})
// отслеживание в зоне видимости ли елемент
function elementInViewport(el) {
  if(!el) return
  var top = el.offsetTop
  var left = el.offsetLeft
  var width = el.offsetWidth
  var height = el.offsetHeight
  while(el.offsetParent) {
    el = el.offsetParent
    top += el.offsetTop
    left += el.offsetLeft
  }
  return (
    top >= window.pageYOffset &&
    left >= window.pageXOffset &&
    (top + height) <= (window.pageYOffset + window.innerHeight) &&
    (left + width) <= (window.pageXOffset + window.innerWidth)
  );
}
// подкрузка формы заявки на подключение
function getForm(url){
  return new Promise((resolve, reject)=>{
    fetch(url).then(function (response) {
      return response.text()
    }).then(function (html) {
      let offer_wrap = document.querySelector('.offer_wrap')
      tl.to(offer_wrap, {opacity: 0, duration: .3}).then(res=>{
        offer_wrap.style.display = 'none'
        let offer = document.querySelector('.offer')
        offer.insertAdjacentHTML('beforeend', html)
        let form = offer.querySelector('.application')
        tl.to(form, {opacity: 1, translateY: '0px', duration: .2})
        let rateItems = form.querySelectorAll('.rates_dd_item')
        let rateInput = form.querySelector('#rate')
        form.querySelector('#rate').onfocus = function() {
          tl.to('.rates_dd_list', {opacity: 1, height: 'auto', duration: .2})
        };
        rateInput.addEventListener('click', (e)=>{
          
        })
        document.addEventListener('click', (e)=>{
          let menu = form.querySelector('.rates_dd_list')
          if(!menu.contains(e.target) && !form.querySelector('#rate').contains(e.target)){
            tl.to('.rates_dd_list', {opacity: 0, height: '0px', duration: .2})
          }
        })

        rateItems.forEach(rateItem=>{
          rateItem.addEventListener('click', ()=>{
            tl.to('.rates_dd_list', {opacity: 0, height: '0px', duration: .2})
            form.querySelector('#rate').value = rateItem.innerHTML
            
          })
        })
        
        let phone = IMask(
        form.querySelector('#phone'), {
          mask: '+{7} (000) 000-00-00',
          lazy: false,  // make placeholder always visible
          placeholderChar: '0'     // defaults to '_'
        });

        resolve('form_done')
        form.querySelector('.send').addEventListener('click', (event)=>{
          event.preventDefault()
          let fio = form.querySelector('#fio').value
          let address = form.querySelector('#address').value
          let phone = form.querySelector('#phone').value
          let data = {fio,address,phone}
          
          fetch('/ajax.html',{
            method: 'POST',
            headers: {
              'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
          })
          .then(function (response) {
            return response.json()
          })
          .then(res=>{
            console.log(res);
          })
        })
      })
    }).catch(function (err) {
      console.warn('Какя то ошибка.', err)
    });
  })
}
document.querySelector('.offer_btn')?.addEventListener('click', (e)=>{
  getForm(e.target.dataset.action)
})

// плавная прокрутка до элемента
function smoothScroll(target, speed) {
  return new Promise((resolve, reject)=>{
    var scrollContainer = target;
    do { //find scroll container
        scrollContainer = scrollContainer.parentNode;
        if (!scrollContainer) return;
        scrollContainer.scrollTop += 1;
    } while (scrollContainer.scrollTop == 0);

    var targetY = 0;
    do { //find the top of target relatively to the container
        if (target == scrollContainer) break;
        targetY += target.offsetTop;
    } while (target = target.offsetParent);

    scroll = function(c, a, b, i) {
        i++; if (i > speed) return;
        c.scrollTop = a + (b - a) / speed * i;
        setTimeout(function(){ scroll(c, a, b, i); }, 15);
        if (i == speed){
          resolve('done')
        }
    }
    // start scrolling
    scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
  })
}


let accardeonItems = document.querySelectorAll('.accardeon_list_item')
accardeonItems.forEach(accardeonItem=>{
  accardeonItem.addEventListener('click', (e)=>{
    let content = e.target.parentElement.querySelector('.accardeon_list_item_content')
    if(e.target.classList.contains('active')){
      tl.to(content, {opacity: 0, height: '0', duration: .2})
      e.target.classList.remove('active')
    }else{
      e.target.classList.add('active')
      tl.to(content, {opacity: 1, height: 'auto', duration: .2})
    }
  })
})