import {nodeArray} from "./helpers";
import Form from "./Form";
import Counter from "./Counter";

(function(w, d) {
    let forms = d.getElementsByClassName('swi-petition-form'),
        counters = d.getElementsByClassName('swi-petition-counter');

    counters = nodeArray(counters).map(el => {
        return new Counter(el);
    })

    nodeArray(forms).forEach(form => {
        new Form(form, {
            counters: counters
        });
    })

})(window, document);
