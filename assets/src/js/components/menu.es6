import React from 'react';
import { TweenLite, Expo } from 'gsap';

export default class Menu extends React.Component{
  constructor(){
    super();
    this.toggleElement = false;
  }

  toggleMenu(){
    let element = document.querySelector('.menu');
    this.toggleElement = !this.toggleElement;
    if(this.toggleElement){
     TweenLite.to(element, 1 , {left: 0, ease: Expo.easeOut});
   } else {
     TweenLite.to(element, 1 , {left: -200, ease: Expo.easeOut});
   }
  }

  render(){
    return (
      <div className="menu">
        <img className='toggle' onClick={() => this.toggleMenu()} src="./assets/src/img/icons/menu_arrow.svg" />
        <ul className="menu-element">
          <li className="menu-item">
            <span> Characters </span>
            <img className="menu-image" src="" />
          </li>
          <li className="menu-item">
            <span> Factions </span>
            <img className="menu-image" src="" />
          </li>
        </ul>
      </div>
    );
  }
}
