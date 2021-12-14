/**
 * @type {string}
 */
const itemDisabledClass = 'controller__item--is-disabled';

/**
 * @type {string}
 */
const itemSelector = '#js-dashboard-controller-item-###itemId###';

/**
 * @param {number} itemId
 */
export const hideItem = (itemId) => {
  const itemSelectorId = replaceItemId(itemSelector, itemId);

  document.querySelector(itemSelectorId).classList.toggle(itemDisabledClass);
}

/**
 * @param {string} string
 * @param {number} itemId
 * @return {string}
 */
const replaceItemId = (string, itemId) => string.replace('###itemId###', itemId.toString());
