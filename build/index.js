(window.webpackJsonp_starter_block=window.webpackJsonp_starter_block||[]).push([[1],{9:function(e,t,n){}}]),function(e){function t(t){for(var r,i,a=t[0],c=t[1],s=t[2],u=0,b=[];u<a.length;u++)i=a[u],Object.prototype.hasOwnProperty.call(o,i)&&o[i]&&b.push(o[i][0]),o[i]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);for(p&&p(t);b.length;)b.shift()();return l.push.apply(l,s||[]),n()}function n(){for(var e,t=0;t<l.length;t++){for(var n=l[t],r=!0,a=1;a<n.length;a++){var c=n[a];0!==o[c]&&(r=!1)}r&&(l.splice(t--,1),e=i(i.s=n[0]))}return e}var r={},o={0:0},l=[];function i(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=r,i.d=function(e,t,n){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)i.d(n,r,function(t){return e[t]}.bind(null,r));return n},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var a=window.webpackJsonp_starter_block=window.webpackJsonp_starter_block||[],c=a.push.bind(a);a.push=t,a=a.slice();for(var s=0;s<a.length;s++)t(a[s]);var p=c;l.push([16,1]),n()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.blockEditor},function(e,t){e.exports=window.wp.blocks},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){var r=n(10),o=n(11),l=n(12),i=n(14);e.exports=function(e,t){return r(e)||o(e,t)||l(e,t)||i()},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=window.wp.coreData},function(e,t){e.exports=window.wp.data},,function(e,t){e.exports=function(e){if(Array.isArray(e))return e},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],_n=!0,r=!1,o=void 0;try{for(var l,i=e[Symbol.iterator]();!(_n=(l=i.next()).done)&&(n.push(l.value),!t||n.length!==t);_n=!0);}catch(e){r=!0,o=e}finally{try{_n||null==i.return||i.return()}finally{if(r)throw o}}return n}},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){var r=n(13);e.exports=function(e,t){if(e){if("string"==typeof e)return r(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?r(e,t):void 0}},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")},e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,n){},function(e,t,n){"use strict";n.r(t);var r=n(4),o=n(1),l=(n(9),n(5)),i=n.n(l),a=n(6),c=n.n(a),s=n(0),p=n(3),u=n(2),b=n(7),m=n(8);function f(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function d(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?f(Object(n),!0).forEach((function(t){i()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):f(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}n(15),Object(r.registerBlockType)("create-block/starter-block",{apiVersion:2,title:Object(o.__)("Starter Block","starter-block"),description:Object(o.__)("Input field for Petition!","starter-block"),category:"widgets",icon:"smiley",supports:{html:!1},attributes:{firstNameField:{type:"string",source:"html",selector:".swi-petition-fname"},lastNameField:{type:"string",source:"html",selector:".swi-petition-lname"},emailField:{type:"string",source:"html",selector:".swi-petition-email"},zipField:{type:"string",source:"html",selector:".swi-petition-zip"}},edit:function(e){var t=Object(p.useBlockProps)(),n=Object(m.useSelect)((function(e){return e("core/editor").getCurrentPostType()}),[]),r=e.attributes,l=e.className,i=e.setAttributes,a=Object(b.useEntityProp)("postType",n,"meta"),f=c()(a,2),O=f[0],_=f[1];return console.log(r,l,O,n),[Object(s.createElement)(p.InspectorControls,null,Object(s.createElement)(u.PanelBody,{title:"Most awesome settings ever",initialOpen:!0},Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(o.__)("First Name"),checked:r.firstNameField,onChange:function(e){return i({firstNameField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(o.__)("Last Name"),checked:r.lastNameField,onChange:function(e){return i({lastNameField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(o.__)("Email"),checked:r.emailField,onChange:function(e){return i({emailField:e})}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.ToggleControl,{label:Object(o.__)("Zip Code"),checked:r.zipField,onChange:function(e){return i({zipField:e})}}))),r.zipField&&Object(s.createElement)(u.PanelBody,{title:Object(o.__)("Zip Code Settings","swi-petition"),initialOpen:!0},Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.TextControl,{label:Object(o.__)("Allowed zip code pattern","swi-petition"),placeholder:"dddd",value:O.swi_petition_zip_pattern,onChange:function(e){return _(d(d({},O),{},{swi_petition_zip_pattern:e}))}})),Object(s.createElement)(u.PanelRow,null,Object(s.createElement)(u.TextControl,{label:Object(o.__)("Allowed zip codes","swi-petition"),placeholder:"Zip codes separated by commas",value:O.swi_petition_allowed_zips,onChange:function(e){return _(d(d({},O),{},{swi_petition_allowed_zips:e}))}})))),Object(s.createElement)("div",{className:"swi-petition-form"},Object(s.createElement)("form",t,r.firstNameField&&Object(s.createElement)("div",{className:"swi-petition-fname form-group"},Object(s.createElement)(u.TextControl,{label:Object(o.__)("First Name"),type:"text",name:"swi_petition_fname"})),r.lastNameField&&Object(s.createElement)(u.TextControl,{label:Object(o.__)("Last Name"),type:"text",className:l}),r.emailField&&Object(s.createElement)(u.TextControl,{label:Object(o.__)("Email"),type:"email",className:l}),r.zipField&&Object(s.createElement)(u.TextControl,{label:Object(o.__)("Zip Code"),type:"number",className:l})))]},save:function(e){var t=e.attributes;return e.className,console.log("saving",t),Object(s.createElement)("div",{className:"swi-petition-form"},Object(s.createElement)("form",null,t.firstNameField&&Object(s.createElement)("div",{className:"swi-petition-fname form-group"},Object(s.createElement)("label",null,Object(o.__)("First Name")),Object(s.createElement)("input",{type:"text",name:"swi_petition_fname"})),t.lastNameField&&Object(s.createElement)("div",{className:"swi-petition-lname form-group"},Object(s.createElement)("label",null,Object(o.__)("Last Name")),Object(s.createElement)("input",{type:"text",name:"swi_petition_lname"})),t.emailField&&Object(s.createElement)("div",{className:"swi-petition-email form-group"},Object(s.createElement)("label",null,Object(o.__)("Email")),Object(s.createElement)("input",{type:"email",name:"swi_petition_email"})),t.zipField&&Object(s.createElement)("div",{className:"swi-petition-zip form-group"},Object(s.createElement)("label",null,Object(o.__)("Zip Code")),Object(s.createElement)("input",{type:"text",name:"swi_petition_zip"}))))}})}]);