var React = require('react');

var MyClock = React.createClass({
    getInitialState: function () {
        return { time: new Date(this.props.timestamp * 1000) };
    },
    tick: function () {
        this.setState({
            time: new Date()
        });
    },
    componentDidMount: function () {
        this.ticker = setInterval(this.tick, 1000);
    },
    componentWillUnmount: function () {
        clearInterval(this.ticker);
    },
    render: function () {
        return (
            React.createElement('div',
                null,
                'The time is ' + this.state.time));
    },
});

module.exports = MyClock;
