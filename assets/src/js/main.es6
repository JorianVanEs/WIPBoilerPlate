import React from 'react';
import ReactDOM from 'react-dom';

import Header from './components/header.es6';
import Menu from './components/menu.es6';

import Home from './components/home.es6';
import Factions from './components/factions.es6';

class App extends React.Component{
  render(){
    return (
      <main>
        <Header />
        <Menu />
        <Factions />
      </main>
    );
  }
}

ReactDOM.render(<App />, document.getElementById("app"));
