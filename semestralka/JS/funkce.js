/**
 * Funkce pro změnu tématu webové stránky mezi světlým a tmavým režimem.
 */
function changeTheme() {
    let icon = document.getElementById('icon');
    document.body.classList.toggle("dark-theme");
    if (document.body.classList.contains("dark-theme")) {
        icon.src = "images/sun.png";
        icon.alt = "sun";
    } else {
        icon.src = "images/moon.png"
        icon.alt = "moon";

    }
}

/**
 * Přidání posluchače události pro změnu tématu při kliknutí na ikonu
 * @type {HTMLElement}
 */
var theme = document.getElementById('icon');
theme.addEventListener("click", changeTheme);

/**
 * Přidání posluchače události pro roztahujici elementy
 * @type {HTMLCollectionOf<Element>}
 */
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        /**
         * Přidání nebo odstranění třídy pro aktivní sklápěcí elemen
         */
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }

    });
}

    /**
     * Funkce pro validaci vstupních polí pomocí XMLHttpRequest.
     */
document.addEventListener('DOMContentLoaded', function () {
    /**
     * Získání všech vstupních polí s třídou 'ajax-input'
     * @type {NodeListOf<Element>}
     */
    const inputs = document.querySelectorAll('.ajax-input');

    /**
     * Přidání posluchače události pro každé vstupní pole
     */
    inputs.forEach(input => {
        input.addEventListener('input', function () {
            const value = this.value;
            const fieldName = this.name;
            const statusMessageElement = this.nextElementSibling;

    /**
     * Volání funkce pro ověření vstupu pomocí XMLHttpRequest
     */
            validateInput(value, fieldName, statusMessageElement);
        });
    });
});

    /**
     * Funkce pro odeslání XMLHttpRequest pro validaci vstupu na serveru.
     * @param {string} value Hodnota vstupního pole.
     * @param {string} fieldName Jméno vstupního pole.
     * @param {HTMLElement} statusMessageElement Element pro zobrazení stavové zprávy.
     */
function validateInput(value, fieldName, statusMessageElement) {

    /**
     * Pokud se jedná o pole 'password2', porovná hodnoty 'password' a 'password2'
     */
    if (fieldName === 'password2') {
        const passwordField = document.querySelector('[name="password"]');
        const password2Field = document.querySelector('[name="password2"]');
        if (passwordField.value === password2Field.value) {
            statusMessageElement.textContent = 'Passwords match';
            statusMessageElement.style.color = 'green';
        } else {
            statusMessageElement.textContent = 'Passwords do not match!';
            statusMessageElement.style.color = 'red';

        }return;
    }
        /**
         * Vytvoření XMLHttpRequest objektu
         * @type {XMLHttpRequest}
         */
    const xhr = new XMLHttpRequest();

        /**
         * Nastavení funkce pro zpracování odpovědi od serveru
         */
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            /**
             * Zpracování JSON odpovědi od serveru
             * @type {any}
             */
            const data = JSON.parse(xhr.responseText);

            /**
             * Změna zprávy a její barvy na základě výsledků validace
             */
            if (data.isValid) {
                statusMessageElement.textContent = 'Valid input!';
                statusMessageElement.style.color = 'green';
            } else {
                statusMessageElement.textContent = data.message;
                statusMessageElement.style.color = 'red';
            }

        }
    };
        /**
         * Nastavení parametrů pro odeslání POST požadavku na 'validate_input.php'
         */
    xhr.open('POST', 'validate_input.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        /**
         * Odeslání POST požadavku s parametry pro validaci
         */
    xhr.send(`field=${fieldName}&value=${value}`);
}


