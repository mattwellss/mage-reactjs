var Person = React.createClass({
    handleClick: function () {
        alert(this.props.name);
    },
    render: function () {
        return (
            React.createElement('input', {
                onClick: this.handleClick,
                value: 'Hello',
                type: 'button'
            }));
    }
});
