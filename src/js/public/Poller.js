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
        let self = this;
        window.setTimeout(function() {
            self._getCount();
        }, this.delay)
    }

    _startWithOffset() {
        let self = this;
        window.setTimeout(function() {
            if (self.initialOffset <= self.count) {
                self._runCallbacks(self.initialOffset++);
                self._startWithOffset(self.initialOffset);
            } else {
                self._getCount();
            }
        }, 500 + (Math.random(0, 1) * 1100))
    }

    _getCount() {
        let url = this.options.url + '?action=swi_petition_poll&swi_petition=' + this.options.id,
            self = this;

        window.fetch(url)
            .then(function(response) {
                return response.ok ? response.json() : Promise.reject(response.error())
            })
            .then(function(count) {
                self._runCallbacks(count);
                self._setTimeout();
            })
            .catch(function(error) {
                console.log(error);
            })
    }

    _runCallbacks(count) {
        let self = this;
        this.callbacks.forEach(function(fn) {
            fn(count, self.goal)
        });
    }
}
