import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import MediaHandler from './MediaHandler';
export default class Example extends Component {
    constructor(){
        super();
        this.user = window.user;
        this.peers = {};
        this.user.stream = null;
        this.setupPuhser();
        this.state = {
            hasMedia:false,
            otherUserId:null,
        }
        this.mediaHandler = new MediaHandler();
    }
    render() {
        return (
            <div className="w3-row w3-margin">
            <div className="w3-third w3-card w3-margin-top w3-white">
                <div id="container">
                <video id="myVideo" playsInline autoPlay className="teacher my-video myVideo"
                    ref={(ref)=>{this.myVideo = ref;}}
                >
                </video>
                <div className="w3-center w3-margin">
                    <button 
                        className="w3-button w3-blue w3-margin"
                        id="startButton" 
                        onClick={()=>this.getPermissions()}
                        >
                            Start
                        </button>
                    <button 
                        className="w3-button w3-green w3-margin" 
                        id="join"
                        onClick = {()=>this.callTo(2)}
                    >
                        Join Class
                    </button>
                </div>
                </div>
            </div>
            <div className="w3-twothird w3-margin-top w3-white w3-card">
                <div id="container"className="w3-margin user-screens">
                    <video className="user-screen userVideo" id="userVideo"  autoPlay
                        ref={(ref)=>{this.userVideo = ref;}}
                    >
                    </video>
                </div>
            </div>
        </div>
        );
    }
    getPermissions(){
        this.mediaHandler.getPermissions()
        .then((stream)=>{
            try{
                this.myVideo.srcObject = stream;
            }catch(e){
                this.myVideo.src = URL.createObjectURL(stream);
            }
        });
        this.myVideo.play();
    }
    setupPuhser(){
        let APP_KEY = 'ff793c35582f038e2bf0';
        this.pusher = new Pusher(
            APP_KEY,
            {
                authEndpoint:'/pusher/auth',
                cluster:'ap2',
                auth:{
                    params:this.user.id,
                    headers:{
                        'X-CSRF-Token' :window.csrfToken,
                    }
                }
            }
        );
        this.channel = this.pusher.subscribe('Sailor');
        console.log(this.channel);
        this.channel.bind(`client-signal-${this.user.id}`,(signal)=>{
            let peer =  this.peers[signal.userId];
            if(peer === undefined){
                this.setState({otherUserId:signal.userId});
                peer = this.startPeer(signal.userId,false);
            }
            peer.signal(signal.data);
        });
    }
    startPeer(userId,initiater=true){
        console.log('Starting peer.....');
        const peer = new Peer({
            initiater,
            stream:this.user.stream,
            trickle:false,
        });
        peer.on('signal',(data)=>{
            console.log('***** signal peer *****');
            this.channel.trigger(`client-signal-${userId}`,{
                type:'signal',
                userI:this.user.id,
                data:data,
            });
        });
        peer.on('stream',(stream)=>{
            console.log('****** peer stream  ****');
            try{

            }catch(e){

            }
        });
        peer.on('close',()=>{
            let peer = this.peers[userId];
            if(peer !== undefined){
                peer.destroy();
            }
            this.peers[userId] = undefined;
        });
        return peer;
    }
    callTo(userId){
        console.log('calling peer.....');
        this.peers[userId] = this.startPeer(userId,false);
    }
}

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
