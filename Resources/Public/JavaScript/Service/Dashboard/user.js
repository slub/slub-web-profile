/**
 * @type {string}
 */
const uriSaveWidgets = '/?tx_slubwebprofile_ajax[userWidget]=1';

/**
 * @param {[]} widgets
 */
export const updateWidgets = async (widgets) => {
  const response = await fetch(uriSaveWidgets, {
    headers: {
      'Content-Type': 'application/json; charset=utf-8'
    },
    method: 'POST',
    cache: 'no-cache',
    body: JSON.stringify({
      widgets: widgets,
      action: 'update'
    })
  });

  return response.json();
}
