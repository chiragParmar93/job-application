import React, { Component } from "react";
import "./App.css";
import { BrowserRouter as Router, Route } from "react-router-dom";
import Job from "./container/job";

export default class App extends Component {
  render() {
    return (
      <div className="App">
        <Router>
          <Route exact path="/" component={Job}></Route>
        </Router>
      </div>
    );
  }
}
