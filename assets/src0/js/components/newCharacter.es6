import React from 'react';

export default class NewCharacter extends React.Component{
  constructor(){
    super();

    this.firstName = "";
    this.lastName = "";
    this.occupation = "";
    this.streamer = "";
    this.avatar = "";
  }

  submitDetails(){
    const formData = new FormData();
    formData.append("first_name", this.firstName);
    formData.append("last_name", this.lastName);
    formData.append("occupation", this.occupation);
    formData.append("streamer", this.streamer);
    formData.append("avatar", this.avatar);
    fetch('./assets/src/php/addCharacter.php', {
      method: 'post',
      body: formData
    })
    .then(response => {
      return response.json();
    })
    .then(json => {
      console.log(json)
    })
  }

  render(){
    return (
      <div className="add-character">
        <div className="avatar">
          <img className="preview-avatar" />
          <input className="input-avatar" name="avatar" type="file" onChange={event => this.avatar = event.target.files[0]} />
        </div>
        <div className="names">
          <input name="firstname" className="name" type="text" placeholder="firstname" onChange={event => {this.firstName = event.target.value}} />
          <input name="lastname" className="name" type="text" placeholder="lastname" onChange={event => this.lastName = event.target.value} />
        </div>
        <input name="occupation" className="occupation" placeholder="occupation" type="text" onChange={event => this.occupation = event.target.value} /> <br/>
        <button onClick={() => this.submitDetails()}>submit</button>
        <div className="twitch">
          <img className="twitch-icon" src="./assets/src/img/icons/twitch.svg" />
          <input name="streamer" placeholder="twitch display name" type="text" onChange={event => this.streamer = event.target.value} />
          <div className="filler"> </div>
        </div>
      </div>
    );
  }
}
