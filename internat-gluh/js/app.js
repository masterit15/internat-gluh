
import gsap from "gsap"
import IMask from 'imask'
const tl = gsap.timeline()
const ratesList = document.querySelector('.rates_list')
const popularRates = document.querySelector('.popular')
const title = document.querySelectorAll('.title')

import ymaps from 'ymaps';
if(document.querySelector('#y_maps')){
  var myMap;
  const poligons = [...JSON.parse(document.querySelector('#y_maps').dataset.poligons)]
  var Poligon = [
    {
      id: 1,
      name: "Карта покрытия сети",
      color: "#84d570",
      coords: [poligons]
    },
  ]
  ymaps
  .load('https://api-maps.yandex.ru/2.1/?apikey=256e028a-94b5-496f-b948-394772dc151a&lang=ru_RU')
  .then(maps => {
    myMap = new maps.Map('y_maps', {
      center: [42.225084,43.970862],
      zoom: 13,
      controls: []
    });
    Poligon.forEach(p => {
      let polygon = new maps.Polygon(p.coords
        , {
          hintContent: p.name
        }, {
        fillColor: p.color,
        fillOpacity: 0.7,
        strokeColor: p.color,
        // Делаем полигон прозрачным для событий карты.
        interactivityModel: 'default#transparent',
        strokeWidth: 2,
        strokeOpacity: 1,
        // opacity: 1
      });
      // 3. Добавляем полигон на карту
      myMap.geoObjects.add(polygon);
      myMap.setBounds(polygon.geometry.getBounds());
    })
    
  })
  .catch(error => console.log('Ошибка, не могу подгрузить карту', error));
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

if(popularRates){
  let popularText = `<span class="popular_text">
                      <svg width="24" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.76l-7.053 3.948 1.575-7.928L.587 8.292l8.027-.952L12 0l3.386 7.34 8.027.952-5.935 5.488 1.575 7.928L12 17.76z" fill="#F4AE86"/></svg>
                      самый популярный
                    </span>`
  popularRates.insertAdjacentHTML('afterbegin', popularText)
}

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

// отрабатываем клик при выборе тарифа
let ratesBtns = document.querySelectorAll('.rates_list_item_btn')
ratesBtns.forEach(ratesBtn=>{
  ratesBtn.addEventListener('click', (e)=>{
      smoothScroll(document.querySelector('.offer'), 20).then(res=>{
        getForm(e.target.dataset.action).then(form=>{
          let items = [...document.querySelectorAll('.rates_dd_item')]
          let item = items.filter(item=>item.dataset.rate == e.target.dataset.rate)
          document.querySelector('#rate').value = item[0].innerHTML
        })
      })
  })
})

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