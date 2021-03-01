!function(e){var t={};function n(i){if(t[i])return t[i].exports;var r=t[i]={i:i,l:!1,exports:{}};return e[i].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,i){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(i,r,function(t){return e[t]}.bind(null,r));return i},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=15)}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.blocks},function(e,t){e.exports=window.wp.blockEditor},function(e,t,n){},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){var i=n(10),r=n(11),o=n(12),l=n(14);e.exports=function(e,t){return i(e)||r(e,t)||o(e,t)||l()},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=window.wp.coreData},function(e,t){e.exports=window.wp.data},function(e,t){e.exports=function(e){if(Array.isArray(e))return e},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],_n=!0,i=!1,r=void 0;try{for(var o,l=e[Symbol.iterator]();!(_n=(o=l.next()).done)&&(n.push(o.value),!t||n.length!==t);_n=!0);}catch(e){i=!0,r=e}finally{try{_n||null==l.return||l.return()}finally{if(i)throw r}}return n}},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){var i=n(13);e.exports=function(e,t){if(e){if("string"==typeof e)return i(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?i(e,t):void 0}},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,i=new Array(t);n<t;n++)i[n]=e[n];return i},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){"use strict";n.r(t);var i=n(3),r=n(1),o=n(6),l=n.n(o),c=n(7),a=n.n(c),s=n(0),p=n(4),u=n(2),m=n(8),b=n(9);function d(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function f(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?d(Object(n),!0).forEach((function(t){l()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):d(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}n(5),Object(i.registerBlockType)("swi-petition/form-block",{apiVersion:2,title:Object(r.__)("Form Block","swi-petition"),description:Object(r.__)("Input fields for Petition!","swi-petition"),category:"widgets",icon:"smiley",supports:{html:!1},attributes:{firstNameField:{type:"string",source:"html",selector:".swi-petition-fname"},lastNameField:{type:"string",source:"html",selector:".swi-petition-lname"},emailField:{type:"string",source:"html",selector:".swi-petition-email"},zipField:{type:"string",source:"html",selector:".swi-petition-zip"}},edit:function(e){var t=Object(p.useBlockProps)(),n=Object(b.useSelect)((function(e){return e("core/editor").getCurrentPostType()}),[]),i=e.attributes,o=e.className,l=e.setAttributes,c=Object(m.useEntityProp)("postType",n,"meta"),d=a()(c,2),O=d[0],j=d[1];return[Object(s.createElement)(p.InspectorControls,null,Object(s.createElement)(u.PanelBody,{title:Object(r.__)("Petition! Settings","swi-petition"),initialOpen:!1},Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.TextControl,{label:Object(r.__)("Expected number of signatures","swi-petition"),placeholder:"dddd",value:O.swi_petition_goal,type:"number",min:"1",onChange:function(e){return j(f(f({},O),{},{swi_petition_goal:e}))}}))),Object(s.createElement)(u.PanelBody,{title:Object(r.__)("Petition! form fields","swi-petition"),initialOpen:!0},Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(r.__)("First Name","swi-petition"),checked:i.firstNameField,onChange:function(e){return l({firstNameField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(r.__)("Last Name","swi-petition"),checked:i.lastNameField,onChange:function(e){return l({lastNameField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(r.__)("Email","swi-petition"),checked:i.emailField,onChange:function(e){return l({emailField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(r.__)("Zip Code","swi-petition"),checked:i.zipField,onChange:function(e){return l({zipField:e})}}))),i.zipField&&Object(s.createElement)(u.PanelBody,{title:Object(r.__)("Zip Code Settings","swi-petition"),initialOpen:!0},Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.TextControl,{label:Object(r.__)("Allowed zip code pattern","swi-petition"),placeholder:"dddd",value:O.swi_petition_zip_pattern,onChange:function(e){return j(f(f({},O),{},{swi_petition_zip_pattern:e}))}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.TextControl,{label:Object(r.__)("Allowed zip codes","swi-petition"),placeholder:"Zip codes separated by commas",value:O.swi_petition_allowed_zips,onChange:function(e){return j(f(f({},O),{},{swi_petition_allowed_zips:e}))}})))),Object(s.createElement)("div",{className:"swi-petition-form"},Object(s.createElement)("form",t,i.firstNameField&&Object(s.createElement)("div",{className:"swi-petition-fname form-group"},Object(s.createElement)(u.TextControl,{label:Object(r.__)("First Name","swi-petition"),type:"text",name:"swi_petition_fname"})),i.lastNameField&&Object(s.createElement)(u.TextControl,{label:Object(r.__)("Last Name","swi-petition"),type:"text",className:o}),i.emailField&&Object(s.createElement)(u.TextControl,{label:Object(r.__)("Email","swi-petition"),type:"email",className:o}),i.zipField&&Object(s.createElement)(u.TextControl,{label:Object(r.__)("Zip Code","swi-petition"),type:"number",className:o}),Object(s.createElement)("div",null,Object(s.createElement)("button",{type:"submit",disabled:!0},Object(r.__)("Sign the Petition","swi-petition")))))]},save:function(e){var t=e.attributes;return e.className,Object(s.createElement)("div",{className:"swi-petition-form"},Object(s.createElement)("form",null,t.firstNameField&&Object(s.createElement)("div",{className:"swi-petition-fname form-group"},Object(s.createElement)("label",null,Object(r.__)("First Name","swi-petition")),Object(s.createElement)("input",{type:"text",name:"swi_petition_fname",placeholder:Object(r.__)("First Name","swi-petition")})),t.lastNameField&&Object(s.createElement)("div",{className:"swi-petition-lname form-group"},Object(s.createElement)("label",null,Object(r.__)("Last Name","swi-petition")),Object(s.createElement)("input",{type:"text",name:"swi_petition_lname",placeholder:Object(r.__)("Last Name","swi-petition")})),t.emailField&&Object(s.createElement)("div",{className:"swi-petition-email form-group"},Object(s.createElement)("label",null,Object(r.__)("Email","swi-petition")),Object(s.createElement)("input",{type:"email",name:"swi_petition_email",placeholder:Object(r.__)("email@example.org","swi-petition")})),t.zipField&&Object(s.createElement)("div",{className:"swi-petition-zip form-group"},Object(s.createElement)("label",null,Object(r.__)("Zip Code","swi-petition")),Object(s.createElement)("input",{type:"text",name:"swi_petition_zip",placeholder:Object(r.__)("1000","swi-petition")})),Object(s.createElement)("div",{className:"alert alert-warning invalid-feedback",role:"alert",style:{display:"none"}}),Object(s.createElement)("div",{className:"btn-group",role:"group"},Object(s.createElement)("button",{className:"btn btn-primary",type:"submit"},Object(r.__)("Sign the Petition","swi-petition")))))}}),Object(i.registerBlockType)("swi-petition/counter-block",{apiVersion:2,title:Object(r.__)("Counter Block","swi-petition"),description:Object(r.__)("Counter for Petition!","swi-petition"),category:"widgets",icon:"smiley",supports:{html:!1},attributes:{hasCounter:{type:"string",source:"html",selector:".swi-petition-counter"}},edit:function(){return Object(s.createElement)("div",{className:"swi-petition-counter"},Object(s.createElement)("div",{className:"swi-petition-counter-number"},"9682"),Object(s.createElement)("svg",null,Object(s.createElement)("circle",{r:"50",cx:"70",cy:"70"})))},save:function(){return Object(s.createElement)("div",{className:"swi-petition-counter"})}})}]);