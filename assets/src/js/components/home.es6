import React from 'react';
import ReactDOM from 'react-dom';

import CharacterCard from './characterCard.es6';
import NewCharacter from './newCharacter.es6';

export default class Home extends React.Component{
  constructor(){
    super();

    this.state = {
      cards: "",
      image: ""
    }
  }

  componentDidMount(){
    this.loadContent();
  }

  loadContent(){
    let cardArr = [];
    fetch('./assets/src/php/getCharacterInfo.php')
    .then((response) => {
      return response.json();
    })
    .then((myJson) => {
      myJson.forEach((item, index) => {
        cardArr.push(
          <CharacterCard
            key={index}
            firstname={item.characterFirstname}
            lastname={item.characterLastname}
            occupation={item.characterOccupation}
            streamer={item.twitchName}
            live={item.twitchLive}
            viewers={item.streamViewers}
            duration={item.streamDuration}
          />
        )
      });
      this.setState({
        cards: cardArr
      })
    });
  }

  render(){
    return (
      <div className="content home">
        <div className="toolbar">
          <select className="main-filter">
            <option className="main-filter-options"> ascending </option>
            <option className="main-filter-options"> descending </option>
            <option className="main-filter-options"> relevancy </option>
          </select>
        </div>
        <div className="card-wrapper">
          {this.state.cards}
        </div>
      </div>
    )
  }
}
