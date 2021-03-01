/**
 * @param {NodeList} nodeList
 * @return {Node[]}
 */
export function nodeArray(nodeList) {
    return Array.prototype.slice.call(nodeList)
}



/**
 * Find the parent element of a HTML element.
 * @return {Element|null}
 * @param {HTMLElement} el
 * @param {String} selector
 */
export const getParentElement = (el, selector) => {
    el = el.parentElement;
    while (el) {
        if (el.matches.call(el, selector)) {
            return el;
        }
        el = el.parentElement;
    }
    return null;
};
