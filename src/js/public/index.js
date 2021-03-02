import {nodeArray} from "./helpers";
import Form from "./Form";
import Counter from "./Counter";
import Poller from "./Poller";
import DynNum from "./DynNum";

(function(w, d, config) {
    let forms = d.getElementsByClassName('swi-petition-form'),
        counters = d.getElementsByClassName('swi-petition-counter'),
        numbers = d.getElementsByClassName('swi-petition-number');

    config = Object.assign(config, {
        delay: config.pollInterval || 5000
    });

    const poller = new Poller(config);

    nodeArray(counters).map(el => {
        return new Counter(poller, el);
    })

    nodeArray(numbers).map(el => {
        return new DynNum(poller, el);
    })

    nodeArray(forms).forEach(form => {
        new Form(form, {
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
