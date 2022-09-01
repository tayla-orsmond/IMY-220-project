//Tayla Orsmond u21467456
// Language: javascript
// Path: js\scroll.js
// Description: This is the functionality for the horizontal scrolling divs.

const scroller = document.querySelector('.scroller');
scroller.addEventListener('wheel', function(event) {
    event.preventDefault();
    scroller.scrollLeft += event.deltaY * 5;
});