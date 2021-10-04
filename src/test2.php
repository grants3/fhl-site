<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SmartMenus jQuery Website Menu - Bootstrap 4 Addon - Navbar fixed top</title>




    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- SmartMenus jQuery Bootstrap 4 Addon CSS -->

	<style>/*
 You probably do not need to edit this at all.
 Add some SmartMenus required styles not covered in Bootstrap 4's default CSS.
 These are theme independent and should work with any Bootstrap 4 theme mod.
*/


/* Carets in collapsible mode (make them look like +/- buttons) */
.navbar-nav.sm-collapsible .sub-arrow {
	position: absolute;
	top: 50%;
	right: 0;
	margin: -0.7em 0.5em 0 0;
	border: 1px solid rgba(0, 0, 0, .1);
	border-radius: .25rem;
	padding: 0;
	width: 2em;
	height: 1.4em;
	font-size: 1.25rem;
	line-height: 1.2em;
	text-align: center;
}
.navbar-nav.sm-collapsible .sub-arrow::before {
	content: '+';
}
.navbar-nav.sm-collapsible .show > a > .sub-arrow::before {
	content: '-';
}
.navbar-dark .navbar-nav.sm-collapsible .nav-link .sub-arrow {
	border-color: rgba(255, 255, 255, .1);
}
/* make sure there's room for the carets */
.navbar-nav.sm-collapsible .has-submenu {
	padding-right: 3em;
}
/* keep the carets properly positioned */
.navbar-nav.sm-collapsible .nav-link,
.navbar-nav.sm-collapsible .dropdown-item {
	position: relative;
}


/* Nav carets in expanded mode */
.navbar-nav:not(.sm-collapsible) .nav-link .sub-arrow {
	display: inline-block;
	width: 0;
	height: 0;
	margin-left: .255em;
	vertical-align: .255em;
	border-top: .3em solid;
	border-right: .3em solid transparent;
	border-left: .3em solid transparent;
}
/* point the arrows up for .fixed-bottom navbars */
.fixed-bottom .navbar-nav:not(.sm-collapsible) .nav-link .sub-arrow,
.fixed-bottom .navbar-nav:not(.sm-collapsible):not([data-sm-skip]) .dropdown-toggle::after {
	border-top: 0;
	border-bottom: .3em solid;
}


/* Dropdown carets in expanded mode */
.navbar-nav:not(.sm-collapsible) .dropdown-item .sub-arrow,
.navbar-nav:not(.sm-collapsible):not([data-sm-skip]) .dropdown-menu .dropdown-toggle::after {
	position: absolute;
	top: 50%;
	right: 0;
	width: 0;
	height: 0;
	margin-top: -.3em;
	margin-right: 1em;
	border-top: .3em solid transparent;
	border-bottom: .3em solid transparent;
	border-left: .3em solid;
}
/* make sure there's room for the carets */
.navbar-nav:not(.sm-collapsible) .dropdown-item.has-submenu {
	padding-right: 2em;
}


/* Scrolling arrows for tall menus */
.navbar-nav .scroll-up,
.navbar-nav .scroll-down {
	position: absolute;
	display: none;
	visibility: hidden;
	height: 20px;
	overflow: hidden;
	text-align: center;
}
.navbar-nav .scroll-up-arrow,
.navbar-nav .scroll-down-arrow {
	position: absolute;
	top: -2px;
	left: 50%;
	margin-left: -8px;
	width: 0;
	height: 0;
	overflow: hidden;
	border-top: 7px solid transparent;
	border-right: 7px solid transparent;
	border-bottom: 7px solid;
	border-left: 7px solid transparent;
}
.navbar-nav .scroll-down-arrow {
	top: 6px;
	border-top: 7px solid;
	border-right: 7px solid transparent;
	border-bottom: 7px solid transparent;
	border-left: 7px solid transparent;
}


/* Add some spacing for 2+ level sub menus in collapsible mode */
.navbar-nav.sm-collapsible .dropdown-menu .dropdown-menu {
	margin: .5em;
}


/* Fix SmartMenus sub menus auto width (subMenusMinWidth/subMenusMaxWidth options) */
.navbar-nav:not([data-sm-skip]) .dropdown-item {
	white-space: normal;
}
.navbar-nav:not(.sm-collapsible) .sm-nowrap > li > .dropdown-item {
	white-space: nowrap;
}</style>


  </head>

  <body style="padding-top:80px;">



    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

          <!-- Left nav -->
          <ul class="nav navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#">Dropdown</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item disabled" href="#">Disabled link</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li class="dropdown-divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
                <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">One more separated link</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">A long sub menu</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li><a class="dropdown-item" href="#">One more link</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 1</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 2</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 3</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 4</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 5</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 6</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 7</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 8</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 9</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 10</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 11</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 12</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 13</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 14</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 15</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 16</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 17</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 18</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 19</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 20</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 21</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 22</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 23</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 24</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 25</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 26</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 27</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 28</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 29</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 30</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 31</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 32</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 33</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 34</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 35</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 36</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 37</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 38</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 39</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 40</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 41</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 42</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 43</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 44</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 45</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 46</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 47</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 48</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 49</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 50</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 51</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 52</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 53</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 54</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 55</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 56</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 57</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 58</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 59</a></li>
                        <li><a class="dropdown-item" href="#">Menu item 60</a></li>
                      </ul>
                    </li>
                    <li><a class="dropdown-item" href="#">Another link</a></li>
                    <li><a class="dropdown-item" href="#">One more link</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>

          <!-- Right nav -->
          <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar.html">Default</a></li>
            <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar-static-top.html">Static top</a></li>
            <li class="nav-item active"><a class="nav-link" href="bootstrap-4-navbar-fixed-top.html">Fixed top</a></li>
            <li class="nav-item"><a class="nav-link" href="bootstrap-4-navbar-fixed-bottom.html">Fixed bottom</a></li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#">Dropdown</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li class="dropdown-divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">A sub menu</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><a class="dropdown-item disabled" href="#">Disabled item</a></li>
                    <li><a class="dropdown-item" href="#">One more link</a></li>
                  </ul>
                </li>
                <li><a class="dropdown-item" href="#">A separated link</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </nav>



    <div class="container">

      <div class="jumbotron bg-light">
        <h1>SmartMenus Bootstrap 4 Addon (Navbar fixed top)</h1>
        <p class="lead">Zero config advanced Bootstrap navbars with SmartMenus jQuery and the SmartMenus jQuery Bootstrap 4 Addon.</p>
      </div>

      <p>You just need to include the JS/CSS files on your Bootstrap 4 powered pages and everything should work automatically including full support for your Bootstrap 4 theme. And you also have the power and flexibility of SmartMenus jQuery at hand should you need to tweak or customize anything.</p>

      <h2>Source Code</h2>

      <h3>CSS</h3>
      <p>In addition to Bootstrap's CSS just include the SmartMenus jQuery Bootstrap 4 Addon CSS. It's just static CSS code you don't need to edit at all (and probably shouldn't try to).</p>
      <pre class="border rounded p-3 bg-light">&lt;!-- Bootstrap core CSS -->
&lt;link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<span class="text-success">&lt;!-- SmartMenus jQuery Bootstrap 4 Addon CSS -->
&lt;link href="../addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css" rel="stylesheet"></span></pre>

      <h3>HTML</h3>
      <p><strong class="text-info">Note:</strong> Bootstrap 4 normally uses <code>&lt;div></code> elements as <code>.dropdown-menu</code> containers. But since we are building a multi-level menu tree, we need to replace them with nested <code>&lt;ul></code>/<code>&lt;li></code> elements.</p>
      <pre class="border rounded p-3 bg-light">&lt;!-- Navbar -->
&lt;nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  &lt;div class="container">
    &lt;a class="navbar-brand" href="#">Navbar&lt;/a>
    &lt;button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      &lt;span class="navbar-toggler-icon">&lt;/span>
    &lt;/button>

    &lt;div class="collapse navbar-collapse" id="navbarNavDropdown">
  <span class="text-success">
      &lt;!-- Left nav -->
      &lt;ul class="nav navbar-nav mr-auto">
        &lt;li class="nav-item">&lt;a class="nav-link" href="#">Link&lt;/a>&lt;/li>
        &lt;li class="nav-item">&lt;a class="nav-link" href="#">Link&lt;/a>&lt;/li>
        &lt;li class="nav-item">&lt;a class="nav-link" href="#">Link&lt;/a>&lt;/li>
        &lt;li class="nav-item dropdown">&lt;a class="nav-link dropdown-toggle" href="#">Dropdown&lt;/a>
          &lt;ul class="dropdown-menu">
            &lt;li>&lt;a class="dropdown-item" href="#">Action&lt;/a>&lt;/li>
            &lt;li>&lt;a class="dropdown-item disabled" href="#">Disabled link&lt;/a>&lt;/li>
            &lt;li>&lt;a class="dropdown-item" href="#">Something else here&lt;/a>&lt;/li>
            &lt;li class="dropdown-divider">&lt;/li>
            &lt;li class="dropdown-header">Nav header&lt;/li>
            &lt;li>&lt;a class="dropdown-item" href="#">Separated link&lt;/a>&lt;/li>
            &lt;li class="dropdown">&lt;a class="dropdown-item dropdown-toggle" href="#">One more separated link&lt;/a>
              &lt;ul class="dropdown-menu">
                &lt;li>&lt;a class="dropdown-item" href="#">Action&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">Another action&lt;/a>&lt;/li>
                &lt;li class="dropdown">&lt;a class="dropdown-item dropdown-toggle" href="#">A long sub menu&lt;/a>
                  &lt;ul class="dropdown-menu">
                    &lt;li>&lt;a class="dropdown-item" href="#">Action&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Something else here&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">One more link&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 1&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 2&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 3&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 4&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 5&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 6&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 7&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 8&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 9&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 10&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 11&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 12&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 13&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 14&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 15&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 16&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 17&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 18&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 19&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 20&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 21&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 22&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 23&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 24&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 25&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 26&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 27&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 28&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 29&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 30&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 31&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 32&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 33&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 34&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 35&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 36&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 37&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 38&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 39&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 40&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 41&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 42&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 43&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 44&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 45&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 46&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 47&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 48&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 49&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 50&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 51&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 52&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 53&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 54&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 55&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 56&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 57&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 58&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 59&lt;/a>&lt;/li>
                    &lt;li>&lt;a class="dropdown-item" href="#">Menu item 60&lt;/a>&lt;/li>
                  &lt;/ul>
                &lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">Another link&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">One more link&lt;/a>&lt;/li>
              &lt;/ul>
            &lt;/li>
          &lt;/ul>
        &lt;/li>
      &lt;/ul>

      &lt;!-- Right nav -->
      &lt;ul class="nav navbar-nav">
        &lt;li class="nav-item">&lt;a class="nav-link" href="bootstrap-4-navbar.html">Default&lt;/a>&lt;/li>
        &lt;li class="nav-item">&lt;a class="nav-link" href="bootstrap-4-navbar-static-top.html">Static top&lt;/a>&lt;/li>
        &lt;li class="nav-item active">&lt;a class="nav-link" href="bootstrap-4-navbar-fixed-top.html">Fixed top&lt;/a>&lt;/li>
        &lt;li class="nav-item">&lt;a class="nav-link" href="bootstrap-4-navbar-fixed-bottom.html">Fixed bottom&lt;/a>&lt;/li>
        &lt;li class="nav-item dropdown">&lt;a class="nav-link dropdown-toggle" href="#">Dropdown&lt;/a>
          &lt;ul class="dropdown-menu">
            &lt;li>&lt;a class="dropdown-item" href="#">Action&lt;/a>&lt;/li>
            &lt;li>&lt;a class="dropdown-item" href="#">Another action&lt;/a>&lt;/li>
            &lt;li>&lt;a class="dropdown-item" href="#">Something else here&lt;/a>&lt;/li>
            &lt;li class="dropdown-divider">&lt;/li>
            &lt;li class="dropdown-header">Nav header&lt;/li>
            &lt;li class="dropdown">&lt;a class="dropdown-item dropdown-toggle" href="#">A sub menu&lt;/a>
              &lt;ul class="dropdown-menu">
                &lt;li>&lt;a class="dropdown-item" href="#">Action&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">Another action&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">Something else here&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item disabled" href="#">Disabled item&lt;/a>&lt;/li>
                &lt;li>&lt;a class="dropdown-item" href="#">One more link&lt;/a>&lt;/li>
              &lt;/ul>
            &lt;/li>
            &lt;li>&lt;a class="dropdown-item" href="#">A separated link&lt;/a>&lt;/li>
          &lt;/ul>
        &lt;/li>
      &lt;/ul>
  </span>
    &lt;/div>
  &lt;/div>
&lt;/nav></pre>

      <h3>JavaScript</h3>
      <p>In addition to Bootstrap's JavaScript just include SmartMenus jQuery and the SmartMenus jQuery Bootstrap 4 Addon. The default options used in <code>jquery.smartmenus.bootstrap.js</code> should work well for all. However, you can, of course, tweak them if you like.</p>
      <pre class="border rounded p-3 bg-light">&lt;!-- jQuery first, then Popper.js, then Bootstrap JS -->
&lt;script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">&lt;/script>
&lt;script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">&lt;/script>
&lt;script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">&lt;/script>

<span class="text-success">&lt;!-- SmartMenus jQuery plugin -->
&lt;script type="text/javascript" src="../jquery.smartmenus.js">&lt;/script>

&lt;!-- SmartMenus jQuery Bootstrap 4 Addon -->
&lt;script type="text/javascript" src="../addons/bootstrap-4/jquery.smartmenus.bootstrap-4.js">&lt;/script></span></pre>

      <h2>Quick customization</h2>

      <h3><code>data-*</code> attributes</h3>
      <p>The Bootstrap 4 addon introduces the following additional <code>data-*</code> attributes which can be set to any <code>.navbar-nav</code>:</p>
      <ul>
        <li><code>data-sm-skip</code> - this will tell the script to skip this navbar and not apply any SmartMenus features to it so it will behave like a regular Bootstrap navbar.</li>
        <li><code>data-sm-skip-collapsible-behavior</code> - this will tell the script to not apply SmartMenus' specific behavior to this navbar in collapsible mode (mobile view). Bootstrap's behavior for navbars in collapsible mode is to use the whole area of the parent items just as a toggle button for their sub menus and thus it's impossible to set a link to the parent items that can be followed on click/tap. SmartMenus' behavior is to add a separate +/- sub menus toggle button to parent items and thus allows the link of the parent items to be activated on the second click/tap (the first click/tap displays the sub menu if it's not visible). If you need even further control, you can check the <a href="https://www.smartmenus.org/docs/#collapsibleBehavior"><code>collapsibleBehavior</code></a> SmartMenus option which can be set in a <a href="https://www.smartmenus.org/docs/#data-sm-options"><code>data-sm-options</code></a> attribute.</li>
      </ul>

      <h3>Options</h3>
      <p>The following additional option can be set in a <a href="https://www.smartmenus.org/docs/#data-sm-options"><code>data-sm-options</code></a> attribute:</p>
      <ul>
        <li><code>bootstrapHighlightClasses: 'text-dark bg-light'</code> - CSS class(es) for highlighting expanded parent dropdown items.</li>
      </ul>
      <p><a href="https://www.smartmenus.org/docs/#options">Check the docs</a> for a complete list of all the available SmartMenus options.</p>

      <h3>API</h3>
      <p>The following methods are available:</p>
      <ul>
        <li><code>jQuery.SmartMenus.Bootstrap.init()</code> - reinit the addon. Useful if you add any navbars dynamically on your page and need to init them at any time (all navbars are normally initialized ondomready).</li>
      </ul>

      <hr />

      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="index.html">&laquo; Back to main demo</a></li>
      </ul>

    </div> <!-- /container -->




    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!-- SmartMenus jQuery plugin -->
    <script >

    (function(factory) {
    	if (typeof define === 'function' && define.amd) {
    		// AMD
    		define(['jquery'], factory);
    	} else if (typeof module === 'object' && typeof module.exports === 'object') {
    		// CommonJS
    		module.exports = factory(require('jquery'));
    	} else {
    		// Global jQuery
    		factory(jQuery);
    	}
    } (function($) {

    	var menuTrees = [],
    		mouse = false, // optimize for touch by default - we will detect for mouse input
    		touchEvents = 'ontouchstart' in window, // we use this just to choose between toucn and pointer events, not for touch screen detection
    		mouseDetectionEnabled = false,
    		requestAnimationFrame = window.requestAnimationFrame || function(callback) { return setTimeout(callback, 1000 / 60); },
    		cancelAnimationFrame = window.cancelAnimationFrame || function(id) { clearTimeout(id); },
    		canAnimate = !!$.fn.animate;

    	// Handle detection for mouse input (i.e. desktop browsers, tablets with a mouse, etc.)
    	function initMouseDetection(disable) {
    		var eNS = '.smartmenus_mouse';
    		if (!mouseDetectionEnabled && !disable) {
    			// if we get two consecutive mousemoves within 2 pixels from each other and within 300ms, we assume a real mouse/cursor is present
    			// in practice, this seems like impossible to trick unintentianally with a real mouse and a pretty safe detection on touch devices (even with older browsers that do not support touch events)
    			var firstTime = true,
    				lastMove = null,
    				events = {
    					'mousemove': function(e) {
    						var thisMove = { x: e.pageX, y: e.pageY, timeStamp: new Date().getTime() };
    						if (lastMove) {
    							var deltaX = Math.abs(lastMove.x - thisMove.x),
    								deltaY = Math.abs(lastMove.y - thisMove.y);
    		 					if ((deltaX > 0 || deltaY > 0) && deltaX <= 4 && deltaY <= 4 && thisMove.timeStamp - lastMove.timeStamp <= 300) {
    								mouse = true;
    								// if this is the first check after page load, check if we are not over some item by chance and call the mouseenter handler if yes
    								if (firstTime) {
    									var $a = $(e.target).closest('a');
    									if ($a.is('a')) {
    										$.each(menuTrees, function() {
    											if ($.contains(this.$root[0], $a[0])) {
    												this.itemEnter({ currentTarget: $a[0] });
    												return false;
    											}
    										});
    									}
    									firstTime = false;
    								}
    							}
    						}
    						lastMove = thisMove;
    					}
    				};
    			events[touchEvents ? 'touchstart' : 'pointerover pointermove pointerout MSPointerOver MSPointerMove MSPointerOut'] = function(e) {
    				if (isTouchEvent(e.originalEvent)) {
    					mouse = false;
    				}
    			};
    			$(document).on(getEventsNS(events, eNS));
    			mouseDetectionEnabled = true;
    		} else if (mouseDetectionEnabled && disable) {
    			$(document).off(eNS);
    			mouseDetectionEnabled = false;
    		}
    	}

    	function isTouchEvent(e) {
    		return !/^(4|mouse)$/.test(e.pointerType);
    	}

    	// returns a jQuery on() ready object
    	function getEventsNS(events, eNS) {
    		if (!eNS) {
    			eNS = '';
    		}
    		var eventsNS = {};
    		for (var i in events) {
    			eventsNS[i.split(' ').join(eNS + ' ') + eNS] = events[i];
    		}
    		return eventsNS;
    	}

    	$.SmartMenus = function(elm, options) {
    		this.$root = $(elm);
    		this.opts = options;
    		this.rootId = ''; // internal
    		this.accessIdPrefix = '';
    		this.$subArrow = null;
    		this.activatedItems = []; // stores last activated A's for each level
    		this.visibleSubMenus = []; // stores visible sub menus UL's (might be in no particular order)
    		this.showTimeout = 0;
    		this.hideTimeout = 0;
    		this.scrollTimeout = 0;
    		this.clickActivated = false;
    		this.focusActivated = false;
    		this.zIndexInc = 0;
    		this.idInc = 0;
    		this.$firstLink = null; // we'll use these for some tests
    		this.$firstSub = null; // at runtime so we'll cache them
    		this.disabled = false;
    		this.$disableOverlay = null;
    		this.$touchScrollingSub = null;
    		this.cssTransforms3d = 'perspective' in elm.style || 'webkitPerspective' in elm.style;
    		this.wasCollapsible = false;
    		this.init();
    	};

    	$.extend($.SmartMenus, {
    		hideAll: function() {
    			$.each(menuTrees, function() {
    				this.menuHideAll();
    			});
    		},
    		destroy: function() {
    			while (menuTrees.length) {
    				menuTrees[0].destroy();
    			}
    			initMouseDetection(true);
    		},
    		prototype: {
    			init: function(refresh) {
    				var self = this;

    				if (!refresh) {
    					menuTrees.push(this);

    					this.rootId = (new Date().getTime() + Math.random() + '').replace(/\D/g, '');
    					this.accessIdPrefix = 'sm-' + this.rootId + '-';

    					if (this.$root.hasClass('sm-rtl')) {
    						this.opts.rightToLeftSubMenus = true;
    					}

    					// init root (main menu)
    					var eNS = '.smartmenus';
    					this.$root
    						.data('smartmenus', this)
    						.attr('data-smartmenus-id', this.rootId)
    						.dataSM('level', 1)
    						.on(getEventsNS({
    							'mouseover focusin': $.proxy(this.rootOver, this),
    							'mouseout focusout': $.proxy(this.rootOut, this),
    							'keydown': $.proxy(this.rootKeyDown, this)
    						}, eNS))
    						.on(getEventsNS({
    							'mouseenter': $.proxy(this.itemEnter, this),
    							'mouseleave': $.proxy(this.itemLeave, this),
    							'mousedown': $.proxy(this.itemDown, this),
    							'focus': $.proxy(this.itemFocus, this),
    							'blur': $.proxy(this.itemBlur, this),
    							'click': $.proxy(this.itemClick, this)
    						}, eNS), 'a');

    					// hide menus on tap or click outside the root UL
    					eNS += this.rootId;
    					if (this.opts.hideOnClick) {
    						$(document).on(getEventsNS({
    							'touchstart': $.proxy(this.docTouchStart, this),
    							'touchmove': $.proxy(this.docTouchMove, this),
    							'touchend': $.proxy(this.docTouchEnd, this),
    							// for Opera Mobile < 11.5, webOS browser, etc. we'll check click too
    							'click': $.proxy(this.docClick, this)
    						}, eNS));
    					}
    					// hide sub menus on resize
    					$(window).on(getEventsNS({ 'resize orientationchange': $.proxy(this.winResize, this) }, eNS));

    					if (this.opts.subIndicators) {
    						this.$subArrow = $('<span/>').addClass('sub-arrow');
    						if (this.opts.subIndicatorsText) {
    							this.$subArrow.html(this.opts.subIndicatorsText);
    						}
    					}

    					// make sure mouse detection is enabled
    					initMouseDetection();
    				}

    				// init sub menus
    				this.$firstSub = this.$root.find('ul').each(function() { self.menuInit($(this)); }).eq(0);

    				this.$firstLink = this.$root.find('a').eq(0);

    				// find current item
    				if (this.opts.markCurrentItem) {
    					var reDefaultDoc = /(index|default)\.[^#\?\/]*/i,
    						reHash = /#.*/,
    						locHref = window.location.href.replace(reDefaultDoc, ''),
    						locHrefNoHash = locHref.replace(reHash, '');
    					this.$root.find('a:not(.mega-menu a)').each(function() {
    						var href = this.href.replace(reDefaultDoc, ''),
    							$this = $(this);
    						if (href == locHref || href == locHrefNoHash) {
    							$this.addClass('current');
    							if (self.opts.markCurrentTree) {
    								$this.parentsUntil('[data-smartmenus-id]', 'ul').each(function() {
    									$(this).dataSM('parent-a').addClass('current');
    								});
    							}
    						}
    					});
    				}

    				// save initial state
    				this.wasCollapsible = this.isCollapsible();
    			},
    			destroy: function(refresh) {
    				if (!refresh) {
    					var eNS = '.smartmenus';
    					this.$root
    						.removeData('smartmenus')
    						.removeAttr('data-smartmenus-id')
    						.removeDataSM('level')
    						.off(eNS);
    					eNS += this.rootId;
    					$(document).off(eNS);
    					$(window).off(eNS);
    					if (this.opts.subIndicators) {
    						this.$subArrow = null;
    					}
    				}
    				this.menuHideAll();
    				var self = this;
    				this.$root.find('ul').each(function() {
    						var $this = $(this);
    						if ($this.dataSM('scroll-arrows')) {
    							$this.dataSM('scroll-arrows').remove();
    						}
    						if ($this.dataSM('shown-before')) {
    							if (self.opts.subMenusMinWidth || self.opts.subMenusMaxWidth) {
    								$this.css({ width: '', minWidth: '', maxWidth: '' }).removeClass('sm-nowrap');
    							}
    							if ($this.dataSM('scroll-arrows')) {
    								$this.dataSM('scroll-arrows').remove();
    							}
    							$this.css({ zIndex: '', top: '', left: '', marginLeft: '', marginTop: '', display: '' });
    						}
    						if (($this.attr('id') || '').indexOf(self.accessIdPrefix) == 0) {
    							$this.removeAttr('id');
    						}
    					})
    					.removeDataSM('in-mega')
    					.removeDataSM('shown-before')
    					.removeDataSM('scroll-arrows')
    					.removeDataSM('parent-a')
    					.removeDataSM('level')
    					.removeDataSM('beforefirstshowfired')
    					.removeAttr('role')
    					.removeAttr('aria-hidden')
    					.removeAttr('aria-labelledby')
    					.removeAttr('aria-expanded');
    				this.$root.find('a.has-submenu').each(function() {
    						var $this = $(this);
    						if ($this.attr('id').indexOf(self.accessIdPrefix) == 0) {
    							$this.removeAttr('id');
    						}
    					})
    					.removeClass('has-submenu')
    					.removeDataSM('sub')
    					.removeAttr('aria-haspopup')
    					.removeAttr('aria-controls')
    					.removeAttr('aria-expanded')
    					.closest('li').removeDataSM('sub');
    				if (this.opts.subIndicators) {
    					this.$root.find('span.sub-arrow').remove();
    				}
    				if (this.opts.markCurrentItem) {
    					this.$root.find('a.current').removeClass('current');
    				}
    				if (!refresh) {
    					this.$root = null;
    					this.$firstLink = null;
    					this.$firstSub = null;
    					if (this.$disableOverlay) {
    						this.$disableOverlay.remove();
    						this.$disableOverlay = null;
    					}
    					menuTrees.splice($.inArray(this, menuTrees), 1);
    				}
    			},
    			disable: function(noOverlay) {
    				if (!this.disabled) {
    					this.menuHideAll();
    					// display overlay over the menu to prevent interaction
    					if (!noOverlay && !this.opts.isPopup && this.$root.is(':visible')) {
    						var pos = this.$root.offset();
    						this.$disableOverlay = $('<div class="sm-jquery-disable-overlay"/>').css({
    							position: 'absolute',
    							top: pos.top,
    							left: pos.left,
    							width: this.$root.outerWidth(),
    							height: this.$root.outerHeight(),
    							zIndex: this.getStartZIndex(true),
    							opacity: 0
    						}).appendTo(document.body);
    					}
    					this.disabled = true;
    				}
    			},
    			docClick: function(e) {
    				if (this.$touchScrollingSub) {
    					this.$touchScrollingSub = null;
    					return;
    				}
    				// hide on any click outside the menu or on a menu link
    				if (this.visibleSubMenus.length && !$.contains(this.$root[0], e.target) || $(e.target).closest('a').length) {
    					this.menuHideAll();
    				}
    			},
    			docTouchEnd: function(e) {
    				if (!this.lastTouch) {
    					return;
    				}
    				if (this.visibleSubMenus.length && (this.lastTouch.x2 === undefined || this.lastTouch.x1 == this.lastTouch.x2) && (this.lastTouch.y2 === undefined || this.lastTouch.y1 == this.lastTouch.y2) && (!this.lastTouch.target || !$.contains(this.$root[0], this.lastTouch.target))) {
    					if (this.hideTimeout) {
    						clearTimeout(this.hideTimeout);
    						this.hideTimeout = 0;
    					}
    					// hide with a delay to prevent triggering accidental unwanted click on some page element
    					var self = this;
    					this.hideTimeout = setTimeout(function() { self.menuHideAll(); }, 350);
    				}
    				this.lastTouch = null;
    			},
    			docTouchMove: function(e) {
    				if (!this.lastTouch) {
    					return;
    				}
    				var touchPoint = e.originalEvent.touches[0];
    				this.lastTouch.x2 = touchPoint.pageX;
    				this.lastTouch.y2 = touchPoint.pageY;
    			},
    			docTouchStart: function(e) {
    				var touchPoint = e.originalEvent.touches[0];
    				this.lastTouch = { x1: touchPoint.pageX, y1: touchPoint.pageY, target: touchPoint.target };
    			},
    			enable: function() {
    				if (this.disabled) {
    					if (this.$disableOverlay) {
    						this.$disableOverlay.remove();
    						this.$disableOverlay = null;
    					}
    					this.disabled = false;
    				}
    			},
    			getClosestMenu: function(elm) {
    				var $closestMenu = $(elm).closest('ul');
    				while ($closestMenu.dataSM('in-mega')) {
    					$closestMenu = $closestMenu.parent().closest('ul');
    				}
    				return $closestMenu[0] || null;
    			},
    			getHeight: function($elm) {
    				return this.getOffset($elm, true);
    			},
    			// returns precise width/height float values
    			getOffset: function($elm, height) {
    				var old;
    				if ($elm.css('display') == 'none') {
    					old = { position: $elm[0].style.position, visibility: $elm[0].style.visibility };
    					$elm.css({ position: 'absolute', visibility: 'hidden' }).show();
    				}
    				var box = $elm[0].getBoundingClientRect && $elm[0].getBoundingClientRect(),
    					val = box && (height ? box.height || box.bottom - box.top : box.width || box.right - box.left);
    				if (!val && val !== 0) {
    					val = height ? $elm[0].offsetHeight : $elm[0].offsetWidth;
    				}
    				if (old) {
    					$elm.hide().css(old);
    				}
    				return val;
    			},
    			getStartZIndex: function(root) {
    				var zIndex = parseInt(this[root ? '$root' : '$firstSub'].css('z-index'));
    				if (!root && isNaN(zIndex)) {
    					zIndex = parseInt(this.$root.css('z-index'));
    				}
    				return !isNaN(zIndex) ? zIndex : 1;
    			},
    			getTouchPoint: function(e) {
    				return e.touches && e.touches[0] || e.changedTouches && e.changedTouches[0] || e;
    			},
    			getViewport: function(height) {
    				var name = height ? 'Height' : 'Width',
    					val = document.documentElement['client' + name],
    					val2 = window['inner' + name];
    				if (val2) {
    					val = Math.min(val, val2);
    				}
    				return val;
    			},
    			getViewportHeight: function() {
    				return this.getViewport(true);
    			},
    			getViewportWidth: function() {
    				return this.getViewport();
    			},
    			getWidth: function($elm) {
    				return this.getOffset($elm);
    			},
    			handleEvents: function() {
    				return !this.disabled && this.isCSSOn();
    			},
    			handleItemEvents: function($a) {
    				return this.handleEvents() && !this.isLinkInMegaMenu($a);
    			},
    			isCollapsible: function() {
    				return this.$firstSub.css('position') == 'static';
    			},
    			isCSSOn: function() {
    				return this.$firstLink.css('display') != 'inline';
    			},
    			isFixed: function() {
    				var isFixed = this.$root.css('position') == 'fixed';
    				if (!isFixed) {
    					this.$root.parentsUntil('body').each(function() {
    						if ($(this).css('position') == 'fixed') {
    							isFixed = true;
    							return false;
    						}
    					});
    				}
    				return isFixed;
    			},
    			isLinkInMegaMenu: function($a) {
    				return $(this.getClosestMenu($a[0])).hasClass('mega-menu');
    			},
    			isTouchMode: function() {
    				return !mouse || this.opts.noMouseOver || this.isCollapsible();
    			},
    			itemActivate: function($a, hideDeeperSubs) {
    				var $ul = $a.closest('ul'),
    					level = $ul.dataSM('level');
    				// if for some reason the parent item is not activated (e.g. this is an API call to activate the item), activate all parent items first
    				if (level > 1 && (!this.activatedItems[level - 2] || this.activatedItems[level - 2][0] != $ul.dataSM('parent-a')[0])) {
    					var self = this;
    					$($ul.parentsUntil('[data-smartmenus-id]', 'ul').get().reverse()).add($ul).each(function() {
    						self.itemActivate($(this).dataSM('parent-a'));
    					});
    				}
    				// hide any visible deeper level sub menus
    				if (!this.isCollapsible() || hideDeeperSubs) {
    					this.menuHideSubMenus(!this.activatedItems[level - 1] || this.activatedItems[level - 1][0] != $a[0] ? level - 1 : level);
    				}
    				// save new active item for this level
    				this.activatedItems[level - 1] = $a;
    				if (this.$root.triggerHandler('activate.smapi', $a[0]) === false) {
    					return;
    				}
    				// show the sub menu if this item has one
    				var $sub = $a.dataSM('sub');
    				if ($sub && (this.isTouchMode() || (!this.opts.showOnClick || this.clickActivated))) {
    					this.menuShow($sub);
    				}
    			},
    			itemBlur: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				this.$root.triggerHandler('blur.smapi', $a[0]);
    			},
    			itemClick: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				if (this.$touchScrollingSub && this.$touchScrollingSub[0] == $a.closest('ul')[0]) {
    					this.$touchScrollingSub = null;
    					e.stopPropagation();
    					return false;
    				}
    				if (this.$root.triggerHandler('click.smapi', $a[0]) === false) {
    					return false;
    				}
    				var $sub = $a.dataSM('sub'),
    					firstLevelSub = $sub ? $sub.dataSM('level') == 2 : false;
    				if ($sub) {
    					var subArrowClicked = $(e.target).is('.sub-arrow'),
    						collapsible = this.isCollapsible(),
    						behaviorToggle = /toggle$/.test(this.opts.collapsibleBehavior),
    						behaviorLink = /link$/.test(this.opts.collapsibleBehavior),
    						behaviorAccordion = /^accordion/.test(this.opts.collapsibleBehavior);
    					// if the sub is hidden, try to show it
    					if (!$sub.is(':visible')) {
    						if (!behaviorLink || !collapsible || subArrowClicked) {
    							if (!collapsible && this.opts.showOnClick && firstLevelSub) {
    								this.clickActivated = true;
    							}
    							// try to activate the item and show the sub
    							this.itemActivate($a, behaviorAccordion);
    							// if "itemActivate" showed the sub, prevent the click so that the link is not loaded
    							// if it couldn't show it, then the sub menus are disabled with an !important declaration (e.g. via mobile styles) so let the link get loaded
    							if ($sub.is(':visible')) {
    								this.focusActivated = true;
    								return false;
    							}
    						}
    					// if the sub is visible and showOnClick: true, hide the sub
    					} else if (!collapsible && this.opts.showOnClick && firstLevelSub) {
    						this.menuHide($sub);
    						this.clickActivated = false;
    						this.focusActivated = false;
    						return false;
    					// if the sub is visible and we are in collapsible mode
    					} else if (collapsible && (behaviorToggle || subArrowClicked)) {
    						this.itemActivate($a, behaviorAccordion);
    						this.menuHide($sub);
    						return false;
    					}
    				}
    				if (!collapsible && this.opts.showOnClick && firstLevelSub || $a.hasClass('disabled') || this.$root.triggerHandler('select.smapi', $a[0]) === false) {
    					return false;
    				}
    			},
    			itemDown: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				$a.dataSM('mousedown', true);
    			},
    			itemEnter: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				if (!this.isTouchMode()) {
    					if (this.showTimeout) {
    						clearTimeout(this.showTimeout);
    						this.showTimeout = 0;
    					}
    					var self = this;
    					this.showTimeout = setTimeout(function() { self.itemActivate($a); }, this.opts.showOnClick && $a.closest('ul').dataSM('level') == 1 ? 1 : this.opts.showTimeout);
    				}
    				this.$root.triggerHandler('mouseenter.smapi', $a[0]);
    			},
    			itemFocus: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				// fix (the mousedown check): in some browsers a tap/click produces consecutive focus + click events so we don't need to activate the item on focus
    				if (this.focusActivated && (!this.isTouchMode() || !$a.dataSM('mousedown')) && (!this.activatedItems.length || this.activatedItems[this.activatedItems.length - 1][0] != $a[0])) {
    					this.itemActivate($a, true);
    				}
    				this.$root.triggerHandler('focus.smapi', $a[0]);
    			},
    			itemLeave: function(e) {
    				var $a = $(e.currentTarget);
    				if (!this.handleItemEvents($a)) {
    					return;
    				}
    				if (!this.isTouchMode()) {
    					$a[0].blur();
    					if (this.showTimeout) {
    						clearTimeout(this.showTimeout);
    						this.showTimeout = 0;
    					}
    				}
    				$a.removeDataSM('mousedown');
    				this.$root.triggerHandler('mouseleave.smapi', $a[0]);
    			},
    			menuHide: function($sub) {
    				if (this.$root.triggerHandler('beforehide.smapi', $sub[0]) === false) {
    					return;
    				}
    				if (canAnimate) {
    					$sub.stop(true, true);
    				}
    				if ($sub.css('display') != 'none') {
    					var complete = function() {
    						// unset z-index
    						$sub.css('z-index', '');
    					};
    					// if sub is collapsible (mobile view)
    					if (this.isCollapsible()) {
    						if (canAnimate && this.opts.collapsibleHideFunction) {
    							this.opts.collapsibleHideFunction.call(this, $sub, complete);
    						} else {
    							$sub.hide(this.opts.collapsibleHideDuration, complete);
    						}
    					} else {
    						if (canAnimate && this.opts.hideFunction) {
    							this.opts.hideFunction.call(this, $sub, complete);
    						} else {
    							$sub.hide(this.opts.hideDuration, complete);
    						}
    					}
    					// deactivate scrolling if it is activated for this sub
    					if ($sub.dataSM('scroll')) {
    						this.menuScrollStop($sub);
    						$sub.css({ 'touch-action': '', '-ms-touch-action': '', '-webkit-transform': '', transform: '' })
    							.off('.smartmenus_scroll').removeDataSM('scroll').dataSM('scroll-arrows').hide();
    					}
    					// unhighlight parent item + accessibility
    					$sub.dataSM('parent-a').removeClass('highlighted').attr('aria-expanded', 'false');
    					$sub.attr({
    						'aria-expanded': 'false',
    						'aria-hidden': 'true'
    					});
    					var level = $sub.dataSM('level');
    					this.activatedItems.splice(level - 1, 1);
    					this.visibleSubMenus.splice($.inArray($sub, this.visibleSubMenus), 1);
    					this.$root.triggerHandler('hide.smapi', $sub[0]);
    				}
    			},
    			menuHideAll: function() {
    				if (this.showTimeout) {
    					clearTimeout(this.showTimeout);
    					this.showTimeout = 0;
    				}
    				// hide all subs
    				// if it's a popup, this.visibleSubMenus[0] is the root UL
    				var level = this.opts.isPopup ? 1 : 0;
    				for (var i = this.visibleSubMenus.length - 1; i >= level; i--) {
    					this.menuHide(this.visibleSubMenus[i]);
    				}
    				// hide root if it's popup
    				if (this.opts.isPopup) {
    					if (canAnimate) {
    						this.$root.stop(true, true);
    					}
    					if (this.$root.is(':visible')) {
    						if (canAnimate && this.opts.hideFunction) {
    							this.opts.hideFunction.call(this, this.$root);
    						} else {
    							this.$root.hide(this.opts.hideDuration);
    						}
    					}
    				}
    				this.activatedItems = [];
    				this.visibleSubMenus = [];
    				this.clickActivated = false;
    				this.focusActivated = false;
    				// reset z-index increment
    				this.zIndexInc = 0;
    				this.$root.triggerHandler('hideAll.smapi');
    			},
    			menuHideSubMenus: function(level) {
    				for (var i = this.activatedItems.length - 1; i >= level; i--) {
    					var $sub = this.activatedItems[i].dataSM('sub');
    					if ($sub) {
    						this.menuHide($sub);
    					}
    				}
    			},
    			menuInit: function($ul) {
    				if (!$ul.dataSM('in-mega')) {
    					// mark UL's in mega drop downs (if any) so we can neglect them
    					if ($ul.hasClass('mega-menu')) {
    						$ul.find('ul').dataSM('in-mega', true);
    					}
    					// get level (much faster than, for example, using parentsUntil)
    					var level = 2,
    						par = $ul[0];
    					while ((par = par.parentNode.parentNode) != this.$root[0]) {
    						level++;
    					}
    					// cache stuff for quick access
    					var $a = $ul.prevAll('a').eq(-1);
    					// if the link is nested (e.g. in a heading)
    					if (!$a.length) {
    						$a = $ul.prevAll().find('a').eq(-1);
    					}
    					$a.addClass('has-submenu').dataSM('sub', $ul);
    					$ul.dataSM('parent-a', $a)
    						.dataSM('level', level)
    						.parent().dataSM('sub', $ul);
    					// accessibility
    					var aId = $a.attr('id') || this.accessIdPrefix + (++this.idInc),
    						ulId = $ul.attr('id') || this.accessIdPrefix + (++this.idInc);
    					$a.attr({
    						id: aId,
    						'aria-haspopup': 'true',
    						'aria-controls': ulId,
    						'aria-expanded': 'false'
    					});
    					$ul.attr({
    						id: ulId,
    						'role': 'group',
    						'aria-hidden': 'true',
    						'aria-labelledby': aId,
    						'aria-expanded': 'false'
    					});
    					// add sub indicator to parent item
    					if (this.opts.subIndicators) {
    						$a[this.opts.subIndicatorsPos](this.$subArrow.clone());
    					}
    				}
    			},
    			menuPosition: function($sub) {
    				var $a = $sub.dataSM('parent-a'),
    					$li = $a.closest('li'),
    					$ul = $li.parent(),
    					level = $sub.dataSM('level'),
    					subW = this.getWidth($sub),
    					subH = this.getHeight($sub),
    					itemOffset = $a.offset(),
    					itemX = itemOffset.left,
    					itemY = itemOffset.top,
    					itemW = this.getWidth($a),
    					itemH = this.getHeight($a),
    					$win = $(window),
    					winX = $win.scrollLeft(),
    					winY = $win.scrollTop(),
    					winW = this.getViewportWidth(),
    					winH = this.getViewportHeight(),
    					horizontalParent = $ul.parent().is('[data-sm-horizontal-sub]') || level == 2 && !$ul.hasClass('sm-vertical'),
    					rightToLeft = this.opts.rightToLeftSubMenus && !$li.is('[data-sm-reverse]') || !this.opts.rightToLeftSubMenus && $li.is('[data-sm-reverse]'),
    					subOffsetX = level == 2 ? this.opts.mainMenuSubOffsetX : this.opts.subMenusSubOffsetX,
    					subOffsetY = level == 2 ? this.opts.mainMenuSubOffsetY : this.opts.subMenusSubOffsetY,
    					x, y;
    				if (horizontalParent) {
    					x = rightToLeft ? itemW - subW - subOffsetX : subOffsetX;
    					y = this.opts.bottomToTopSubMenus ? -subH - subOffsetY : itemH + subOffsetY;
    				} else {
    					x = rightToLeft ? subOffsetX - subW : itemW - subOffsetX;
    					y = this.opts.bottomToTopSubMenus ? itemH - subOffsetY - subH : subOffsetY;
    				}
    				if (this.opts.keepInViewport) {
    					var absX = itemX + x,
    						absY = itemY + y;
    					if (rightToLeft && absX < winX) {
    						x = horizontalParent ? winX - absX + x : itemW - subOffsetX;
    					} else if (!rightToLeft && absX + subW > winX + winW) {
    						x = horizontalParent ? winX + winW - subW - absX + x : subOffsetX - subW;
    					}
    					if (!horizontalParent) {
    						if (subH < winH && absY + subH > winY + winH) {
    							y += winY + winH - subH - absY;
    						} else if (subH >= winH || absY < winY) {
    							y += winY - absY;
    						}
    					}
    					// do we need scrolling?
    					// 0.49 used for better precision when dealing with float values
    					if (horizontalParent && (absY + subH > winY + winH + 0.49 || absY < winY) || !horizontalParent && subH > winH + 0.49) {
    						var self = this;
    						if (!$sub.dataSM('scroll-arrows')) {
    							$sub.dataSM('scroll-arrows', $([$('<span class="scroll-up"><span class="scroll-up-arrow"></span></span>')[0], $('<span class="scroll-down"><span class="scroll-down-arrow"></span></span>')[0]])
    								.on({
    									mouseenter: function() {
    										$sub.dataSM('scroll').up = $(this).hasClass('scroll-up');
    										self.menuScroll($sub);
    									},
    									mouseleave: function(e) {
    										self.menuScrollStop($sub);
    										self.menuScrollOut($sub, e);
    									},
    									'mousewheel DOMMouseScroll': function(e) { e.preventDefault(); }
    								})
    								.insertAfter($sub)
    							);
    						}
    						// bind scroll events and save scroll data for this sub
    						var eNS = '.smartmenus_scroll';
    						$sub.dataSM('scroll', {
    								y: this.cssTransforms3d ? 0 : y - itemH,
    								step: 1,
    								// cache stuff for faster recalcs later
    								itemH: itemH,
    								subH: subH,
    								arrowDownH: this.getHeight($sub.dataSM('scroll-arrows').eq(1))
    							})
    							.on(getEventsNS({
    								'mouseover': function(e) { self.menuScrollOver($sub, e); },
    								'mouseout': function(e) { self.menuScrollOut($sub, e); },
    								'mousewheel DOMMouseScroll': function(e) { self.menuScrollMousewheel($sub, e); }
    							}, eNS))
    							.dataSM('scroll-arrows').css({ top: 'auto', left: '0', marginLeft: x + (parseInt($sub.css('border-left-width')) || 0), width: subW - (parseInt($sub.css('border-left-width')) || 0) - (parseInt($sub.css('border-right-width')) || 0), zIndex: $sub.css('z-index') })
    								.eq(horizontalParent && this.opts.bottomToTopSubMenus ? 0 : 1).show();
    						// when a menu tree is fixed positioned we allow scrolling via touch too
    						// since there is no other way to access such long sub menus if no mouse is present
    						if (this.isFixed()) {
    							var events = {};
    							events[touchEvents ? 'touchstart touchmove touchend' : 'pointerdown pointermove pointerup MSPointerDown MSPointerMove MSPointerUp'] = function(e) {
    								self.menuScrollTouch($sub, e);
    							};
    							$sub.css({ 'touch-action': 'none', '-ms-touch-action': 'none' }).on(getEventsNS(events, eNS));
    						}
    					}
    				}
    				$sub.css({ top: 'auto', left: '0', marginLeft: x, marginTop: y - itemH });
    			},
    			menuScroll: function($sub, once, step) {
    				var data = $sub.dataSM('scroll'),
    					$arrows = $sub.dataSM('scroll-arrows'),
    					end = data.up ? data.upEnd : data.downEnd,
    					diff;
    				if (!once && data.momentum) {
    					data.momentum *= 0.92;
    					diff = data.momentum;
    					if (diff < 0.5) {
    						this.menuScrollStop($sub);
    						return;
    					}
    				} else {
    					diff = step || (once || !this.opts.scrollAccelerate ? this.opts.scrollStep : Math.floor(data.step));
    				}
    				// hide any visible deeper level sub menus
    				var level = $sub.dataSM('level');
    				if (this.activatedItems[level - 1] && this.activatedItems[level - 1].dataSM('sub') && this.activatedItems[level - 1].dataSM('sub').is(':visible')) {
    					this.menuHideSubMenus(level - 1);
    				}
    				data.y = data.up && end <= data.y || !data.up && end >= data.y ? data.y : (Math.abs(end - data.y) > diff ? data.y + (data.up ? diff : -diff) : end);
    				$sub.css(this.cssTransforms3d ? { '-webkit-transform': 'translate3d(0, ' + data.y + 'px, 0)', transform: 'translate3d(0, ' + data.y + 'px, 0)' } : { marginTop: data.y });
    				// show opposite arrow if appropriate
    				if (mouse && (data.up && data.y > data.downEnd || !data.up && data.y < data.upEnd)) {
    					$arrows.eq(data.up ? 1 : 0).show();
    				}
    				// if we've reached the end
    				if (data.y == end) {
    					if (mouse) {
    						$arrows.eq(data.up ? 0 : 1).hide();
    					}
    					this.menuScrollStop($sub);
    				} else if (!once) {
    					if (this.opts.scrollAccelerate && data.step < this.opts.scrollStep) {
    						data.step += 0.2;
    					}
    					var self = this;
    					this.scrollTimeout = requestAnimationFrame(function() { self.menuScroll($sub); });
    				}
    			},
    			menuScrollMousewheel: function($sub, e) {
    				if (this.getClosestMenu(e.target) == $sub[0]) {
    					e = e.originalEvent;
    					var up = (e.wheelDelta || -e.detail) > 0;
    					if ($sub.dataSM('scroll-arrows').eq(up ? 0 : 1).is(':visible')) {
    						$sub.dataSM('scroll').up = up;
    						this.menuScroll($sub, true);
    					}
    				}
    				e.preventDefault();
    			},
    			menuScrollOut: function($sub, e) {
    				if (mouse) {
    					if (!/^scroll-(up|down)/.test((e.relatedTarget || '').className) && ($sub[0] != e.relatedTarget && !$.contains($sub[0], e.relatedTarget) || this.getClosestMenu(e.relatedTarget) != $sub[0])) {
    						$sub.dataSM('scroll-arrows').css('visibility', 'hidden');
    					}
    				}
    			},
    			menuScrollOver: function($sub, e) {
    				if (mouse) {
    					if (!/^scroll-(up|down)/.test(e.target.className) && this.getClosestMenu(e.target) == $sub[0]) {
    						this.menuScrollRefreshData($sub);
    						var data = $sub.dataSM('scroll'),
    							upEnd = $(window).scrollTop() - $sub.dataSM('parent-a').offset().top - data.itemH;
    						$sub.dataSM('scroll-arrows').eq(0).css('margin-top', upEnd).end()
    							.eq(1).css('margin-top', upEnd + this.getViewportHeight() - data.arrowDownH).end()
    							.css('visibility', 'visible');
    					}
    				}
    			},
    			menuScrollRefreshData: function($sub) {
    				var data = $sub.dataSM('scroll'),
    					upEnd = $(window).scrollTop() - $sub.dataSM('parent-a').offset().top - data.itemH;
    				if (this.cssTransforms3d) {
    					upEnd = -(parseFloat($sub.css('margin-top')) - upEnd);
    				}
    				$.extend(data, {
    					upEnd: upEnd,
    					downEnd: upEnd + this.getViewportHeight() - data.subH
    				});
    			},
    			menuScrollStop: function($sub) {
    				if (this.scrollTimeout) {
    					cancelAnimationFrame(this.scrollTimeout);
    					this.scrollTimeout = 0;
    					$sub.dataSM('scroll').step = 1;
    					return true;
    				}
    			},
    			menuScrollTouch: function($sub, e) {
    				e = e.originalEvent;
    				if (isTouchEvent(e)) {
    					var touchPoint = this.getTouchPoint(e);
    					// neglect event if we touched a visible deeper level sub menu
    					if (this.getClosestMenu(touchPoint.target) == $sub[0]) {
    						var data = $sub.dataSM('scroll');
    						if (/(start|down)$/i.test(e.type)) {
    							if (this.menuScrollStop($sub)) {
    								// if we were scrolling, just stop and don't activate any link on the first touch
    								e.preventDefault();
    								this.$touchScrollingSub = $sub;
    							} else {
    								this.$touchScrollingSub = null;
    							}
    							// update scroll data since the user might have zoomed, etc.
    							this.menuScrollRefreshData($sub);
    							// extend it with the touch properties
    							$.extend(data, {
    								touchStartY: touchPoint.pageY,
    								touchStartTime: e.timeStamp
    							});
    						} else if (/move$/i.test(e.type)) {
    							var prevY = data.touchY !== undefined ? data.touchY : data.touchStartY;
    							if (prevY !== undefined && prevY != touchPoint.pageY) {
    								this.$touchScrollingSub = $sub;
    								var up = prevY < touchPoint.pageY;
    								// changed direction? reset...
    								if (data.up !== undefined && data.up != up) {
    									$.extend(data, {
    										touchStartY: touchPoint.pageY,
    										touchStartTime: e.timeStamp
    									});
    								}
    								$.extend(data, {
    									up: up,
    									touchY: touchPoint.pageY
    								});
    								this.menuScroll($sub, true, Math.abs(touchPoint.pageY - prevY));
    							}
    							e.preventDefault();
    						} else { // touchend/pointerup
    							if (data.touchY !== undefined) {
    								if (data.momentum = Math.pow(Math.abs(touchPoint.pageY - data.touchStartY) / (e.timeStamp - data.touchStartTime), 2) * 15) {
    									this.menuScrollStop($sub);
    									this.menuScroll($sub);
    									e.preventDefault();
    								}
    								delete data.touchY;
    							}
    						}
    					}
    				}
    			},
    			menuShow: function($sub) {
    				if (!$sub.dataSM('beforefirstshowfired')) {
    					$sub.dataSM('beforefirstshowfired', true);
    					if (this.$root.triggerHandler('beforefirstshow.smapi', $sub[0]) === false) {
    						return;
    					}
    				}
    				if (this.$root.triggerHandler('beforeshow.smapi', $sub[0]) === false) {
    					return;
    				}
    				$sub.dataSM('shown-before', true);
    				if (canAnimate) {
    					$sub.stop(true, true);
    				}
    				if (!$sub.is(':visible')) {
    					// highlight parent item
    					var $a = $sub.dataSM('parent-a'),
    						collapsible = this.isCollapsible();
    					if (this.opts.keepHighlighted || collapsible) {
    						$a.addClass('highlighted');
    					}
    					if (collapsible) {
    						$sub.removeClass('sm-nowrap').css({ zIndex: '', width: 'auto', minWidth: '', maxWidth: '', top: '', left: '', marginLeft: '', marginTop: '' });
    					} else {
    						// set z-index
    						$sub.css('z-index', this.zIndexInc = (this.zIndexInc || this.getStartZIndex()) + 1);
    						// min/max-width fix - no way to rely purely on CSS as all UL's are nested
    						if (this.opts.subMenusMinWidth || this.opts.subMenusMaxWidth) {
    							$sub.css({ width: 'auto', minWidth: '', maxWidth: '' }).addClass('sm-nowrap');
    							if (this.opts.subMenusMinWidth) {
    							 	$sub.css('min-width', this.opts.subMenusMinWidth);
    							}
    							if (this.opts.subMenusMaxWidth) {
    							 	var noMaxWidth = this.getWidth($sub);
    							 	$sub.css('max-width', this.opts.subMenusMaxWidth);
    								if (noMaxWidth > this.getWidth($sub)) {
    									$sub.removeClass('sm-nowrap').css('width', this.opts.subMenusMaxWidth);
    								}
    							}
    						}
    						this.menuPosition($sub);
    					}
    					var complete = function() {
    						// fix: "overflow: hidden;" is not reset on animation complete in jQuery < 1.9.0 in Chrome when global "box-sizing: border-box;" is used
    						$sub.css('overflow', '');
    					};
    					// if sub is collapsible (mobile view)
    					if (collapsible) {
    						if (canAnimate && this.opts.collapsibleShowFunction) {
    							this.opts.collapsibleShowFunction.call(this, $sub, complete);
    						} else {
    							$sub.show(this.opts.collapsibleShowDuration, complete);
    						}
    					} else {
    						if (canAnimate && this.opts.showFunction) {
    							this.opts.showFunction.call(this, $sub, complete);
    						} else {
    							$sub.show(this.opts.showDuration, complete);
    						}
    					}
    					// accessibility
    					$a.attr('aria-expanded', 'true');
    					$sub.attr({
    						'aria-expanded': 'true',
    						'aria-hidden': 'false'
    					});
    					// store sub menu in visible array
    					this.visibleSubMenus.push($sub);
    					this.$root.triggerHandler('show.smapi', $sub[0]);
    				}
    			},
    			popupHide: function(noHideTimeout) {
    				if (this.hideTimeout) {
    					clearTimeout(this.hideTimeout);
    					this.hideTimeout = 0;
    				}
    				var self = this;
    				this.hideTimeout = setTimeout(function() {
    					self.menuHideAll();
    				}, noHideTimeout ? 1 : this.opts.hideTimeout);
    			},
    			popupShow: function(left, top) {
    				if (!this.opts.isPopup) {
    					alert('SmartMenus jQuery Error:\n\nIf you want to show this menu via the "popupShow" method, set the isPopup:true option.');
    					return;
    				}
    				if (this.hideTimeout) {
    					clearTimeout(this.hideTimeout);
    					this.hideTimeout = 0;
    				}
    				this.$root.dataSM('shown-before', true);
    				if (canAnimate) {
    					this.$root.stop(true, true);
    				}
    				if (!this.$root.is(':visible')) {
    					this.$root.css({ left: left, top: top });
    					// show menu
    					var self = this,
    						complete = function() {
    							self.$root.css('overflow', '');
    						};
    					if (canAnimate && this.opts.showFunction) {
    						this.opts.showFunction.call(this, this.$root, complete);
    					} else {
    						this.$root.show(this.opts.showDuration, complete);
    					}
    					this.visibleSubMenus[0] = this.$root;
    				}
    			},
    			refresh: function() {
    				this.destroy(true);
    				this.init(true);
    			},
    			rootKeyDown: function(e) {
    				if (!this.handleEvents()) {
    					return;
    				}
    				switch (e.keyCode) {
    					case 27: // reset on Esc
    						var $activeTopItem = this.activatedItems[0];
    						if ($activeTopItem) {
    							this.menuHideAll();
    							$activeTopItem[0].focus();
    							var $sub = $activeTopItem.dataSM('sub');
    							if ($sub) {
    								this.menuHide($sub);
    							}
    						}
    						break;
    					case 32: // activate item's sub on Space
    						var $target = $(e.target);
    						if ($target.is('a') && this.handleItemEvents($target)) {
    							var $sub = $target.dataSM('sub');
    							if ($sub && !$sub.is(':visible')) {
    								this.itemClick({ currentTarget: e.target });
    								e.preventDefault();
    							}
    						}
    						break;
    				}
    			},
    			rootOut: function(e) {
    				if (!this.handleEvents() || this.isTouchMode() || e.target == this.$root[0]) {
    					return;
    				}
    				if (this.hideTimeout) {
    					clearTimeout(this.hideTimeout);
    					this.hideTimeout = 0;
    				}
    				if (!this.opts.showOnClick || !this.opts.hideOnClick) {
    					var self = this;
    					this.hideTimeout = setTimeout(function() { self.menuHideAll(); }, this.opts.hideTimeout);
    				}
    			},
    			rootOver: function(e) {
    				if (!this.handleEvents() || this.isTouchMode() || e.target == this.$root[0]) {
    					return;
    				}
    				if (this.hideTimeout) {
    					clearTimeout(this.hideTimeout);
    					this.hideTimeout = 0;
    				}
    			},
    			winResize: function(e) {
    				if (!this.handleEvents()) {
    					// we still need to resize the disable overlay if it's visible
    					if (this.$disableOverlay) {
    						var pos = this.$root.offset();
    	 					this.$disableOverlay.css({
    							top: pos.top,
    							left: pos.left,
    							width: this.$root.outerWidth(),
    							height: this.$root.outerHeight()
    						});
    					}
    					return;
    				}
    				// hide sub menus on resize - on mobile do it only on orientation change
    				if (!('onorientationchange' in window) || e.type == 'orientationchange') {
    					var collapsible = this.isCollapsible();
    					// if it was collapsible before resize and still is, don't do it
    					if (!(this.wasCollapsible && collapsible)) { 
    						if (this.activatedItems.length) {
    							this.activatedItems[this.activatedItems.length - 1][0].blur();
    						}
    						this.menuHideAll();
    					}
    					this.wasCollapsible = collapsible;
    				}
    			}
    		}
    	});

    	$.fn.dataSM = function(key, val) {
    		if (val) {
    			return this.data(key + '_smartmenus', val);
    		}
    		return this.data(key + '_smartmenus');
    	};

    	$.fn.removeDataSM = function(key) {
    		return this.removeData(key + '_smartmenus');
    	};

    	$.fn.smartmenus = function(options) {
    		if (typeof options == 'string') {
    			var args = arguments,
    				method = options;
    			Array.prototype.shift.call(args);
    			return this.each(function() {
    				var smartmenus = $(this).data('smartmenus');
    				if (smartmenus && smartmenus[method]) {
    					smartmenus[method].apply(smartmenus, args);
    				}
    			});
    		}
    		return this.each(function() {
    			// [data-sm-options] attribute on the root UL
    			var dataOpts = $(this).data('sm-options') || null;
    			if (dataOpts && typeof dataOpts !== 'object') {
    				try {
    					dataOpts = eval('(' + dataOpts + ')');
    				} catch(e) {
    					dataOpts = null;
    					alert('ERROR\n\nSmartMenus jQuery init:\nInvalid "data-sm-options" attribute value syntax.');
    				};
    			}
    			new $.SmartMenus(this, $.extend({}, $.fn.smartmenus.defaults, options, dataOpts));
    		});
    	};

    	// default settings
    	$.fn.smartmenus.defaults = {
    		isPopup:		false,		// is this a popup menu (can be shown via the popupShow/popupHide methods) or a permanent menu bar
    		mainMenuSubOffsetX:	0,		// pixels offset from default position
    		mainMenuSubOffsetY:	0,		// pixels offset from default position
    		subMenusSubOffsetX:	0,		// pixels offset from default position
    		subMenusSubOffsetY:	0,		// pixels offset from default position
    		subMenusMinWidth:	'10em',		// min-width for the sub menus (any CSS unit) - if set, the fixed width set in CSS will be ignored
    		subMenusMaxWidth:	'20em',		// max-width for the sub menus (any CSS unit) - if set, the fixed width set in CSS will be ignored
    		subIndicators: 		true,		// create sub menu indicators - creates a SPAN and inserts it in the A
    		subIndicatorsPos: 	'append',	// position of the SPAN relative to the menu item content ('append', 'prepend')
    		subIndicatorsText:	'',		// [optionally] add text in the SPAN (e.g. '+') (you may want to check the CSS for the sub indicators too)
    		scrollStep: 		30,		// pixels step when scrolling long sub menus that do not fit in the viewport height
    		scrollAccelerate:	true,		// accelerate scrolling or use a fixed step
    		showTimeout:		250,		// timeout before showing the sub menus
    		hideTimeout:		500,		// timeout before hiding the sub menus
    		showDuration:		0,		// duration for show animation - set to 0 for no animation - matters only if showFunction:null
    		showFunction:		null,		// custom function to use when showing a sub menu (the default is the jQuery 'show')
    							// don't forget to call complete() at the end of whatever you do
    							// e.g.: function($ul, complete) { $ul.fadeIn(250, complete); }
    		hideDuration:		0,		// duration for hide animation - set to 0 for no animation - matters only if hideFunction:null
    		hideFunction:		function($ul, complete) { $ul.fadeOut(200, complete); },	// custom function to use when hiding a sub menu (the default is the jQuery 'hide')
    							// don't forget to call complete() at the end of whatever you do
    							// e.g.: function($ul, complete) { $ul.fadeOut(250, complete); }
    		collapsibleShowDuration:0,		// duration for show animation for collapsible sub menus - matters only if collapsibleShowFunction:null
    		collapsibleShowFunction:function($ul, complete) { $ul.slideDown(200, complete); },	// custom function to use when showing a collapsible sub menu
    							// (i.e. when mobile styles are used to make the sub menus collapsible)
    		collapsibleHideDuration:0,		// duration for hide animation for collapsible sub menus - matters only if collapsibleHideFunction:null
    		collapsibleHideFunction:function($ul, complete) { $ul.slideUp(200, complete); },	// custom function to use when hiding a collapsible sub menu
    							// (i.e. when mobile styles are used to make the sub menus collapsible)
    		showOnClick:		false,		// show the first-level sub menus onclick instead of onmouseover (i.e. mimic desktop app menus) (matters only for mouse input)
    		hideOnClick:		true,		// hide the sub menus on click/tap anywhere on the page
    		noMouseOver:		false,		// disable sub menus activation onmouseover (i.e. behave like in touch mode - use just mouse clicks) (matters only for mouse input)
    		keepInViewport:		true,		// reposition the sub menus if needed to make sure they always appear inside the viewport
    		keepHighlighted:	true,		// keep all ancestor items of the current sub menu highlighted (adds the 'highlighted' class to the A's)
    		markCurrentItem:	false,		// automatically add the 'current' class to the A element of the item linking to the current URL
    		markCurrentTree:	true,		// add the 'current' class also to the A elements of all ancestor items of the current item
    		rightToLeftSubMenus:	false,		// right to left display of the sub menus (check the CSS for the sub indicators' position)
    		bottomToTopSubMenus:	false,		// bottom to top display of the sub menus
    		collapsibleBehavior:	'default'	// parent items behavior in collapsible (mobile) view ('default', 'toggle', 'link', 'accordion', 'accordion-toggle', 'accordion-link')
    							// 'default' - first tap on parent item expands sub, second tap loads its link
    							// 'toggle' - the whole parent item acts just as a toggle button for its sub menu (expands/collapses on each tap)
    							// 'link' - the parent item acts as a regular item (first tap loads its link), the sub menu can be expanded only via the +/- button
    							// 'accordion' - like 'default' but on expand also resets any visible sub menus from deeper levels or other branches
    							// 'accordion-toggle' - like 'toggle' but on expand also resets any visible sub menus from deeper levels or other branches
    							// 'accordion-link' - like 'link' but on expand also resets any visible sub menus from deeper levels or other branches
    	};

    	return $;
    }));


    </script>



	<script>
	(function(factory) {
		if (typeof define === 'function' && define.amd) {
			// AMD
			define(['jquery', 'smartmenus'], factory);
		} else if (typeof module === 'object' && typeof module.exports === 'object') {
			// CommonJS
			module.exports = factory(require('jquery'));
		} else {
			// Global jQuery
			factory(jQuery);
		}
	} (function($) {

		$.extend($.SmartMenus.Bootstrap = {}, {
			keydownFix: false,
			init: function() {
				// init all navbars that don't have the "data-sm-skip" attribute set
				var $navbars = $('ul.navbar-nav:not([data-sm-skip])');
				$navbars.each(function() {
					var $this = $(this),
						obj = $this.data('smartmenus');
					// if this navbar is not initialized
					if (!obj) {
						var skipBehavior = $this.is('[data-sm-skip-collapsible-behavior]'),
							rightAligned = $this.hasClass('ml-auto') || $this.prevAll('.mr-auto').length > 0;

						$this.smartmenus({
								// these are some good default options that should work for all
								subMenusSubOffsetX: 2,
								subMenusSubOffsetY: -9,
								subIndicators: !skipBehavior,
								collapsibleShowFunction: null,
								collapsibleHideFunction: null,
								rightToLeftSubMenus: rightAligned,
								bottomToTopSubMenus: $this.closest('.fixed-bottom').length > 0,
								// custom option(s) for the Bootstrap 4 addon
								bootstrapHighlightClasses: 'text-dark bg-light'
							})
							.on({
								// set/unset proper Bootstrap classes for some menu elements
								'show.smapi': function(e, menu) {
									var $menu = $(menu),
										$scrollArrows = $menu.dataSM('scroll-arrows');
									if ($scrollArrows) {
										$scrollArrows.css('background-color', $menu.css('background-color'));
									}
									$menu.parent().addClass('show');
									if (obj.opts.keepHighlighted && $menu.dataSM('level') > 2) {
										$menu.prevAll('a').addClass(obj.opts.bootstrapHighlightClasses);
									}
								},
								'hide.smapi': function(e, menu) {
									var $menu = $(menu);
									$menu.parent().removeClass('show');
									if (obj.opts.keepHighlighted && $menu.dataSM('level') > 2) {
										$menu.prevAll('a').removeClass(obj.opts.bootstrapHighlightClasses);
									}
								}
							});

						obj = $this.data('smartmenus');

						function onInit() {
							// set Bootstrap's "active" class to SmartMenus "current" items (should someone decide to enable markCurrentItem: true)
							$this.find('a.current').each(function() {
								var $this = $(this);
								// dropdown items require the class to be set to the A's while for nav items it should be set to the parent LI's
								($this.hasClass('dropdown-item') ? $this : $this.parent()).addClass('active');
							});
							// parent items fixes
							$this.find('a.has-submenu').each(function() {
								var $this = $(this);
								// remove Bootstrap required attributes that might cause conflicting issues with the SmartMenus script
								if ($this.is('[data-toggle="dropdown"]')) {
									$this.dataSM('bs-data-toggle-dropdown', true).removeAttr('data-toggle');
								}
								// remove Bootstrap's carets generating class
								if (!skipBehavior && $this.hasClass('dropdown-toggle')) {
									$this.dataSM('bs-dropdown-toggle', true).removeClass('dropdown-toggle');
								}
							});
						}

						onInit();

						function onBeforeDestroy() {
							$this.find('a.current').each(function() {
								var $this = $(this);
								($this.hasClass('active') ? $this : $this.parent()).removeClass('active');
							});
							$this.find('a.has-submenu').each(function() {
								var $this = $(this);
								if ($this.dataSM('bs-dropdown-toggle')) {
									$this.addClass('dropdown-toggle').removeDataSM('bs-dropdown-toggle');
								}
								if ($this.dataSM('bs-data-toggle-dropdown')) {
									$this.attr('data-toggle', 'dropdown').removeDataSM('bs-data-toggle-dropdown');
								}
							});
						}

						// custom "refresh" method for Bootstrap
						obj.refresh = function() {
							$.SmartMenus.prototype.refresh.call(this);
							onInit();
							// update collapsible detection
							detectCollapsible(true);
						};

						// custom "destroy" method for Bootstrap
						obj.destroy = function(refresh) {
							onBeforeDestroy();
							$.SmartMenus.prototype.destroy.call(this, refresh);
						};

						// keep Bootstrap's default behavior (i.e. use the whole item area just as a sub menu toggle)
						if (skipBehavior) {
							obj.opts.collapsibleBehavior = 'toggle';
						}

						// onresize detect when the navbar becomes collapsible and add it the "sm-collapsible" class
						var winW;
						function detectCollapsible(force) {
							var newW = obj.getViewportWidth();
							if (newW != winW || force) {
								if (obj.isCollapsible()) {
									$this.addClass('sm-collapsible');
								} else {
									$this.removeClass('sm-collapsible');
								}
								winW = newW;
							}
						}
						detectCollapsible();
						$(window).on('resize.smartmenus' + obj.rootId, detectCollapsible);
					}
				});
				// keydown fix for Bootstrap 4 conflict
				if ($navbars.length && !$.SmartMenus.Bootstrap.keydownFix) {
					// unhook BS keydown handler for all dropdowns
					$(document).off('keydown.bs.dropdown.data-api', '.dropdown-menu');
					// restore BS keydown handler for dropdowns that are not inside SmartMenus navbars
					// SmartMenus won't add the "show" class so it's handy here
					if ($.fn.dropdown && $.fn.dropdown.Constructor && typeof $.fn.dropdown.Constructor._dataApiKeydownHandler == 'function') {
						$(document).on('keydown.bs.dropdown.data-api', '.dropdown-menu.show', $.fn.dropdown.Constructor._dataApiKeydownHandler);
					}
					$.SmartMenus.Bootstrap.keydownFix = true;
				}
			}
		});

		// init ondomready
		$($.SmartMenus.Bootstrap.init);

		return $;
	}));

	</script>

  </body>
</html>