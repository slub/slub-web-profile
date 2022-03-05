import * as apiMessageStatus from '../../ApiMessage/status.js';
import * as searchQueryRequest from '../request.js';
import * as selectAll from './select-all.js';
import * as utilityAnimation from '../../../Utility/animation.js';

/**
 * @type {string}
 */
const buttonSelector = '#js-search-query-delete';

/**
 * @type {string}
 */
const itemSelector = '.js-search-query-list-item';

/**
 * @type {string}
 */
const itemHeaderSelector = '#js-search-query-list-item-###itemId###-header';

/**
 * @type {string}
 */
const itemContentSelector = '#js-search-query-list-item-###itemId###-content';

/**
 * @type {string}
 */
const listSelector = '#js-search-query-list';

/**
 * @type {string}
 */
const statusSelector = '#js-search-query-status';

/**
 * @type {HTMLObjectElement|Element}
 */
const listElement = document.querySelector(listSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const statusElement = document.querySelector(statusSelector);

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

export const listenDelete = () => buttonElement.addEventListener('click', () => deleteSearchQuery());

const deleteSearchQuery = async () => {
  const deleteIds = selectAll.selectedIds() ?? [];
  const searchQuery = {
    delete: deleteIds
  };

  if (deleteIds.length > 0) {
    buttonElement.disabled = true;
    searchQueryRequest.deleteSearchQuery(searchQuery)
      .then(data => handleResult(data, deleteIds))
      .catch(error => console.error(error));
  }
}

/**
 * @param {object} data
 * @param {[]} selectedIds
 */
const handleResult = (data, selectedIds) => {
  const messageCode = parseInt(data.code);
  const itemLength = document.querySelectorAll(itemSelector).length;

  apiMessageStatus.initialize(messageCode).then();
  messageCode === 200 && removeItems(selectedIds);
  buttonElement.disabled = false;

  if (itemLength === selectedIds.length) {
    statusElement.style.display = 'block';
    listElement.remove();
  }
}

/**
 * @param {[]} itemIds
 */
const removeItems = (itemIds) => itemIds.forEach(async (id) => removeItem(id));

/**
 * @param {number} itemId
 */
const removeItem = (itemId) => {
  utilityAnimation.removeItem(document.querySelector(replaceItemId(itemHeaderSelector, itemId)));
  utilityAnimation.removeItem(document.querySelector(replaceItemId(itemContentSelector, itemId)));
}

/**
 * @param {string} string
 * @param {number} itemId
 * @returns {string}
 */
const replaceItemId = (string, itemId) => string.replace('###itemId###', itemId.toString());
