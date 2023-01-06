import * as apiMessageStatus from '../../ApiMessage/status.js';
import * as deleteReserveRequest from './request.js';
import * as selectAll from './select-all.js';

/**
 * @type {string}
 */
const buttonSelector = '#js-reserve-current-delete';

/**
 * @type {string}
 */
const tableRowSelector = '#js-table-row-item-###itemId###';

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

// TODO delete API
export const listenDelete = () => buttonElement.addEventListener('click', () => deleteReserveCurrent());

const deleteReserveCurrent = async () => {
  const deleteIds = selectAll.selectedIds() ?? [];
  const deleteReserve = {
    delete: deleteIds
  };

  if (deleteIds.length > 0) {
    buttonElement.disabled = true;
    deleteReserveRequest.deleteReserveCurrent(deleteReserve)
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

  apiMessageStatus.initialize(messageCode).then();
  messageCode === 200 && removeItems(selectedIds);
  buttonElement.disabled = false;
}

/**
 * @param {[]} itemIds
 */
const removeItems = (itemIds) => itemIds.forEach(async (id) => removeItem(id));
/**
 * @param {number} itemId
 */
const removeItem = (itemId) => {
  removeItem(document.querySelector(replaceItemId(tableRowSelector, itemId)));
}