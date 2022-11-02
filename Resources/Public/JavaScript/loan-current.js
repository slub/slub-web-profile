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

  listSelectAll.listenButton();
}
