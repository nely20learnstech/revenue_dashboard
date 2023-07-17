const modal = document.querySelector('#modal');
const openModal = document.querySelector('.open-button');
const closeModal = document.querySelector('.close-button');

const button_submit = document.querySelector('.search-button');

openModal.addEventListener('click', () => {
    // show dialog 
    // modal.show();

    // Shows front of everything, comes front of everything and on focus.
    modal.showModal();
});

// When we push escape on the keyboard, it closes.

modal.addEventListener('click',(e) => {
    // console.log(e.target); // We got what we clicked.
    // console.log(e.target.nodeName); // Get only node name.
    if(e.target.nodeName === "DIALOG")
    {
        modal.close();
    }    
}) 

// To close the modal with a button

closeModal.addEventListener('click', () => {
    // Let's run the animation here.
    // When the animation is finished, it will close physically and go back to display none.
    
    // First, we turn on the closing attribute.
    modal.setAttribute('closing', ""); // nothing or true, it works fine.
    // But, the dialog still in the DOM, and the backdrop still there.

    // To remove it from the DOM.
    modal.addEventListener('animationend', () =>{
        modal.removeAttribute('closing');
        modal.close(); // If we want to open for the second time, it doesn't open.
    }, {once: true}) // once : true runs it one time.
    
    // To close when we click outside the modal
 
});





