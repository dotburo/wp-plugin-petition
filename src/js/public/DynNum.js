export default class DynNum {
    constructor(poller, el) {
        poller.addCallback(function (count) {
            el.textContent = count
        })
    }
}
