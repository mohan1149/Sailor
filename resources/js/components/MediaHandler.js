import React, { Component } from 'react';
export default class MediaHandler extends Component{
    getPermissions(){
        return new Promise((res,rej)=>{
            navigator.mediaDevices.getUserMedia({
                video:true,
                audio:true
            })
            .then((stream) =>{
                res(stream);
            })
            .catch((error)=>{
                console.log(error);
            })
        })
    }
}