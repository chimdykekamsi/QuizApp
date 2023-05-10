let tab = Array()
function createT(page) {
  let showTab =  document.querySelector('#' + page)
    showTab.toggleAttribute('hidden');
   tab.push(showTab);
    if (tab[tab.length - 2] !== tab[tab.length - 1]) {
        tab[tab.length - 2].setAttribute('hidden', 'true');
    }
}