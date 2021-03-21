import {nodeArray} from "./helpers";
import Form from "./Form";
import Gauge from "./Gauge";
import Poller from "./Poller";
import DynNum from "./DynNum";

(function (w, d, config) {
    let forms = d.getElementsByClassName('swi-petition-form'),
        counters = d.getElementsByClassName('swi-petition-counter'),
        numbers = d.getElementsByClassName('swi-petition-number');

    config = Object.assign(config, {
        delay: config.pollInterval || 10000
    });

    const poller = new Poller(config);

    nodeArray(counters).map(function (el) {
        return new Gauge(el, poller, {
            strokeWidth: 10
        });
    })

    nodeArray(numbers).map(function (el) {
        return new DynNum(poller, el);
    })

    nodeArray(forms).forEach(function (el) {
        new Form(el, {
            cb: poller.trigger.bind(poller),
            redirect: config.redirect,
            url: config.url,
            include: {
                _ajax_nonce: config.nonce,
                action: 'swi_petition_submit',
                swi_petition: config.id,
            }
        });
    })

})(window, document, window.swiPetition);
