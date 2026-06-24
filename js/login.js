// script.js
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

const character = document.querySelector('.leaning-character');

document.addEventListener('mousemove', (e) => {
    let x = (window.innerWidth / 2 - e.pageX) / 30;
    let y = (window.innerHeight / 2 - e.pageY) / 30;
    
    // Apply a slight tilt based on mouse position
    character.style.transform = `rotate(${x}deg) translateY(${y}px)`;
});