import * as widget from './widget.js'

/**
 * @type {string}
 */
const itemDisabledClass = 'controller__item--is-disabled';

/**
 * @type {string}
 */
const itemsSelector = '.js-dashboard-controller-item';

/**
 * @type {string}
 */
const itemSelector = '#js-dashboard-controller-item-###itemId###';

export const initialize = () => {
  const items = document.querySelectorAll(itemsSelector);

  items.length > 0 && items.forEach((item) => item.addEventListener('click', () => addWidget(item)));
}

/**
 * @param {HTMLObjectElement|Element} item
 */
const addWidget = (item) => {
  if (!item.classList.contains(itemDisabledClass)) {
    const widgetData = JSON.parse(item.dataset.widget);
    const widgetId = parseInt(widgetData.id);

    toggleItem(widgetId);
    widget.addWidget(widgetData);
  }
}

/**
 * @param {number} id
 * @return {object}
 */
export const getItemSettings = (id) => {
  const itemSelectorId = replaceItemId(itemSelector, id);
  const item = document.querySelector(itemSelectorId);

  return JSON.parse(item.dataset.widget);
}

/**
 * @param {number} itemId
 */
export const toggleItem = (itemId) => {
  const itemSelectorId = replaceItemId(itemSelector, itemId);

  document.querySelector(itemSelectorId).classList.toggle(itemDisabledClass);
}

/**
 * @param {string} string
 * @param {number} itemId
 * @return {string}
 */
const replaceItemId = (string, itemId) => string.replace('###itemId###', itemId.toString());
