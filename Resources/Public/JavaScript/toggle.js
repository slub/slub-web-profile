// Open Dropdown when button is clicked

/**
 * @type {string}
 */
const dropdownButtonSelector = '.js-dropdown';

/**
 * @type {string}
 */
const openClass = 'show';

/**
 * @type {string}
 */
const dropdownListSelector = '.dropdown__menu';


/**
 * @param {object} toggleBtn
 */
const executeDropdown = (toggleBtn) => {
    const toggleContainer = toggleBtn.parentNode.querySelector(dropdownListSelector);;

    toggleBtn.classList.toggle(openClass);
    if (toggleBtn.getAttribute('aria-expanded') === 'false') {
        toggleBtn.setAttribute('aria-expanded', 'true');
    } else { 
        toggleBtn.setAttribute('aria-expanded', 'false');
    }

    toggleContainer.classList.toggle(openClass);
}

const listenDropdown = () => {
    
    const toggleBtn = document.querySelector(dropdownButtonSelector);
    toggleBtn.addEventListener('click', () => executeDropdown(toggleBtn));
}

window.onload = () => {
    listenDropdown();
};
