# EngineRoom Junction Box Connector
The EngineRoom Junction Box Connector's purpose is to connect to a 
third party API and fetch data.

The connector is a Laravel Package that will be used within the 
EngineRoom Junction Box.

## Building a Connector
You'll need to configure your own ServiceProvider under [src/YourServiceProvider](/src/YourServiceProvider.php) paying close
attention to the `register` method which allows you to bind your
connector.

You'll also need to build your connector class by implementing the 
`ConnectorInterface` interface.

> NOTE: The term `YourConnector` should be changed to the service
or API description, that ultimately identifies this package
