/**
 * Přiřazení proměnných k elementům formuláře.
 */
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const form = document.getElementById('form');
let errorElement = document.getElementById('error');

/**
 * Přidání události "submit" k formuláři
 */
form.addEventListener('submit', (e)=>{
    let messages = [];

    /**
     * Kontrola uživatelských vstupů
     */
    if (username.value === '' || username.value == null){
        messages.push('Username is required');
    }
    if (username.value.length >= 15){
        messages.push('Username must be shorter than 15 characters');
    }
    if (password.value.length <= 3){
        messages.push('Password must be longer than 3 characters');
    }
    if (password.value.length >= 15){
        messages.push('Password must be shorter than 15 characters');
    }
    if (!email.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)){
        messages.push("Enter the correct format for email.");
    }
    if (messages.length > 0){
        e.preventDefault();
        errorElement.innerHTML = "";
        for (let mess in messages) {
            errorElement.innerHTML += '<p>' + messages[mess] +'</p>';
        }
    }

})