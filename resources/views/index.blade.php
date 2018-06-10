<!DOCTYPE html>
<head>
    <script src="/src/sigma.core.js"></script>
    <script src="/src/conrad.js"></script>
    <script src="/src/utils/sigma.utils.js"></script>
    <script src="/src/utils/sigma.polyfills.js"></script>
    <script src="/src/sigma.settings.js"></script>
    <script src="/src/classes/sigma.classes.dispatcher.js"></script>
    <script src="/src/classes/sigma.classes.configurable.js"></script>
    <script src="/src/classes/sigma.classes.graph.js"></script>
    <script src="/src/classes/sigma.classes.camera.js"></script>
    <script src="/src/classes/sigma.classes.quad.js"></script>
    <script src="/src/classes/sigma.classes.edgequad.js"></script>
    <script src="/src/captors/sigma.captors.mouse.js"></script>
    <script src="/src/captors/sigma.captors.touch.js"></script>
    <script src="/src/renderers/sigma.renderers.canvas.js"></script>
    <script src="/src/renderers/sigma.renderers.webgl.js"></script>
    <script src="/src/renderers/sigma.renderers.svg.js"></script>
    <script src="/src/renderers/sigma.renderers.def.js"></script>
    <script src="/src/renderers/webgl/sigma.webgl.nodes.def.js"></script>
    <script src="/src/renderers/webgl/sigma.webgl.nodes.fast.js"></script>
    <script src="/src/renderers/webgl/sigma.webgl.edges.def.js"></script>
    <script src="/src/renderers/webgl/sigma.webgl.edges.fast.js"></script>
    <script src="/src/renderers/webgl/sigma.webgl.edges.arrow.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.labels.def.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.hovers.def.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.nodes.def.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edges.def.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edges.curve.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edges.arrow.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edgehovers.def.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edgehovers.curve.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edgehovers.arrow.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.edgehovers.curvedArrow.js"></script>
    <script src="/src/renderers/canvas/sigma.canvas.extremities.def.js"></script>
    <script src="/src/renderers/svg/sigma.svg.utils.js"></script>
    <script src="/src/renderers/svg/sigma.svg.nodes.def.js"></script>
    <script src="/src/renderers/svg/sigma.svg.edges.def.js"></script>
    <script src="/src/renderers/svg/sigma.svg.edges.curve.js"></script>
    <script src="/src/renderers/svg/sigma.svg.labels.def.js"></script>
    <script src="/src/renderers/svg/sigma.svg.hovers.def.js"></script>
    <script src="/src/middlewares/sigma.middlewares.rescale.js"></script>
    <script src="/src/middlewares/sigma.middlewares.copy.js"></script>
    <script src="/src/misc/sigma.misc.animation.js"></script>
    <script src="/src/misc/sigma.misc.bindEvents.js"></script>
    <script src="/src/misc/sigma.misc.bindDOMEvents.js"></script>
    <script src="/src/misc/sigma.misc.drawHovers.js"></script>
    <!-- END SIGMA IMPORTS -->
    <script src="/plugins/sigma.plugins.neighborhoods/sigma.plugins.neighborhoods.js"></script>
    <script src="/plugins/sigma.layout.forceAtlas2/supervisor.js"></script>
    <script src="/plugins/sigma.layout.forceAtlas2/worker.js"></script>
    <script src="lib/jquery-2.1.1.min.js"></script>
    <script src="plugins/sigma.plugins.dragNodes/sigma.plugins.dragNodes.js"></script>

    <script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edges.dashed.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edges.dotted.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edges.parallel.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edges.tapered.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edgehovers.dashed.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edgehovers.dotted.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edgehovers.parallel.js"></script>
<script src="/plugins/sigma.renderers.customEdgeShapes/sigma.canvas.edgehovers.tapered.js"></script>

{{-- <script src="/plugins/sigma.plugins.neighborhoods/sigma.plugins.neighborhoods.js"></script> --}}
<script src="/plugins/sigma.layout.forceAtlas2/supervisor.js"></script>
<script src="/plugins/sigma.layout.forceAtlas2/worker.js"></script>
<script src="/lib/jquery-2.1.1.min.js"></script>

    <div id="container">
  <style>
    #graph-container {
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      position: absolute;
    }

    #sidebar {
      bottom: 0;
      right: 0;
      width: 200px;
      height: 150px;
      position: absolute;
      background-color: #999;
      padding: 10px;
    }
    /* #graph-container {
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      position: absolute;
      background-color: #455660;
    }
    .sigma-edge {
      stroke: #14191C;
    }
    .sigma-node {
      fill: green;
      stroke: #14191C;
      stroke-width: 2px;
    }
    .sigma-node:hover {
      fill: blue;
    }
    .muted {
      fill-opacity: 0.1;
      stroke-opacity: 0.1;
    } */
  </style>
  <div id="graph-container"></div>
  <div id="sidebar">This area is not a drop target.</div>
</div>
</head>
<body>
  
    <script>
        /**
         * This example shows how to use the dragNodes plugin.
         */
        var i,
            s,
            N = 10,
            E = 20,
            g = {
              nodes: [ 
                @foreach($mergeNode as $node)
                {
                  "id": "{{json_decode($node)->id}}",
                  "label": "{{json_decode($node)->label}}",
                  "x": "{{json_decode($node)->x}}",
                  "y": "{{json_decode($node)->y}}",
                  "size": "{{json_decode($node)->size}}",
                  "color": "{{json_decode($node)->color}}"
                },
                @endforeach
              ],
              edges: [
                @if(!is_null($mergeEdge)) 
                  @foreach($mergeEdge as $edge)
                  {
                    "id": "{{json_decode($edge)->id}}",
                    "source": "{{json_decode($edge)->source}}",
                    "target": "{{json_decode($edge)->target}}",
                    "color": "{{json_decode($edge)->color}}",
                    // "type": 'curve',
                    // "hover_color": '#000'
                  },
                  @endforeach
                @endif
              ]
            };
        
        // Generate a random graph:
        // for (i = 0; i < N; i++)
        //   g.nodes.push({
        //     id: 'n' + i,
        //     label: 'Node ' + i,
        //     x: Math.random(),
        //     y: Math.random(),
        //     size: Math.random(),
        //     color: '#666'
        //   });
        
        // for (i = 0; i < E; i++)
        //   g.edges.push({
        //     id: 'e' + i,
        //     source: 'n' + (Math.random() * N | 0),
        //     target: 'n' + (Math.random() * N | 0),
        //     size: Math.random(),
        //     color: '#ccc'
        //   });
        // sigma.renderers.def = sigma.renderers.canvas
        // Instantiate sigma:
        s = new sigma({
          graph: g,
          renderer: {
    container: document.getElementById('graph-container'),
    type: 'canvas'
  },
  settings: {
    doubleClickEnabled: false,
    minEdgeSize: 0.5,
    maxEdgeSize: 4,
    enableEdgeHovering: true,
    edgeHoverColor: 'edge',
    defaultEdgeHoverColor: '#000',
    edgeHoverSizeRatio: 1,
    edgeHoverExtremities: true,
  }
        });
        
        //Initialize the dr  agNodes plugin:
        var dragListener = sigma.plugins.dragNodes(s, s.renderers[0]);
        
        dragListener.bind('startdrag', function(event) {
          console.log(event);
        });
        dragListener.bind('drag', function(event) {
          console.log(event);
        });
        dragListener.bind('drop', function(event) {
          console.log(event);
        });
        dragListener.bind('dragend', function(event) {
          console.log(event);
        });

        // s.bind('overNode outNode clickNode doubleClickNode rightClickNode', function(e) {
        //   console.log(e.type, e.data.node.label, e.data.captor);
        // });
        // s.bind('overEdge outEdge clickEdge doubleClickEdge rightClickEdge', function(e) {
        //   console.log(e.type, e.data.edge, e.data.captor);
        // });
        // s.bind('clickStage', function(e) {
        //   console.log(e.type, e.data.captor);
        // });
        // s.bind('doubleClickStage rightClickStage', function(e) {
        //   console.log(e.type, e.data.captor);
        // });\
        // Instantiate sigma:
// s = new sigma({
//   graph: g,
//   settings: {
//     enableHovering: false
//   }
// });

// s.addRenderer({
//   id: 'main',
//   type: 'svg',
//   container: document.getElementById('graph-container'),
//   freeStyle: true
// });

// s.refresh();

// // Binding silly interactions
// function mute(node) {
//   if (!~node.getAttribute('class').search(/muted/))
//     node.setAttributeNS(null, 'class', node.getAttribute('class') + ' muted');
// }

// function unmute(node) {
//   node.setAttributeNS(null, 'class', node.getAttribute('class').replace(/(\s|^)muted(\s|$)/g, '$2'));
// }

// $('.sigma-node').click(function() {

//   // Muting
//   $('.sigma-node, .sigma-edge').each(function() {
//     mute(this);
//   });

//   // Unmuting neighbors
//   var neighbors = s.graph.neighborhood($(this).attr('data-node-id'));
//   neighbors.nodes.forEach(function(node) {
//     unmute($('[data-node-id="' + node.id + '"]')[0]);
//   });

//   neighbors.edges.forEach(function(edge) {
//     unmute($('[data-edge-id="' + edge.id + '"]')[0]);
//   });
// });

// s.bind('clickStage', function() {
//   $('.sigma-node, .sigma-edge').each(function() {
//     unmute(this);
//   });
// });
        </script>
        
</body>
</html>