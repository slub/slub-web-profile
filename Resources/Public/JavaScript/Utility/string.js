/**
 * @param {string} string
 * @returns {string}
 */
export const removeHtmlBreaks = (string) => string.replace(/<br\s*[\/]?>/gi,' ');

/**
 * @param string
 */
export const removeLineBreaks = (string) => string.replace(/[\r\n]+/g,'').trim();

/**
 * @param string
 */
export const replaceLineBreaksWithColon = (string) => string.replace(/[\r\n]+/g,', ').trim();
