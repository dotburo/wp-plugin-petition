export default class Poller {
    constructor(options) {
        this.options = options;

        this.callbacks = [];

        this.goal = options.goal;
        this.count = options.count;
        this.percent = 100 - (this.count / this.goal * 100);

        this.initialOffset = Math.max(0, this.count - 5);
        this.delay = options.delay;

        this.startWithOffset();
    }

    addCallback(fn) {
        this.callbacks.push(fn);
    }

    setTimeout() {
        window.setTimeout(() => {
            this.getCount();
        }, this.delay)
    }

    startWithOffset() {
        window.setTimeout(() => {
            if (this.initialOffset <= this.count) {
                this.runCallbacks(this.initialOffset++);
                this.startWithOffset(this.initialOffset);
            } else {
                this.getCount();
            }
        }, 500 + (Math.random(0, 1) * 1100))
    }

    getCount() {
        let url = this.options.url + '?action=swi_petition_poll&swi_petition=' + this.options.id

        window.fetch( url )
            .then(response => {
                if (response.ok) {
                    return response.json()
                }
            })
            .then(count => {
                this.runCallbacks(count);
                this.setTimeout();
            })
            .catch(error => {
                console.log(error);
            })
    }

    runCallbacks(count) {
        this.callbacks.forEach(fn => {
            fn(count, this.goal)
        });
    }
}
