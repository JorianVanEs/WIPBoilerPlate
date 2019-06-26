import React from 'react';
import { TweenLite, Expo } from 'gsap';

export default class UserSegment extends React.Component{
  constructor(){
    super();
    this.toggleElement = false;
  }

  expandMenu(){
    this.toggleElement = !this.toggleElement;
    let element = document.querySelector('.user-segment');
    if(this.toggleElement){
      console.log("Ja!");
      TweenLite.to(element, 1 , {top: 0, ease: Expo.easeOut});
    } else {
      TweenLite.to(element, 1 , {top: -150, ease: Expo.easeOut});
    }
  }

  render(){
    return (
      <div className="user-segment" onClick={() => this.expandMenu()}>
        <div className="user-pic"> </div>
        <div className="user-name"> Sk0peD </div>
      </div>
    );
  }
}
