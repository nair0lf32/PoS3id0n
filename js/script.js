window.onload = function () {


    // for further animations
    const eye = document.querySelector('.eye-wrap');
    window.addEventListener('mousemove', (event) => {
        const x = -(window.innerWidth / 2 - event.pageX) / 25;
        const y = -(window.innerHeight / 2 - event.pageY) / 25;
        eye.style.transform = `rotate(-45deg) translateY(${y}px) translateX(${x}px)`;
    });

    const light = document.querySelector('.light');
    window.addEventListener('mousemove', (event) => {
        const x2 = -(window.innerWidth / 2 - event.pageX) / 60;
        const y2 = -(window.innerHeight / 2 - event.pageY) / 60;
        light.style.transform = `rotate(-45deg) translateY(${y2}px) translateX(${x2}px)`;
    });

};

