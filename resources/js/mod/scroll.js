window.addEventListener('scroll',function(){
    const header = document.querySelector('nav');
    header.classList.toggle("sticky", scrollY > 0);
});