<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Graphical Display</title>
    <style type="text/css">
body { 
  font-family: sans-serif;
  font-size: 12px;
  background: #f9f9f9;
  color: #777;
  margin-top: 40px;
}

body.dark {
  background: #090909;
  color: #ccc;
}

#wrap {
  width: 960px;
  margin: 0 auto;
  position: relative;
}

svg {
  font: 10px sans-serif;
}

canvas, svg {
  position: absolute;
  top: 0;
  left: 0;
}

#chart {
  position: relative;
}

.brush .extent {
  fill: rgba(0,0,0,0.12);
  stroke: rgba(255,255,255,0.6);
  shape-rendering: crisp-edges;
}

.dark .brush .extent {
  fill: rgba(255,255,255,0.12);
  stroke: rgba(0,0,0,0.5);
}

.axis line, .axis path {
  fill: none;
  stroke: #222;
  shape-rendering: crispEdges;
}

.axis text {
  fill: #222;
  text-shadow: 1px 1px 1px #fff, -1px -1px 1px #fff;
}

.axis text.label {
  fill: #444;
  font-size: 14px;
}

.dark .axis text {
  fill: #f2f2f2;
  text-shadow: 0 1px 0 #000, 1px 0 0 #000;
}

.dark .axis text.label {
  fill: #ddd;
}

.axis g,
.axis path {
  display: none;
}

#food-list {
  position: absolute;
  left: 220px;
  width: 740px;
  overflow-x: hidden;
}
#food-list span {
  display: inline-block;
  height: 6px;
  width: 6px;
  margin: 2px 4px;
}
    </style>
  </head>
  <body>
  <div id="wrap">
    <div id="chart">
      <canvas id="foreground"></canvas>
      <svg></svg>
    </div>
    <pre id="food-list"></pre>
    <p>
    Rendered: <strong id="rendered-count"></strong><br/>
    Selected: <strong id="selected-count"></strong><br/>
    Opacity: <strong id="opacity"></strong><br/>
    <button id="hide-ticks">Hide Ticks</button>
    <button id="show-ticks">Show Ticks</button><br/>
    <button id="dark-theme">Dark</button>
    <button id="light-theme">Light</button>
    </p>
    <p>
      Drag along a vertical axis to brush<br/>
      Tap the axis to remove its brush                                          
    </p>
  </div>
    <script src="d3.js"></script>
    <script src="parallel.js"></script>
  </body>
</html>