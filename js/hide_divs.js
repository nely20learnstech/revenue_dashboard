const container = document.querySelector('.chart.storechart');
const show_button = document.querySelector('.hide-container');

show_button.addEventListener('click', () => {
    if(container.style.display === 'none')
    {
        container.style.display = 'block';        
        show_button.innerText = "Cacher le graphe";
    }        
    else
    {
        show_button.innerText = "Voir le graphe";
        container.style.display = 'none';
    }        
})