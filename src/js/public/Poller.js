export default class Poller {
    constructor(options) {
        this.options = options;

        this.callbacks = [];

        this.goal = options.goal;
        this.count = options.count;
        this.percent = 100 - (this.count / this.goal * 100);

        this.initialOffset = Math.max(0, this.count - 5);
        this.delay = options.delay;

        this._startWithOffset();
    }

    trigger() {
        this._getCount();
    }

    addCallback(fn) {
        this.callbacks.push(fn);
    }

    _setTimeout() {
        window.setTimeout(() => {
            this._getCount();
        }, this.delay)
    }

    _startWithOffset() {
        window.setTimeout(() => {
            if (this.initialOffset <= this.count) {
                this._runCallbacks(this.initialOffset++);
                this._startWithOffset(this.initialOffset);
            } else {
                this._getCount();
            }
        }, 500 + (Math.random(0, 1) * 1100))
    }

    _getCount() {
        let url = this.options.url + '?action=swi_petition_poll&swi_petition=' + this.options.id

        window.fetch( url )
            .then(response => {
                if (response.ok) {
                    return response.json()
                }
            })
            .then(count => {
                this._runCallbacks(count);
                this._setTimeout();
            })
            .catch(error => {
                console.log(error);
            })
    }

    _runCallbacks(count) {
        this.callbacks.forEach(fn => {
            fn(count, this.goal)
        });
    }
}
