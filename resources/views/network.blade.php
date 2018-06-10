<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Network | node as icon</title>

  <script type="text/javascript" src="dist/vis.js"></script>
  <link href="dist/vis-network.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <style>
 #mynetworkIO {
  height: 97vh;
  width: 97vw;
  border:1px solid lightgrey;
}
body{
  margin: 0px;
}
#loadingBar {
        position: fixed;;
        top:0px;
        left:0px;
        width: 100%;
        height: 100%;
        background-color:rgba(200,200,200,0.8);
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        opacity:1;
    }
    #wrapper {
        position:relative;
        width:900px;
        height:900px;
    }
    #text {
        position:absolute;
        top:8px;
        left:530px;
        width:30px;
        height:50px;
        margin:auto auto auto auto;
        font-size:22px;
        color: #000000;
    }


    div.outerBorder {
        position:relative;
        top:400px;
        width:600px;
        height:44px;
        margin:auto auto auto auto;
        border:8px solid rgba(0,0,0,0.1);
        background: rgb(252,252,252); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(252,252,252,1) 0%, rgba(237,237,237,1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(252,252,252,1)), color-stop(100%,rgba(237,237,237,1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  rgba(252,252,252,1) 0%,rgba(237,237,237,1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  rgba(252,252,252,1) 0%,rgba(237,237,237,1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  rgba(252,252,252,1) 0%,rgba(237,237,237,1) 100%); /* IE10+ */
        background: linear-gradient(to bottom,  rgba(252,252,252,1) 0%,rgba(237,237,237,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#ededed',GradientType=0 ); /* IE6-9 */
        border-radius:72px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    }

    #border {
        position:absolute;
        top:10px;
        left:10px;
        width:500px;
        height:23px;
        margin:auto auto auto auto;
        box-shadow: 0px 0px 4px rgba(0,0,0,0.2);
        border-radius:10px;
    }

    #bar {
        position:absolute;
        top:0px;
        left:0px;
        width:20px;
        height:20px;
        margin:auto auto auto auto;
        border-radius:11px;
        border:2px solid rgba(30,30,30,0.05);
        background: rgb(0, 173, 246); /* Old browsers */
        box-shadow: 2px 0px 4px rgba(0,0,0,0.4);
    }
    .data {
    width: 400px;
    min-height: 90px;
    height: auto;
    position: fixed;
    left: 0;
    top: 0;
    background: #e7e7e7;
    border-radius: 5px;
    transition: all .6s;
    transform: translateX(-100%);
}
  </style>
  
  <script language="JavaScript">
    
    function draw() {

      // create an array with edges
      var edges = [
      @if(!is_null($mergeEdge)) 
        @foreach($mergeEdge as $edge) 
        { 
          @if(!array_key_exists('factoids', $edge))
          "id": "{{$edge['id']}}",
          "from": "{{$edge['source']}}",
          "to": "{{$edge['target']}}",
          @if($edge['source'] == $edge['target'])hidden:true @endif
          @endif
          // "type": 'curve',
          // "hover_color": '#000'
        },
        @endforeach
      @endif
    ];




      /*
       * Example for Ionicons
       */
      var optionsIO = {
        // interaction:{hover:true},
        // manipulation: {
        //   enabled: true
        // }

        groups: {
          @foreach($mergeNode as $node)
          @if(array_key_exists('factoid', $node))
          {{$node['group']}} : {
            interaction:{hover:false},
            manipulation: {
              enabled: false
            },
            shape: 'icon',
            physics:true,
            icon: {
              face: 'FontAwesome',
              code: "\uf0c0",
              size: 40,
              color: '#aa47ff'
            },
            
            font: {
              size: 10,
              hidden: false
            },
          
          },
          @endif            
          @endforeach
        }
      };

      var nodesIO = [
      @foreach($mergeNode as $node)
        @if($loop->last)
        {
        id: {{$node['id']}},
        title: "{!!$node['label']!!} ",
        // title: 'ილია ჭავჭავაძე',
        shape: 'icon',
        x:0, 
        y:0, 
        fixed:true,
        // type: 'curve',
        icon: {
          face: 'Ionicons',
          code: '\uf47e',
          size: 90,
          color: '#f0a30a'
        }
        },
        @else
          {
          id: {{$node['id']}},
          title: "{!!$node['label']!!} ",
          shape: 'icon',
            icon: {
              face: 'Ionicons',
              code: '\uf47e',
              size: 40,
              color: 'teal'
            },
          
          @if(array_key_exists('factoid',$node))group: '{{$node['group']}}', @endif
          },
        @endif
        @endforeach
    ];

      // create a network
      var containerIO = document.getElementById('mynetworkIO');
      var dataIO = {
        nodes: nodesIO,
        edges: edges
      };

      var networkIO = new vis.Network(containerIO, dataIO, optionsIO);
      // networkIO.on("click", function (params) {
      //  this.groups.groups.users.font.size = 30;
      //  console.log(this.groups.groups.users.font.size = 30);

      // });

      networkIO.on("stabilizationProgress", function(params) {
          var maxWidth = 496;
          var minWidth = 20;
          var widthFactor = params.iterations/params.total;
          var width = Math.max(minWidth,maxWidth * widthFactor);

          document.getElementById('bar').style.width = width + 'px';
          document.getElementById('text').innerHTML = Math.round(widthFactor*100) + '%';
      });
      // networkIO.on("click", function (data) {
        
      //     insert_data(object["a" + data.nodes]);
      // });
      networkIO.once("stabilizationIterationsDone", function() {
          document.getElementById('text').innerHTML = '100%';
          document.getElementById('bar').style.width = '496px';
          document.getElementById('loadingBar').style.opacity = 0;
          // really clean the dom element
          setTimeout(function () {document.getElementById('loadingBar').style.display = 'none';}, 500);
      });
    };

    var object = {
    @foreach($mergeNode as $node)
        {{'a'.$node['id']}}: " {{$node['label']}} ",
    @endforeach
    };
    // function insert_data(text) {
    //   let data_input = document.querySelector('.data');
    //   data_input.style.transform = "translateX(0)";
    //   data_input.innerHTML = text;

    // }
  </script>
  
</head>
<body onload="draw()">
  <div class="data"></div>
<div id="mynetworkIO"></div>
<div id="wrapper">
  <div id="mynetwork"></div>
  <div id="loadingBar">
      <div class="outerBorder">
          <div id="text">0%</div>
          <div id="border">
              <div id="bar"></div>
          </div>
      </div>
  </div>
</div>
</body>
</html>