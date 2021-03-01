export default class Counter {
    constructor(poller, el) {
        this.poller = poller;

        this.el = el;

        this.render();

        this.dom = {
            num: this.el.querySelector('.swi-petition-counter-number'),
            circle: this.el.getElementsByTagName('circle')[0],
        }

        this.pathLength = this.dom.circle.getTotalLength();

        this.poller.addCallback(this.update.bind(this))
    }

    render() {
        this.el.innerHTML = '<div class="swi-petition-counter-number"></div>'
            + '<svg fill="none" stroke="#fff">'
            + '<circle r="80" cx="110" cy="110" stroke-width="0"></circle>'
            + '</svg>'
    }

    update(count, goal) {
        this.dom.num.textContent = count;

        this.dom.circle.style.strokeWidth = '10';
        this.dom.circle.style.strokeDasharray = this.pathLength + 'px';

        let percent = 100 - (count / goal * 100);

        this.dom.circle.style.strokeDashoffset = (this.pathLength * percent / 100) + 'px';
    }

}
