# dto-codegen
This DTO code generator was developed to generate a very simple DTOs that can be simply adjusted to your project needs.

## Supported types
1. JSON - generate DTO from json response.
2. Swagger - generates DTO from swagger schema.

## Supported languages
At this moment only php is supported.

## Available options
`--config-file CONFIG-FILE` - path to configuration yaml file

## Yaml options
`fromFile` - link or path to JSON file.

`fromString` - JSON string.

`parser` - `swagger` or `json` parsers are available.

`generator` - specify what generator to use.

`namespace` - this namespace will be added to each generated DTO.

`classname_case`|`property_case` - Specify to which case convert names.

 Available converter types:
 * `none`
 * `lowercase`
 * `UPPERCASE`
 * `lowerCamelCase`
 * `UpperCamelCase`
 * `snake_case`
 
### Example of configuration file
```yml
fromFile: swagger-api.json # can be URL to json.
#fromString: '{"json":true}' # Either `fromFile` or `fromString` should be used at same time.
parser: swagger # swagger or json are available.
#generator: php
namespace: \App\DTO # this namespace will be added to each generated DTO.
classname_case: 'UpperCamelCase' # Specify to which case convert names.
property_case: 'lowerCamelCase'
prepend_namespaces: true # Indicates whether namespace should be prepended to @var docbloc (@var \App\DTO\Object or @var Object)
output_dir: './output'
```
