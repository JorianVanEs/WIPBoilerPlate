import React from 'react';
import ReactDOM from 'react-dom';

export default class CharacterCard extends React.Component{
  constructor(props){
    super(props);
  }

  checkIfLive(){
    if(this.props.live){
      return 'active';
    } else {
      return 'inactive';
    }
  }

  checkIfTooltipNeeded(){
    if(this.props.live){
      return (
        <div className="tooltip">
          <div className="viewers">
            <img className="icon" src="./assets/src/img/icons/duration.svg" />
            <span> {this.props.duration} </span>
          </div>
          <div className="viewers">
            <img className="icon" src="./assets/src/img/icons/viewers.svg" />
            <span> {this.props.viewers} </span>
          </div>
        </div>
      );
    } else {
      return '';
    }
  }

  render(){
    return (
      <div className="card">
        <img className="avatar" src={"./assets/src/img/avatars/" + this.props.firstname + "_" + this.props.lastname} />
        <div className="character-information">
          <div className="name"> {this.props.firstname + " " + this.props.lastname} </div>
          <div className="title"> {this.props.occupation} </div>
        </div>
        <div className="socialElements">
          <a href={"https://www.twitch.tv/" + this.props.streamer} target="_blank">
            <div className="twitch">
              {this.checkIfTooltipNeeded()}
              <img className="twitch-icon" src="./assets/src/img/icons/twitch.svg" />
              <div className="streamer"> {this.props.streamer} </div>
              <div className={"live-indicator " + this.checkIfLive()}> </div>
            </div>
        </a>
        </div>
      </div>
    );
  }
}
