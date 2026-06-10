window.addEventListener('scroll',function(){
    const header = document.querySelector('header');
    header.classList.toggle("sticky", scrollY > 0);
});