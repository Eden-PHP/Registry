![logo](http://eden.openovate.com/assets/images/cloud-social.png) Eden Registry
====
[![Build Status](https://api.travis-ci.org/Eden-PHP/Registry.svg)](https://travis-ci.org/Eden-PHP/Registry)
====

 - [Install](#install)
 - [Introduction](#intro)
 - [API](#api)
    - [get](#get)
    - [getArray](#getArray)
    - [isKey](#isKey)
    - [remove](#remove)
    - [set](#set)
 - [Contributing](#contributing)

====

<a name="install"></a>
## Install

`composer install eden/registry`

====

<a name="intro"></a>
## Introduction

Instantiate registry in this manner.

```
$registry = eden('registry');
```

====

<a name="api"></a>
## API

==== 

<a name="get"></a>

### get

Gets a value given the path in the registry. 

#### Usage

```
eden('registry')->get(scalar[, scalar..] $key);
```

#### Parameters

 - `scalar[, scalar..] $key` - The registry path; yea i know this is wierd

Returns `mixed`

#### Example

```
eden('registry')->get('foo', 'bar');
```

==== 

<a name="getArray"></a>

### getArray

Returns the raw array recursively 

#### Usage

```
eden('registry')->getArray(bool $modified);
```

#### Parameters

 - `bool $modified` - whether to return the original data

Returns `array`

#### Example

```
eden('registry')->getArray();
```

==== 

<a name="isKey"></a>

### isKey

Checks to see if a key is set 

#### Usage

```
eden('registry')->isKey(*scalar[,scalar..] $key);
```

#### Parameters

 - `*scalar[, scalar..] $key` - The registry path; yea i know this is wierd

Returns `bool`

#### Example

```
eden('registry')->isKey('foo', 'bar');
```

==== 

<a name="remove"></a>

### remove

Removes a key and everything associated with it 

#### Usage

```
eden('registry')->remove(*scalar[,scalar..] $key);
```

#### Parameters

 - `*scalar[,scalar..] $key` - The registry path; yea i know this is wierd

Returns `Eden\Registry\Index`

#### Example

```
eden('registry')->remove('foo', 'bar');
```

==== 

<a name="set"></a>

### set

Creates the name space given the space and sets the value to that name space 

#### Usage

```
eden('registry')->set(*scalar[,scalar..] $key, *mixed $value);
```

#### Parameters

 - `*scalar[,scalar..] $key` - The registry path; yea i know this is wierd
 - `*mixed $value` - The value to set

Returns `Eden\Registry\Index`

#### Example

```
eden('registry')->set('foo', 'bar', 'zoo');
```

==== 

<a name="contributing"></a>
#Contributing to Eden

Contributions to *Eden* are following the Github work flow. Please read up before contributing.

##Setting up your machine with the Eden repository and your fork

1. Fork the repository
2. Fire up your local terminal create a new branch from the `v4` branch of your 
fork with a branch name describing what your changes are. 
 Possible branch name types:
    - bugfix
    - feature
    - improvement
3. Make your changes. Always make sure to sign-off (-s) on all commits made (git commit -s -m "Commit message")

##Making pull requests

1. Please ensure to run `phpunit` before making a pull request.
2. Push your code to your remote forked version.
3. Go back to your forked version on GitHub and submit a pull request.
4. An Eden developer will review your code and merge it in when it has been classified as suitable.