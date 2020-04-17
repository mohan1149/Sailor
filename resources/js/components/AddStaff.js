import React, { Component } from 'react';
import ReactDOM from 'react-dom';
export default class AddStaff extends Component{
    constructor(){
        super();
    }
    render(){
        return(
            <div className="addstaff">
                <h2>dfghjk</h2>
            </div>
        );
    }
}
if (document.getElementById('addstaff')) {
    ReactDOM.render(<AddStaff />, document.getElementById('addstaff'));
}
