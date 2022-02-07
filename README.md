# Craft CMS 3.x, Craft Commerce 3.x, Tailwind CSS, VueJS and AlpineJS

This is a [Craft CMS 3.x](https://github.com/craftcms/cms) and [Craft Commerce 3.x](https://github.com/craftcms/commerce) boilerplate [Myth Digital](https://myth.digital) use internally for projects. Originally inspired by [Made By Shape](https://madebyshape.co.uk) Craft 3 boilerplate.

## Requirements

- PHP 7.3+
- Composer 2.x.x

## Install

1. `composer create-project myth-digital/craft-3-stack`
2. Don't run, `./craft setup`, instead copy and edit the `.env.example` file.
3. Once the `.env` is completed, run `./craft install`
4. Generate the security key using `./craft setup/security-key`
5. Replace newly created config/project with config/project-stack folder (or config/project-stack-commerce if you want commerce) `rm -rf config/project && mv config/project-stack config/project` or `rm -rf config/project && mv config/project-stack-commerce config/project`
6. Run the project sync command to sync the db config `./craft project-config/apply`

### Remove Commerce

The stack ships with Commerce. The following removal script should be ran if you do not need Commerce.

[] To Do - Build script

## npm Scripts

`npm run dev`
Your go to for local development

`npm run prod`
Generates production assets (Minify, favicon etc). Perfect for running on server.

`npm run setup`
If project already exists, this will pull, migrate and apply project config and run dev tasks


## Whats included

- [Craft CMS 3.x](https://github.com/craftcms/cms)
- CSS
   - [Tailwind CSS 2.0.x](https://tailwindcss.com/)
- Javascript
   - [Vue.js](https://github.com/vuejs)
   - [Alpine.js](https://github.com/alpinejs/alpine)
   - [loadCSS](https://github.com/filamentgroup/loadCSS)
   - [Javascript Cookie](https://github.com/js-cookie/js-cookie)
   - [Vanilla Lazyload](https://github.com/verlok/vanilla-lazyload)
- Templates
   - [Blocks](https://github.com/myth-digital/craft-3-stack#blocks)
   - [Components](https://github.com/myth-digital/craft-3-stack#components)
   - Pages (With dynamic page types)
   - Email
   - Exceptions
   - Plugins
      - Freeform
- Config
   - Customised `.env` file
   - Customised `general.php`
   - Project Config (Using `config/project.yaml`)
   - Plugin configs:
      - Asset Rev
      - Blitz
      - Freeform
      - Imager X
      - Minify
      - SEOMatic
- Plugins
   - Asset Rev
   - Blitz
   - Default Dashboard
   - Imager X
   - Link Field
   - Minify
   - Redactor
   - SEOMatic
   - DO Spaces
   - CP CSS
   - Super Table
- Extras
   - Scripts (To pull assets, db etc from different environments)
   - .gitignore
      - Packages
      - SASS
      - Javascript
      - OS Files
      - Craft CMS
      - Caching
      - Asset Source Folders
      - Log files
      - Editor directories and files

## Terminology

### Components
Components are small bits of a template, e.g. a button, input field that then either make up a block or a full template. Use the `components` folder and name each component file by it's use case e.g. `inputField.twig`.

Make sure to describe each component at the top of each component file so other developers know how it is used. If the component accepts any attributes, make sure you include a description of these at the top of each component (Camel Case) file (See the `components/_example.twig`) file.

### Blocks
Blocks are large chunks of markup, or made up of smaller components. E.g. a block could be a form, with button and input field components included. Use the `blocks` folder and name each component file (Camel Case) by it's use case e.g. `largeForm.twig` (If a SASS file exists for a block, use the same file name).

Blocks ideally should be selectable via a Matrix Field so CP users can pick and choose these per template. In some cases this might not be possible though, e.g. if the page is dynamically generated.

## Roadmap

[] Add Google Workbox
[] rel="preload" fonts via a Webpack task
[] Move some Twig components in to VueJS 
