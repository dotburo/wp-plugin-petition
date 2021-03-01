export default class Counter {
    constructor(el) {
        this.el = el;

        this.goal = window.swiPetition.goal;
        this.count = window.swiPetition.count;
        this.percent = 100 - (this.count / this.goal * 100);
        this.initialOffset = Math.max(0, this.count - 5);

        this.render();

        this.dom = {
            num: this.el.querySelector('.swi-counter-number'),
            circle: this.el.getElementsByTagName('circle')[0],
        }

        this.pathLength = this.dom.circle.getTotalLength();

        this.initialCount(this.initialOffset)
    }

    render() {
        this.el.innerHTML = '<div class="swi-counter">'
                + '<div class="swi-counter-number"></div>'
                    + '<svg fill="none" stroke="#fff">'
                        + '<circle r="80" cx="110" cy="110" stroke-width="0"></circle>'
                    + '</svg>'
                + '</div>'
    }

    update(count) {
        this.dom.num.textContent = count;

        this.dom.circle.style.strokeWidth = '10';
        this.dom.circle.style.strokeDasharray = this.pathLength + 'px';

        this.percent = 100 - (count / this.goal * 100);

        this.dom.circle.style.strokeDashoffset = ( this.pathLength * this.percent / 100 ) + 'px';
    }

    initialCount(initial) {
        window.setTimeout(() => {
            this.update(this.initialOffset++);
            if (this.initialOffset > this.count) {
                this.getCount(this.count);
            } else {
                this.initialCount(this.initialOffset);
            }
        }, 500 + (Math.random(0, 1) * 1000))
    }

    setTimeout() {
        window.setTimeout(() => {
            this.getCount();
        }, 2000)
    }

    getCount() {
        let url = window.swiPetition.url + '?action=swi_petition_poll&swi_petition=' + window.swiPetition.id

        window.fetch( url )
            .then(response => {
                if (response.ok) {
                    this.setTimeout();
                    return response.json()
                }
            })
            .then(count => {
                this.update(count);
            })
            .catch(error => {
                console.log(error);
            })
    }
}
