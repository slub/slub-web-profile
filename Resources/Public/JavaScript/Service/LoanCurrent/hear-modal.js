/**
 * @type {string}
 */
const confirmModalSelector = '.js-loan-current-modal-submit';

/**
 * @type {HTMLObjectElement|Element}
 */
const confirmModalElement = document.querySelector(confirmModalSelector);

export const confirmModal = () => confirmModalElement.addEventListener('click', () => changeCheckboxStatus());


const changeCheckboxStatus = () => {
    // TODO checkbox change
}
