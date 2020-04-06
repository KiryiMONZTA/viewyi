# Kiryi's VIEWYI
A native PHP view engine for web applications..

## Installation
```bash
composer require kiryi/viewyi
```

## Usage
First initialize the engine in one of three possible ways. See [Initialization](#initialization) for more information. Then use the provided functions as described below. Also build your templates as described in the section [Templating](#templating).

## Constructor Definition

```php
__construc($config)
```
### Parameters
**config**  
Optional configuration array or filepath to custom configuration INI file. If nothing is provided, default (*config/viewyi.ini*) is used ([more information](#initialization)). 

## Method Definition *assign*
```php
assign(string $key, $value): void
```
Assigns a variable to the view's data object.
### Parameters
**key**  
The variable's key.

**key**  
The variable's value.

## Method Definition *reset*
```php
reset(): void
```
Resets the view's data object. Often not necessary to use.

## Method Definition *render*
```php
render(string $template): string
```
Renders the current view (HTML page). Have to be called before `display`.
### Parameters
**template**  
The template name to use as render base.

### Return Values
Returns the fully rendered view.

## Method Definition *display*
```php
display(string $headTemplate, string $title): void
```
Finally displays the whole HTML page. It is necessary to call `render` before at least one time. The rendered view is always embeded to the page's HTML body element. `display` can only be called once.
### Parameters
**headTemplate**  
The template name to embed into the HTML page's head element.

**title**  
The title of the current page set to the HTML page's title element.

## Initialization
You have to provide the engine at least three parameters as well as an optional fourth.

**baseUrl**  
The base URL of your web application.

**imagePath**  
The image directory path relative your base URL.

**templateDirectory**  
The template directory path relative to your project's root directory.

**templateFileExtension (optional)**  
Optional file extension of your template files if you want to use something else than the default `.php`.

The parameters can be set up by using the standard configuration file `{PROJECTSROOTDIR}/config/viewyi.ini` with the following contents:
```ini
[viewyi]
baseUrl = {YOURBASEURL}
imagePath = {YOURIMAGEDIRECTORYPATH}
templateDirectory = {YOURTEMPLATEDIRECTORYPATH}
templateFileExtension = {YOURFILEEXTENSION}
```
Or by passing another INI file path to the engines's constructor with the same contents. The path has to be relative to your project's root directory:
```php
$viewyi = new \Kiryi\Viewyi\Engine('{YOURCUSTOMFILEPATH}');
```
Or by passing an array with the three to four parameters to the constructor:
```php
$viewyi = new \Kiryi\Viewyi\Engine([
    'baseUrl' => '{YOURBASEURL}',
    'imagePath' => '{YOURIMAGEDIRECTORYPATH}',
    'templateDirectory' => '{YOURTEMPLATEDIRECTORYPATH}',
    'templateFileExtension' => '{YOURFILEEXTENSION}',
]);
```

## Templating
- Use native PHP templates.
- Therefore you may use any PHP alternative syntax control structure.
- Print any data you have assigned with `<?=$d->{YOURVARIABLEKEY}?>`.
- Build links with your base URL with `<a href='<?=$a>{YOURLINKRELATIVETOBASEURL}'>Linktext<a>`.
- Include images with `<img src='<?=$i?>{YOURIMAGEINYOURIMAGEDIRECTORY}` />.

## Example
*configuration/config.ini*
```ini
[viewyi]
baseUrl = https://viewyi-example.com
imagePath = img
templateDirectory = src/View
templateFileExtension = .tpl.php
```
*src/View/head.tpl.php*
```html
<link rel='stylesheet' href='<?=$a?>css/style.min.css' />
<link rel='shortcut icon' href='<?=$i?>favicon.png' />

```
*src/View/home.tpl.php*
```html
<img src='<?=$i?>logo.png' />
<h1><?=$d->headline?></h1>
<?php foreach($d->paragraphs as $paragraph): ?>
<p><?=$paragraph?></p>
<?php endforeach; ?>

```
*src/Controller/HomeController.php*
```php
$viewyi = new \Kiryi\Viewyi\Engine('configuration/config.ini');
$viewyi->assign('headline', 'Welcome To My Page');
$viewyi->assign('paragraphs', [
    'I want to show you the VIEWYI View Engine.',
    'It is very easy to use.',
    'Just follow this example.',
]);
$viewyi->render('home');
$viewyi->display('head', 'Welcome');
```
will generate the HTML5 page:
```html
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='https://viewyi-example.com/css/style.min.css' />
<link rel='shortcut icon' href='https://viewyi-example.com/img/favicon.png' />
<title>Welcome</title>
</head>
<body>
<img src='https://viewyi-example.com/img/logo.png' />
<h1>Welcome To My Page</h1>
<p>I want to show you the VIEWYI View Engine.</p>
<p>It is very easy to use.</p>
<p>Just follow this example.</p>
</body>
</html>
```
