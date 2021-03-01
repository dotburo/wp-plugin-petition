import {nodeArray} from "./helpers";
import Form from "./Form";
import Counter from "./Counter";
import Poller from "./Poller";
import DynNum from "./DynNum";

(function(w, d) {
    let forms = d.getElementsByClassName('swi-petition-form'),
        counters = d.getElementsByClassName('swi-petition-counter'),
        numbers = d.getElementsByClassName('swi-petition-number'),
        config = Object.assign(w.swiPetition, {
            delay: 2000
        });

    const poller = new Poller(config);

    counters = nodeArray(counters).map(el => {
        return new Counter(poller, el);
    })

    numbers = nodeArray(numbers).map(el => {
        return new DynNum(poller, el);
    })

    nodeArray(forms).forEach(form => {
        new Form(form, {
            counters: counters
        });
    })

})(window, document);
