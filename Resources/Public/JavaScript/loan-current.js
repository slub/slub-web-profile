/**
 * @type {string}
 */
const listSelector = '#js-loan-current-action';

/**
 * @type {Element}
 */
const listElement = document.querySelector(listSelector);

if (listElement) {
  let listSelectAll = await import('./Service/LoanCurrent/select-all.js');
  let btnSubmit = await import('./Service/LoanCurrent/btn-submit.js');
  let listToggleTable = await import('./Service/LoanCurrent/toggle-table.js');

  listSelectAll.listenButton();
  btnSubmit.listenCheckItems();
  listToggleTable.listenDropdown();
}
