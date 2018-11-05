# Geo Plugin for Craft 2 🌎🔍

A simple plugin to get information about your users location. Forked from [Luke Holder's Geo Plugin](https://github.com/lukeholder/craft-geo) for Craft 2. This plugin utilizes [IP Stack's API](https://ipstack.com/). A key is required.

### Getting Started:

- Put the geo folder in your craft plugin folder.
- Create a geo.php file in your craft/config folder and include API key. An example of this file is found in the geo folder.



```twig
{# Pass in true/false to cache the users 
location from their IP, so subsequent api 
calls are not made, but just looked up 
in the cache  #}

{# Returns array of ip data #}
{% set data = craft.geo.data(true) %}

{# You can then access the data like this: #}
{{ data.is_eu }}

{# Returns boolean if the user is in the EU #}
{{ craft.geo.isEu() }}
```

Variables available in craft twig templates:

```twig
country_code: {{ craft.geo.data.country_code }}
is_eu: {{ craft.geo.isEu() }}
cached: {{ craft.geo.data.cached }}
```


When in devMode, the default IP address is configurable by creating a geo.php file in your craft/config folder. An example of this file is found in the geo-examples folder.

## Licence

MIT.

Pull requests welcome.