# Geo Plugin for Craft CMS 🌐

A simple plugin to get information about your users location. Forked from [Luke Holder's Geo Plugin](https://github.com/lukeholder/craft-geo) for Craft 2.

### Getting Started:

- Put the geo folder in your craft plugins folder.
- Create a geo.php file in your craft/config folder. An example of this file is found in the geo-examples folder.



```twig
{#
 # The following will cache the users location from their IP, so subsequent
 # api calls are not made, but just looked up in the cache:
 #}
{% set data = craft.geo.data(true) %}

{# which is the same as: #}
{% set data = craft.geo.data() %}

{# You can then access the data like this: #}
{{ data.is_eu }}

{# Returns boolean if the user is in the EU #}
{{ craft.geo.isEu() }}
```

Variables available in craft twig templates:

```twig
ip: {{ craft.geo.data.ip }}
is_eu: {{ craft.geo.isEu() }}
country_code: {{ craft.geo.data.country_code }}
cached: {{ craft.geo.data.cached }}
```


When in devMode, the default IP address is configurable by creating a geo.php file in your craft/config folder. An example of this file is found in the geo-examples folder.


## Licence

MIT.

Pull requests welcome.