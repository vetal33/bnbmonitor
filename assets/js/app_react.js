import React from 'react';
import ReactDom from 'react-dom';

//const el = React.createElement('h2', null, 'Lift History!', React.createElement('span', null, '❤'));

const el = <h2>Lift Stuff! <span>❤</span></h2>;

ReactDom.render(el, document.getElementById('hello'));