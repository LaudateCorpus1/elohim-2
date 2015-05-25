<!doctype html>
<html>
<head>
    <title>Test Page</title>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300' rel='stylesheet' type='text/css'>

    <style type="text/css">
        body {
            font-family: "Raleway", Verdana, Helvetica, sans-serif;
            padding: 0;
            margin: 0;
        }

        #header {
            display: block;
            position: fixed;
            background: white;
            height: 80px;
            width: 100%;
        }

        #header h1 {
            margin: 0;
            padding: 6px 6px 6px 9px;
        }

        .wrapper {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 9px;
        }

        #menu {
            border-bottom: 1px solid #999;
            position: fixed;
            width: 100%;
            top: 50px;
            background: white;
        }
        #menu .wrapper {
            padding: 0;
            max-width: 1138px;
        }

        #menu-panel {
            margin: 0;
            list-style: none;
            padding: 0;
        }

        #menu-panel li {
            margin: 0;
            display: inline-block;
            width: auto;
            padding: 3px 24px;
            cursor: pointer;
            font-size: 9pt;
            color: #999;
            position: relative;
            line-height: 24px;
        }

        #menu-panel li:hover {
            background: #a30011;
            color: white;
        }

        #menu-panel li ul {
            display: none;
            position: absolute;
            left: 0;
            top: 30px;
            margin: 0;
            padding: 0;
            width: 200px;
            z-index: 10;
            border: solid #999;
            border-width: 1px;
        }

        #menu-panel li li {
            margin: 0;
            padding: 6px 12px;
            white-space: normal;
            display: block;
            line-height: normal;
            border: solid rgba(0,0,0,0);
            border-width: 0 0 0 3px;
            background: white;
        }

        #menu-panel li ul ul {
            position: relative;
        }

        #menu-panel li:hover ul {
            display: block;
            width: 200px;
        }

        #menu-panel li:hover li ul {
            display: none;
        }

        #menu-panel li li:hover {
            border-color: #a30011;
            background: #ddd;
            color: black;
        }

        #menu-panel li li:hover ul {
            display: block;
        }

        #menu-panel li li ul {
            position: absolute;
            padding: 0;
            margin: 0;
            top: -1px;
            left: 197px;
            width: 200px;
            z-index: 20;
        }

        #menu-panel li li li {
        }

        #container {
            background: #d9d9d9;
            padding: 92px 0 128px;
            min-height: 600px;
        }

        #footer {
            background: #a30011;
            color: white;
            padding: 36px 0;
        }

        #footer-links {
            margin: 0;
            list-style: none;
            padding: 24px 0;
            display: inline-block;
        }

        #footer-links li {
            cursor: pointer;
            font-size: 8pt;
            margin: 0;
            padding: 3px 72px 3px 6px;
        }

        #footer-links li:hover {
            color: #ddd;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }


    </style>
</head>
<body>
<div id="header">
    <div class="wrapper">
        <h1>Title</h1>
    </div>
</div>
<div id="menu">
    <div class="wrapper">
        <ul id="menu-panel">
            <li>Home</li>
            <li>Setting
                <ul class="first">
                    <li>Coventry, Maine</li>
                    <li>Timeline</li>
                    <li>The Masquerade
                        <ul class="second">
                            <li>Indepedent Territories of Coventry</li>
                            <li>Ivory Tower Foothold</li>
                        </ul>
                    </li>
                    <li>The Ascension</li>
                    <li>The Fallen</li>
                    <li>Map of Coventry</li>
                </ul>
            </li>
            <li>Rules</li>
            <li>About</li>
            <li>Contact</li>
        </ul>
    </div>
</div>
<div id="container">
    <div class="wrapper">
        <h1>Header 1</h1>
    </div>
</div>
<div id="footer">
    <div class="wrapper">
        <ul id="footer-links">
            <li>Home</li>
            <li>About</li>
            <li>Contact</li>
            <li>Terms of Use</li>
        </ul>
    </div>
</div>
</body>
</html>