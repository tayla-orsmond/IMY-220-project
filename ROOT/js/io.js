//Tayla Orsmond u21467456
// Language: javascript
// Path: js\scroll.js
// Description: This is the functionality for the intersection observer. 
// This is used to make the feature elements on the spash page translate + fade in when they are scrolled into view.
const options = {
    root: null,
    rootMargin: '-100px',
    threshold: 0.25
}

const callback = entries =>{
    entries.forEach(entry => {
        if(entry.intersectionRatio > 0){
            entry.target.style.transform = 'translateX(0)';
            entry.target.style.opacity = '1';
            io.unobserve(entry.target);
        }
    })
}
const io = new IntersectionObserver(callback, options);

const features = document.querySelectorAll('.feature');
features.forEach((el) => {
  io.observe(el);
})
