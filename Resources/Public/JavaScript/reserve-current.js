/**
 * @type {string}
 */
const listSelector = '#js-reserve-current-action';

/**
 * @type {Element}
 */
const listElement = document.querySelector(listSelector);

if (listElement) {  
  let listSelectAll = await import('./Service/ReserveCurrent/select-all.js');
  let listToggleTable = await import('./Service/ReserveCurrent/toggle-table.js');
  let listDelete = await import('./Service/ReserveCurrent/delete.js');

  listSelectAll.listenButton();
  listToggleTable.listenDropdown();
  listDelete.listenDelete();
}
