# Mpw_ReactJs

ReactJS components rendered on your server with your Magento data!

## Installation

The module currently only exists as a proof-of-concept and probably can't easily be installed and used within a Magento instance, so this guide will apply to running the contents of `example/`.

### Download the source

`git clone https://github.com/mattwellss/mage-reactjs` into your favorite "projects" folder.

### Install dependencies

From the root of the project, run `composer install`. This will install Magento and its dependencies and the tools necessary to move it out of `vendor/` and into `tmp/`. From `example/node-renderer/` run `npm install`. This will install the dependencies for the Node.js server that turns Magento data into HTML.

### Run the example

Start a PHP built-in server from `example/` like so:
```
php -S 127.0.0.1:8001 ./example.php
```

Start a Node.js (express) server from `example/node-renderer/`:
```
node server.js
```

Now requests to `127.0.0.1:8001` will serve the example page!

## Support

Once you have determined that your issue hasn't already been solved by a closed issue, please open a new one at `https://github.com/mattwellss/mage-reactjs/issues`. You can also react me at `twitter.com/mattwellss` if you want to help me up my Twitter game.
