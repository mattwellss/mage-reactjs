# Mpw_ReactJs

ReactJS components rendered on your server with your Magento data!

## Installation

The module currently only exists as a proof-of-concept and probably can't easily be installed and used within a Magento instance, so this guide will apply to running the contents of `example/`.

### Download the source

`git clone https://github.com/mattwellss/mage-reactjs` into your favorite "projects" folder.

### Install dependencies

From the root of the project, run `composer install`. This will install Magento and its dependencies and the tools necessary to move it out of `vendor/` and into `tmp/`. From `example/node-renderer/` run `npm install`. This will install the dependencies for the Node.js server that turns Magento data into HTML.

### Configuration

Once the dependencies exist, the simplest way to set up Magento's database is to import the sample data. Install MySQL (this README assumes you can do that yourself), and create a database called `magento`. Sonassi has put a stripped-down version of the CE data on a GitHub repository, so we can grab that and install it:
```
curl -s https://raw.githubusercontent.com/sonassi/magento-sample-data/1.9.0.0/magento_sample_data_for_1.9.0.0.sql > sample_data.sql
mysql magento < sample_data.sql
```

Now we must configure Magento by crafting a believable `app/etc/local.xml`. Here's a sample.
```
<config>
    <global>
        <install>
            <date>2015</date>
        </install>
        <crypt>
            <key></key>
        </crypt>
        <disable_local_modules>false</disable_local_modules>
        <resources>
            <db>
                <table_prefix></table_prefix>
            </db>
            <default_setup>
                <connection>
                    <host>localhost</host>
                    <username>root</username>
                    <password></password>
                    <dbname>magento</dbname>
                    <initStatements><![CDATA[SET NAMES utf8]]></initStatements>
                    <model>mysql4</model>
                    <type>pdo_mysql</type>
                    <pdoType></pdoType>
                    <active>1</active>
                </connection>
            </default_setup>
        </resources>
    </global>
</config>
```
There are other important pieces in local xml, but the `default_setup/connection` node is necessary to create a MySQL connection that Magento can use to initialize a store. Now, while **keeping a local copy around in case your Magento core files are deleted and replaced**, put the file in `tmp/mage/app/etc/local.xml`.

The last step is to ensure that the templates for `Mpw_ReactJs` are accessible to Magento. Create a symbolic link from `/full/path/to/frontend/base/default/templates/reactjs` to Magento's `/full/path/to/magento's/frontend/base/default/reactjs`.

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
