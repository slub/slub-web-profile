import * as exportRow from './Export/row.js';
import * as utilityCsv from '../../../Utility/csv.js';
import * as utilityLanguage from '../../../Utility/language.js';
import * as selectAll from './select-all.js';

/**
 * @type {object}
 */
const wording = {
  'default': {
    'fileName': 'export-search-query',
    'exportDataHead': [
      '',
      'Title',
      'Hits',
      'Date',
      'Description',
      'Type',
      'Fields',
      'Link'
    ]
  },
  'de-DE': {
    'fileName': 'export-suchanfragen',
    'exportDataHead': [
      '',
      'Titel',
      'Treffer',
      'Datum',
      'Beschreibung',
      'Typ',
      'Felder',
      'Link'
    ]
  }
};

/**
 * @type {string}
 */
const buttonSelector = '#js-search-query-export';

/**
 * @type {HTMLObjectElement|Element}
 */
const buttonElement = document.querySelector(buttonSelector);

export const listenExport = () => buttonElement.addEventListener('click', () => createExport());

const createExport = () => {
  const exportIds = selectAll.selectedIds() ?? [];
  let data = [];

  if (exportIds.length > 0) {
    buttonElement.disabled = true;

    addDataHead(data);
    addDataBody(data, exportIds);

    utilityCsv.create(data, utilityLanguage.getTranslation(wording)['fileName'])
      .then(() => buttonElement.disabled = false);
  }
}

/**
 * @param {array} data
 * @param {array} ids
 */
const addDataBody = (data, ids) => {
  let autoIncrement = 1;

  ids.forEach((id) => {
    data.push(...[exportRow.getRow(id, autoIncrement)]);
    autoIncrement++;
  });
}

/**
 * @param {array} data
 */
const addDataHead = (data) => data.push(...[utilityLanguage.getTranslation(wording)['exportDataHead']]);
