// Const - Begin
const getLHeader = document.querySelector('.left-header')
const getRHeader = document.querySelector('.right-header')
const getBars = getLHeader.querySelector('.bars')
const getModel = document.querySelector('.model')
const getLMenu = document.querySelector('.menu-left')
const getRMenu = document.querySelector('.menu-right')
const header = document.querySelector('.header');
const getMenu = document.querySelector('.menu');
const getEye = document.getElementById('eye');
const getEye2 = document.getElementById('eye-slash');
// Const - End

window.addEventListener("scroll", () => {
    header.classList.toggle('sticky', window.scrollY > 0);
})
// Header - Begin
getLHeader.addEventListener('click', () => {
    getBars.querySelectorAll('.bar').forEach((item, key) => {
        if (key == 1 || key == 3) {
            if (key == 1) {
                item.classList.toggle('OpenLHeadOne')
            }
            if (key == 3) {
                item.classList.toggle('OpenLHeadTwo')
            }
        } else {
            item.classList.toggle('CloseLHead')
        }
    })
    getLMenu.classList.toggle('open')
    modelVisibility(getLMenu)
})
getRHeader.addEventListener('click', () => {
    getRMenu.classList.toggle('open')
    modelVisibility(getRMenu);
})
getModel.addEventListener("click", () => {
    if (!!(getMenu.querySelector('.menu-left.open')) == true) {
        getBars.querySelectorAll('.bar').forEach((item, key) => {
            if (key == 1 || key == 3) {
                if (key == 1) {
                    item.classList.remove('OpenLHeadOne')
                }
                if (key == 3) {
                    item.classList.remove('OpenLHeadTwo')
                }
            } else {
                item.classList.remove('CloseLHead')
            }
        })
    }
    getLMenu.classList.remove('open')
    getRMenu.classList.remove('open')
    getModel.style.visibility = "hidden"
})
// Header - End
function modelVisibility(name) {
    if (getComputedStyle(name).getPropertyValue('visibility') == 'hidden') {
        getModel.style.visibility = "visible"
    } else {
        if (getComputedStyle(getLMenu).getPropertyValue('visibility') == 'hidden' ||
            getComputedStyle(getRMenu).getPropertyValue('visibility') == 'hidden') {
            getModel.style.visibility = 'hidden'
        }
    }
}


