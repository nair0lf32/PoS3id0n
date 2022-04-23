window.onload = function () {

    const eye = document.querySelector('.eye-wrap');
    window.addEventListener('mousemove', (event) => {
        const x = -(window.innerWidth / 2 - event.pageX) / 35;
        const y = -(window.innerHeight / 2 - event.pageY) / 35;
        eye.style.transform = `rotate(-45deg) translateY(${y}px) translateX(${x}px)`;
    });

    const light = document.querySelector('.light');
    window.addEventListener('mousemove', (event) => {
        const x2 = -(window.innerWidth / 2 - event.pageX) / 60;
        const y2 = -(window.innerHeight / 2 - event.pageY) / 60;
        light.style.transform = `rotate(-45deg) translateY(${y2}px) translateX(${x2}px)`;
    });

};