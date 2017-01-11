# Table Cookie

Use Plugin: [bootstrap-table-cookie](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/cookie)

## Usage

```html
<script src="extensions/cookie/bootstrap-table-cookie.js"></script>
```

## Options

### cookie

* type: Boolean
* description: Set true to save the state of a table (its paging position, ordering state, records per page).
* default: `false`

### cookieExpire

* type: String
* description: You must set this property if cookie option is enable to know when will expire the cookie created. Must use this format: 'number{letter}' like '2h', in the letter position
               		you can use: 's','mi','h','d','m','y', these means: 'seconds', 'minutes', 'hours', 'days', 'months', 'years'.
* default: `2h`

### cookiePath

* type: String
* description: you can tell the browser what path the cookie belongs to. By default, the cookie belongs to the current page.
* default: `null`

### cookieDomain

* type: String
* description: This is the website domain, with the www. prefix removed.
* default: `null`

### cookieSecure

* type: Boolean
* description: This property keeps cookie communication limited to encrypted transmission, directing browsers to use cookies only via secure/encrypted connections.
* default: `null`

### cookieIdTable

* type: String
* description: You must set this property if the cookie property is enabled to set an unique cookie with an identifier for each table in your page or project. You must set this property because we need create cookies with an identifier.
* default: ``

### cookiesEnabled

* type: Array
* description: Set this array with the table properties (sortOrder, sortName, pageNumber, pageList, columns, searchText, filterControl) that you want to save
* default: `['bs.table.sortOrder', 'bs.table.sortName', 'bs.table.pageNumber', 'bs.table.pageList', 'bs.table.columns', 'bs.table.searchText', 'bs.table.filterControl']`

## This plugin saves

* Sort order
* Page number
* Page number from the list
* Visible columns
* Search text