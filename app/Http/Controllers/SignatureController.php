<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $json = Input::get('output'); // From Signature Pad
        $img = $this->sigJsonToImage($json, array('imageSize' => [400, 250]));;
        $img = imagepng($img, 'signature.png');
        return view('show');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sigJsonToImage ($json, $options = array()) {
        $defaultOptions = array(
            'imageSize' => array(198, 55)
        ,'bgColour' => array(0xff, 0xff, 0xff)
        ,'penWidth' => 2
        ,'penColour' => array(0x14, 0x53, 0x94)
        ,'drawMultiplier'=> 12
        );
        $options = array_merge($defaultOptions, $options);
        $img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);
        if ($options['bgColour'] == 'transparent') {
            imagesavealpha($img, true);
            $bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
        } else {
            $bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
        }
        $pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
        imagefill($img, 0, 0, $bg);
        if (is_string($json))
            $json = json_decode(stripslashes($json));
        foreach ($json as $v)
            $this->drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));
        $imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);
        if ($options['bgColour'] == 'transparent') {
            imagealphablending($imgDest, false);
            imagesavealpha($imgDest, true);
        }
        imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
        imagedestroy($img);
        return $imgDest;
    }
    /**
     *  Draws a thick line
     *  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result
     *
     *  @param object $img
     *  @param int $startX
     *  @param int $startY
     *  @param int $endX
     *  @param int $endY
     *  @param object $colour
     *  @param int $thickness
     *
     *  @return void
     */
    public function drawThickLine ($img, $startX, $startY, $endX, $endY, $colour, $thickness) {
        $angle = (atan2(($startY - $endY), ($endX - $startX)));
        $dist_x = $thickness * (sin($angle));
        $dist_y = $thickness * (cos($angle));
        $p1x = ceil(($startX + $dist_x));
        $p1y = ceil(($startY + $dist_y));
        $p2x = ceil(($endX + $dist_x));
        $p2y = ceil(($endY + $dist_y));
        $p3x = ceil(($endX - $dist_x));
        $p3y = ceil(($endY - $dist_y));
        $p4x = ceil(($startX - $dist_x));
        $p4y = ceil(($startY - $dist_y));
        $array = array(0=>$p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);
        imagefilledpolygon($img, $array, (count($array)/2), $colour);
    }
}
