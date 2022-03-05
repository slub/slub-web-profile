/**
 * @param {HTMLObjectElement|Element} item
 * @param {number} opacity
 */
export const removeItem = (item, opacity= 1) => {
  opacity === 1 && item.setAttribute('data-removing', '1');
  item.style.opacity < 0 && item.remove();

  setTimeout(() => {
    opacity -= 0.1;
    item.style.opacity = opacity.toString();

    removeItem(item, opacity);
  }, 50);
}
