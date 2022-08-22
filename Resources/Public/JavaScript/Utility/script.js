/**
 * @param {string} data
 */
export const load = (data) => {
  let dataObject = document.createElement('div');
  dataObject.innerHTML = data;
  let scripts = dataObject.querySelectorAll('script');

  scripts.forEach((script) => addToHead(script));
}

/**
 * @param {Object} script
 */
const addToHead = (script) => {
  const tag = document.createElement('script');
  tag.type = script.type;

  if (script.src === '') {
    tag.innerHTML = script.innerHTML;
  } else {
    tag.src = script.src;
  }

  document.getElementsByTagName('head')[0].appendChild(tag);
}
