loginForm();

//Navigation Bar Scroll Effect
window.addEventListener('scroll', () =>{
    let nav = document.getElementById('top-nav');
    let logo = document.getElementById('logo');
    let scrollY = window.scrollY > 0;
    nav.classList.toggle('scrolling-active', scrollY);

    if(scrollY){
        logo.src = "img/Logo - BnW.png";
    }else{
        logo.src = "img/Logo - Purple.png";
    }
    
});

//Toggle Login Form
function loginForm(){
    loginBtn = document.querySelector('#login-btn');
    closeBtn = document.querySelector('#login-close-btn');
    loginCont = document.querySelector('#login-Cont');
    body = document.querySelector('body');

    if(loginBtn){
        loginBtn.addEventListener('click', () => {
            //Scroll back to top
            document.documentElement.scrollTop = 0;
            loginCont.style.display = 'flex';
            body.classList.add('disable-scroll');
        });
    
        closeBtn.addEventListener('click', () => {
            loginCont.style.display = 'none';
            body.classList.remove('disable-scroll');
        })
    }

    
}





