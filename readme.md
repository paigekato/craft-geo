# Geo Plugin for Craft 2 🌎🔍

A simple plugin to get information about your users location. Forked from [Luke Holder's Geo Plugin](https://github.com/lukeholder/craft-geo) for Craft 2. This plugin utilizes [IP Stack's API](https://ipstack.com/). A key is required.

### Getting Started:

- Put the geo folder in your craft plugin folder.
- Create a geo.php file in your craft/config folder and include API key. An example of this file is found in the geo folder.



```twig
{# Returns array of ip data and saves to a cookie
so subsequent api calls are not made, but just 
looked up in the cache #}
{% set data = craft.geo.data(true) %}

{# You can then access the data like this: #}
{{ data.is_eu }}
{{ data.country_code }}

{# Returns boolean if the user is in the EU #}
{{ craft.geo.isEu() }}
```

Variables available in craft twig templates:
```twig
country_code: {{ craft.geo.data.country_code }}
is_eu: {{ craft.geo.isEu() }}
```


When in devMode, the default IP address can be configured by creating a geo.php file in your craft/config folder. You can also set the cookie name in which the returned data is saved and your IP API key.

## Licence

MIT.
Pull requests welcome.