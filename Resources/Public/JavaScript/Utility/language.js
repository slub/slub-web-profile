/**
 * @type {string|string}
 */
let language = document.querySelector('html').getAttribute('lang') ?? 'default';

/**
 * @param {object} wording
 * @returns {string}
 */
export const getTranslation = (wording) => {
  if (wording[language] === undefined) {
    language = 'default';
  }

  return wording[language];
}
