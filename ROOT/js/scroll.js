//Tayla Orsmond u21467456
// Language: javascript, jquery
// Path: js\scroll.js
// Description: This is the functionality for the horizontal scrolling divs.
$(() => {
    $('.scroller').on('mousewheel', function(event) {
        //console.log(event.originalEvent.deltaY);
        $(this).scrollLeft(event.originalEvent.deltaY * 8 + $(this).scrollLeft());
        event.preventDefault();
    });
});
