export default class DynNum {
    constructor(poller, el) {
        poller.addCallback(count => {
            el.textContent = count
        })
    }
}
