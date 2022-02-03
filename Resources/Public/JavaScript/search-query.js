/**
 * @type {string}
 */
const listSelector = '#js-search-query-list';

/**
 * @type {string}
 */
const addSelector = '#js-search-query-add';

/**
 * @type {Element}
 */
const addElement = document.querySelector(addSelector);

/**
 * @type {Element}
 */
const listElement = document.querySelector(listSelector);

if (addElement) {
  let addInitialize = await import('./Service/SearchQuery/Add/initialize.js');
  let addProcess = await import('./Service/SearchQuery/Add/process.js');

  addInitialize.showAdd();
  addInitialize.listenAddButton();
  addProcess.listenSubmit();
}

if (listElement) {
  let listDelete = await import('./Service/SearchQuery/List/delete.js');
  let listExport = await import('./Service/SearchQuery/List/export.js');
  let listSelectAll = await import('./Service/SearchQuery/List/select-all.js');

  listDelete.listenDelete();
  listExport.listenExport();
  listSelectAll.listenButton();
}
