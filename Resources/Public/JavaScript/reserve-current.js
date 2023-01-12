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
  let btnSubmit = await import('./Service/ReserveCurrent/btn-submit.js');
  let listToggleTable = await import('./Service/ReserveCurrent/toggle-table.js');

  listSelectAll.listenButton();
  btnSubmit.listenCheckItems();
  listToggleTable.listenDropdown();
}
