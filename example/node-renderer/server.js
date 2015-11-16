'use strict';

var React = require('react');
var ReactDOMServer = require('react-dom/server');
var express = require('express');
var path = require('path');
var bodyParser = require('body-parser');
var browserify = require('browserify');
var tmp = require('tmp');
var fs = require('fs');

var app = express();

var components = {};
var prebundled = {};

app.use(bodyParser.json());
app.post('/render', function (request, response) {
    try {
        let component = getView(request.body.template);
        let props = request.body || null;
        response.status(200).send(
            ReactDOMServer.renderToStaticMarkup(
                React.createElement(component, request.body.props)));
    } catch (err) {
        console.log(err);
        response.status(500).send(JSON.stringify(err));
    }
});

app.post('/bundle', function (request, response) {
    let inlineRenderedComponents = [];
    let components = request.body.map(function (data) {
        let componentFilename = path.resolve('../' + data.template);
        data.template = componentFilename;
        inlineRenderedComponents.push(data);
        return componentFilename;
    });
    let bundle = getBundle(components);
    bundle.add(makeTempAppjs(inlineRenderedComponents));

    bundle.transform({
        global: true
    }, 'uglifyify').bundle().pipe(response);
});

function getBundle(components) {
    return browserify(components);
    // let componentKey = components.sort().join();
    // if (!prebundled[componentKey]) {
    //     return prebundled[componentKey];
    //     prebundled[componentKey] = browserify(components);
    // }

    // return prebundled[componentKey];
}

function getView (templatePath) {
    let view = path.resolve('../' + templatePath);
    components[view] || (components[view] = require(view));

    return components[view];
}

function makeTempAppjs (inlineRenderedComponents) {
    let filePath = tmp.fileSync({dir: '.', postfix: '.js'}).name;
    let stream = fs.createWriteStream(filePath);

    let code = "var React = require('react');\nvar ReactDOM = require('react-dom');\n";

    inlineRenderedComponents.forEach(function (component) {
        code += "var component = require('" + component.template + "');" +
                "ReactDOM.render(" +
                    "React.createElement(component, " +
                        JSON.stringify(component.props) + ")," +
                    component.destination + ");";
    });
    stream.write(code);

    return filePath;
}

tmp.setGracefulCleanup();
app.listen(3000);
