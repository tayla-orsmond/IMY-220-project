//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\scroll.js
// Description: This is the functionality for the horizontal scrolling divs.
$(() => {
    $('.scroller').on('scroll', (event) => {
        event.preventDefault();
        $('.scroller').scrollLeft += event.deltaY * 5;
    });
});
