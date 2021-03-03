export default class Gauge {
    constructor(el, poller, options = {}) {
        this.el = el;

        this.poller = poller;

        this.options = Object.assign(options, {
            strokeWidth: 10
        });

        this.render();

        this.dom = {
            num: this.el.querySelector('.swi-petition-counter-number'),
            circle: this.el.getElementsByTagName('circle')[0],
        }

        this.pathLength = this.dom.circle.getTotalLength();

        this.poller.addCallback(this.update.bind(this))
    }

    render() {
        const sw = this.options.strokeWidth / 2;

        this.el.innerHTML = '<div class="swi-petition-counter-number"></div>'
            + '<svg fill="none" stroke="#fff">'
            + '<circle r="80" cx="110" cy="110" stroke-width="0"></circle>'
            + '<circle r="' + (80 - sw) +  '" cx="110" cy="110" stroke-width="1"></circle>'
            + '<circle r="' + (80 + sw) +  '" cx="110" cy="110" stroke-width="1"></circle>'
            + '</svg>'
    }

    update(count, goal) {
        this.dom.num.textContent = count;

        this.dom.circle.style.strokeWidth = this.options.strokeWidth;
        this.dom.circle.style.strokeDasharray = this.pathLength + 'px';

        let percent = 100 - (count / goal * 100);

        this.dom.circle.style.strokeDashoffset = (this.pathLength * percent / 100) + 'px';
    }

}
