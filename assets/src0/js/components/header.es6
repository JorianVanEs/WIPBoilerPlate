import React from 'react';

import UserSegment from './UserSegment.es6';

export default class Menu extends React.Component{
  constructor(){
    super();
    this.toggleElement = false;
  }

  render(){
    return (
      <div className="header">
        <UserSegment />
      </div>
    );
  }
}
