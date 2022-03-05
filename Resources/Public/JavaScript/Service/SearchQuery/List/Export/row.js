import * as utilityString from '../../../../Utility/string.js';

/**
 * @type {string}
 */
const exportSelector = '#js-search-query-export-item';

/**
 * @type {string}
 */
const exportTitleSelector = `${exportSelector}-###itemId###-title`;

/**
 * @type {string}
 */
const exportHitsSelector = `${exportSelector}-###itemId###-hits`;

/**
 * @type {string}
 */
const exportDateSelector = `${exportSelector}-###itemId###-date`;

/**
 * @type {string}
 */
const exportDescriptionSelector = `${exportSelector}-###itemId###-description`;

/**
 * @type {string}
 */
const exportTypeSelector = `${exportSelector}-###itemId###-type`;

/**
 * @type {string}
 */
const exportFieldSelector = `${exportSelector}-###itemId###-field`;

/**
 * @type {string}
 */
const exportLinkSelector = `${exportSelector}-###itemId###-link`;

/**
 * @param {number} id
 * @param {number} autoIncrement
 * @returns {[number, string]}
 */
export const getRow = (id, autoIncrement) => {
  return [
    autoIncrement,
    getTitle(id),
    getHits(id),
    getDate(id),
    getDescription(id),
    getType(id),
    getField(id),
    getLink(id)
  ];
}

/**
 * @param {number} id
 * @returns {string}
 */
const getTitle = (id) => {
  const element = replaceItemId(exportTitleSelector, id);

  return utilityString.removeLineBreaks(
    document.querySelector(element).innerHTML
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getHits = (id) => {
  const element = replaceItemId(exportHitsSelector, id);

  return utilityString.removeLineBreaks(
    document.querySelector(element).innerHTML
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getDate = (id) => {
  const element = replaceItemId(exportDateSelector, id);

  return utilityString.removeLineBreaks(
    document.querySelector(element).innerHTML
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getDescription = (id) => {
  const element = replaceItemId(exportDescriptionSelector, id);

  return utilityString.removeHtmlBreaks(
    utilityString.removeLineBreaks(
      document.querySelector(element).innerHTML
    )
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getType = (id) => {
  const element = replaceItemId(exportTypeSelector, id);

  return utilityString.removeLineBreaks(
    document.querySelector(element).innerHTML
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getField = (id) => {
  const element = replaceItemId(exportFieldSelector, id);

  return utilityString.replaceLineBreaksWithColon(
    document.querySelector(element).innerText
  );
}

/**
 * @param {number} id
 * @returns {string}
 */
const getLink = (id) => {
  const element = replaceItemId(exportLinkSelector, id);

  return document.querySelector(element).getAttribute('href');
}

/**
 * @param {string} string
 * @param {number} itemId
 * @returns {string}
 */
const replaceItemId = (string, itemId) => string.replace('###itemId###', itemId.toString());
