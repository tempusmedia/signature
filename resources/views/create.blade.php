<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <title>jQuery Signature Pad Examples</title>
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font: normal 100.01%/1.375 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
    </style>
    <link href="{{ URL::to('/') }}/assets/jquery.signaturepad.css" rel="stylesheet">
    <!--[if lt IE 9]><script src="{{ URL::to('/') }}/assets/flashcanvas.js"></script><![endif]-->

</head>
<body>

<h1 style="margin-top:150px;">Digitalni potpis</h1>
{!!  Form::open(array('action' => 'SignatureController@store', 'method' => 'POST')) !!}
    <div class="sigPad" id="smoothed-variableStrokeWidth" style="width:404px;">

        <ul class="sigNav">
            <li class="drawIt"><a href="#draw-it" >Potpis</a></li>
            <li class="clearButton"><a href="#clear">Brisanje</a></li>
        </ul>
        <div class="sig sigWrapper" style="height:auto;">
            <div class="typed"></div>
            <canvas class="pad" width="400" height="250"></canvas>
            <input type="hidden" name="output" class="output">
        </div>
    </div>
    <button type="submit">Prihvaćam uvjete</button>
{!! Form::close() !!}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="{{ URL::to('/') }}/assets/numeric-1.2.6.min.js"></script>
<script src="{{ URL::to('/') }}/assets/bezier.js"></script>
<script src="{{ URL::to('/') }}/assets/jquery.signaturepad.js"></script>

<script>
    $(document).ready(function() {
        $('#linear').signaturePad({drawOnly:true, lineTop:200});
        $('#smoothed').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:200});
        $('#smoothed-variableStrokeWidth').signaturePad({drawOnly:true, drawBezierCurves:true, variableStrokeWidth:true, lineTop:200});
    });
</script>
<script src="{{ URL::to('/') }}/assets/json2.min.js"></script>


</body>
