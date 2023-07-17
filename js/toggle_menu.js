const navigation = document.querySelector('.navigation');
// const move = document.querySelector('toggle');
document.querySelector('.toggle').onclick = function(){
    this.classList.toggle('active');
    navigation.classList.toggle('active');
    // move.classList.toggle('active');
}