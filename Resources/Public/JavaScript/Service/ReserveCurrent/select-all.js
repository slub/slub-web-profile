/**
 * @type {string}
 */
const buttonSelector = '#js-reserve-current-select-all';

/**
 * @type {string}
 */
const itemSelector = '.js-reserve-current-item';

/**
 * @type {string}
 */
const itemCheckedSelector = '.js-reserve-current-item:checked';

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

/**
 * @type {NodeListOf<Element>}
 */
const itemElements = document.querySelectorAll(itemSelector);

export const listenButton = () => buttonElement.addEventListener('click', () => toggleItems());

const toggleItems = () => {
  let changeLabel = false;

  itemElements.forEach((item) => {
    toggleItem(item, changeLabel);
    changeLabel = true;
  });
}

/**
 * @param {object} item
 * @param {boolean} changeLabel
 */
const toggleItem = (item, changeLabel) => {
  if (item.getAttribute('checked')) {
    item.removeAttribute('checked');
    item.checked = false;

    changeLabel === false && setLabel('select');
  } else {
    item.setAttribute('checked', 'checked');
    item.checked = true;

    changeLabel === false && setLabel('deselect');
  }
}

/**
 * @param type
 */
const setLabel = (type) => {
  let label = buttonElement.dataset.select;

  if (type === 'deselect') {
    label = buttonElement.dataset.deselect
  }

  buttonElement.innerText = label;
}

/**
 * @returns {[]}
 */
export const selectedIds = () => {
  // Has to be set here to react dynamically
  const items = document.querySelectorAll(itemCheckedSelector);
  let selectedIds = [];

  items.forEach((item) => selectedIds.push(parseInt(item.value)));

  return selectedIds;
}
