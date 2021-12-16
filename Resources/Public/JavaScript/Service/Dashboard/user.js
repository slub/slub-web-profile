/**
 * @type {string}
 */
const uriSaveWidgets = '/?tx_slubwebprofile_ajax[userWidget]=1';

/**
 * @param {number} pageUid
 * @param {[]} widgets
 */
export const updateWidgets = async (pageUid, widgets) => {
  const response = await fetch(uriSaveWidgets, {
    headers: {
      'Content-Type': 'application/json; charset=utf-8'
    },
    method: 'POST',
    cache: 'no-cache',
    body: JSON.stringify({
      widgets: widgets,
      pageUid: pageUid,
      action: 'update'
    })
  });

  return response.json();
}
