# Docs and Info coming soon...

This is very much a work in progress and proof of concept exploration. It is 
possible it will die on the vine or be transformed to a production 
implementation based on my findings.

### Todo
 * Add a pagination Action Helper
    * Response control for pagination: `Range: items=0-24`
    * Request control for pagination:  `Content-Range: items 0-24/66`
 * Add a header Action Helper
 * Add a sorting Action Helper
    * `/FooObject/?foo=value1&sortBy=+foo,-bar`
    * `/FooObject/?foo=value1&sort(+foo,-bar)`
 * Add an oauth/authentication plugins
 * Implement a JSON Referencing action helper.
    * http://www.sitepen.com/blog/2008/06/17/json-referencing-in-dojo/