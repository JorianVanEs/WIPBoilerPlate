import React from 'react';
import ReactDOM from 'react-dom';

import { BrowserRouter as Router, Route, Link } from "react-router-dom";

export default class Factions extends React.Component{
  constructor(){
    super();
  }

  componentDidMount(){
    fetch('./assets/src/php/getFactionList.php')
    .then((response) => {
      return response.json();
    })
    .then((myJson) => {
      console.log(myJson)
    });
  }

  render(){
    return (
      <div className="content factions">
        <div className="faction-header">
          <div className="button-add"> New Faction </div>
        </div>
        <ul className="faction-list">
          <li className="faction-tools">
            <div className="tools-filler-image"> </div>
            <div className="tools-title"> Faction Name </div>
            <div className="tools-leader"> Leader </div>
            <div className="tools-members"> Members </div>
            <div className="tools-filler-buttons"></div>
          </li>
          <li className="faction-list-item">
            <img className="item-icon" />
            <div className="item-title"> Emergency Medical Services </div>
            <div className="item-leader"> High Command </div>
            <div className="item-members"> 25 </div>
            <div className="item-buttons">
              <div className="item-button"></div>
              <div className="item-button"></div>
            </div>
          </li>
          <li className="faction-list-item">
            <img className="item-icon" />
            <div className="item-title"> Police Department </div>
            <div className="item-leader"> Jack Ripley </div>
            <div className="item-members"> 30 </div>
              <div className="item-buttons">
                <div className="item-button"></div>
                <div className="item-button"></div>
              </div>
          </li>
          <li className="faction-list-item">
            <img className="item-icon" />
            <div className="item-title"> Pillbox Medical Centre </div>
            <div className="item-leader"> Serge Cross </div>
            <div className="item-members"> 15 </div>
              <div className="item-buttons">
                <div className="item-button"></div>
                <div className="item-button"></div>
              </div>
          </li>
          <li className="faction-list-item">
            <img className="item-icon" />
            <div className="item-title"> Chang Gang </div>
            <div className="item-leader"> Wang Chang </div>
            <div className="item-members"> 10 </div>
              <div className="item-buttons">
                <div className="item-button"></div>
                <div className="item-button"></div>
              </div>
          </li>
          <li className="faction-list-item">
            <img className="item-icon" />
            <div className="item-title"> Koreans </div>
            <div className="item-leader"> Sun Moon </div>
            <div className="item-members"> 10 </div>
              <div className="item-buttons">
                <div className="item-button"></div>
                <div className="item-button"></div>
              </div>
          </li>
        </ul>
      </div>
    )
  }
}
