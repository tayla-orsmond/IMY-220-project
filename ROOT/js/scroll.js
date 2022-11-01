//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\scroll.js
// Description: This is the functionality for the horizontal scrolling divs.
$(() => {
    $('.scroller').on('mousewheel', function (event) {
        //check if the container is overflowing
        if (this.scrollWidth > this.clientWidth) {
            $(this).scrollLeft(event.originalEvent.deltaY * 8 + $(this).scrollLeft());
            event.preventDefault();
        }
    });
});
