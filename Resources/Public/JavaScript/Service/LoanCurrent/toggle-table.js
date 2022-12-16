// Open Table Dropdown when button is clicked

/**
 * @type {string}
 */
const dropdownButtonSelector = '.js-loan-dropdown-table';

/**
 * @type {string}
 */
const openClass = 'table-loan--is-open';

/**
 * @type {string}
 */
const dropdownListSelector = '.js-loan-dropdown__table';


/**
 * @param {object} toggleBtn
 */
const executeDropdown = (toggleBtn) => {
    const toggleContainers = document.querySelectorAll(dropdownListSelector);;

    toggleBtn.classList.toggle(openClass);
    if (toggleBtn.getAttribute('aria-expanded') === 'false') {
        toggleBtn.setAttribute('aria-expanded', 'true');
        toggleContainers.forEach((toggleContainer) => {
            toggleContainer.setAttribute('aria-hidden', 'false');
        });
    } else {
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleContainers.forEach((toggleContainer) => {
            toggleContainer.setAttribute('aria-hidden', 'true');
        });
    }
}

export const listenDropdown = () => {

    const toggleBtn = document.querySelector(dropdownButtonSelector);
    toggleBtn.addEventListener('click', () => executeDropdown(toggleBtn));
}
