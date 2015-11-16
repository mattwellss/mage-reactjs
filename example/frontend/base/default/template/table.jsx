/**!
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 *
 * Additions Copyright (c) 2015, Matthew Wells
 */
var React = require('react');

var Table = React.createClass({
  render: function () {
    return (
      React.DOM.table(null, React.DOM.tbody(null,
        this.props.data.map(function (row, i) {
          return (
            React.DOM.tr({key: i},
              row.map(function (cell, j) {
                return React.DOM.td({key: i+''+j}, cell);
              })));
        }))));
  }});

module.exports = Table;
