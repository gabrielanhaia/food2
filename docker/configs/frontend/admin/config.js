/**
 * Application configuration
 * @type {{appName: string, version: string, backendURI: string, environment: string}}
 */

function RemoveLastDirectoryPartOf(the_url)
{
    var the_arr = the_url.split('/');
    the_arr.pop();
    the_arr.pop();
    return( the_arr.join('/') + '/' );
}

config = {
    // App setups
    appName: "Admin Test Platform", //This you should change
    defaultStatePath: '/', //change it in case you want to redirect to a different defaultPath (#!/)
    version: "1.0.0", //This you should change
    env: "APP_ENV", //This you can change
    defaultLanguage: ['en'], //This you can change (?)
    fallbackLanguage: ['en'],
    languages: ['en'], // Keep the original language at least
    cookieExpiry: 365,

    //Backend definitions
    backend: null, //Please, just change it if mocking tests
    backendHost: RemoveLastDirectoryPartOf(document.getElementsByTagName('base')[0].href), //This you can change
    backendPath: 'api/admin', //This you can change
    backendApi: "swagger.yml", //used to create the mock server and the client
    baseUrl: document.getElementsByTagName('base')[0].href,

};

/**
 * Used by the controllers
 * Overwrite this when mocking or testing an specific server
 */
config.backend = config.backend ? config.backend : config.backendHost;

if (config.backendPath) {
    config.backend = config.backend + config.backendPath + '/';
}
