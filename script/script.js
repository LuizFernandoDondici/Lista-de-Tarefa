
const input = document.querySelector('#input-tarefa');

input.addEventListener('input', () => {
    
    if (input.value == '') {
        input.style.borderColor = "red"
    } else {
        input.style.borderColor = "green"
    }
})
